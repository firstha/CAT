<?php

namespace App\Repositories\Exam;

use App\Models\Exam\Exam;
use App\Repositories\Contracts\Exam\ExamInterface;
use App\Repositories\BaseRepository;

class ExamRepository extends BaseRepository implements ExamInterface
{
    /**
     * @var
     */
    protected $model;

    public function __construct()
    {
        $this->model = new Exam();
    }

    public function all($columns = ['*'])
    {
        return $this->model->orderBy('created_at', 'ASC')->get($columns);
    }

    public function getAllSimplePaginatedWithParams($params, $limit = 10)
    {
        $exams = $this->model;
        if(isset($params->search) && !empty($params->search)) $exams->where('title', 'like', '%' . $params->search . '%');
        $exams = $exams->orderBy('created_at', 'ASC')->simplePaginate($limit);
        return $exams;
    }

    public function getAllPaginatedWithParams($params, $limit = 10)
    {
        $exams = $this->model->query();
        if(isset($params->search) && !empty($params->search)) $exams->where('title', 'like', '%' . $params->search . '%');
        if(isset($params->category_id) && !empty($params->category_id)) $exams->where('category_id', $params->category_id);
        if(isset($params->lesson_category_id) && !empty($params->lesson_category_id)) $exams->where('lesson_category_id', $params->lesson_category_id);
        if(isset($params->lesson_id) && !empty($params->lesson_id)) $exams->where('lesson_id', $params->lesson_id);

        $exams = $exams->whereNull('exam_group_id')->withCount('gradeFinished')->with(['category', 'lessonCategory', 'lesson', 'questionTitle'])->orderBy('created_at', 'ASC')->paginate($limit);
        
        $exams->appends([
            'search' => $params->search,
            'category_id' => $params->category_id,
            'lesson_category_id' => $params->lesson_category_id,
            'lesson_id' => $params->lesson_id,
        ]);

        return $exams;
    }

    public function getAllByLessonPaginatedWithParams($params, $lessonId, $limit = 10)
    {
        $exams = $this->model;
        if(isset($params->search) && !empty($params->search)) $exams->where('title', 'like', '%' . $params->search . '%');
        $exams = $exams->where('lesson_id', $lessonId)->whereNull('exam_group_id')->withCount('gradeFinished')->with(['category', 'lessonCategory', 'lesson', 'questionTitle', 'subCategories'])->orderBy('created_at', 'ASC')->paginate($limit);
        return $exams;
    }

    public function getByExamGroupPaginatedWithParams($params, $examGroupId, $limit = 10)
    {
        $exams = $this->model;
        if(isset($params->search) && !empty($params->search)) $exams->where('title', 'like', '%' . $params->search . '%');
        $exams = $exams->where('exam_group_id', $examGroupId)->withCount('gradeFinished')->withCount('grade')->with(['category', 'lessonCategory', 'lesson', 'questionTitle'])->orderBy('created_at', 'ASC')->paginate($limit);
        return $exams;
    }

    public function find($id)
    {
        return $this->model->with(['category', 'lessonCategory', 'lesson', 'questionTitle', 'subCategories'])->find($id);
    }

    public function create($attributes)
    {
        $input = $attributes->all();
        $exam = $this->model->create($input);

        if(!$attributes->exam_group_id) {
            $subCategoryIds = [];

            foreach ($attributes->sub_category_ids as $subCategory) {
                $subCategoryIds[] = $subCategory['id'];
            }
            
            $exam->subCategories()->sync($subCategoryIds);
        }

        return $exam;
    }

    public function update($attributes, $id)
    {
        $input = $attributes->except('_token','_method');
        $exam = $this->find($id);
        $exam->update($input);

        if(!$attributes->exam_group_id) {
            $subCategoryIds = [];

            foreach ($attributes->sub_category_ids as $subCategory) {
                $subCategoryIds[] = $subCategory['id'];
            }
            
            $exam->subCategories()->sync($subCategoryIds);
        }

        return $exam;
    }
}
