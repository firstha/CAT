<?php

namespace App\Http\Controllers\User\TryOut;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Exam\ExamRepository;
use DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Exam\Grade;
use App\Models\Lesson\Question;
use App\Models\Lesson\QuestionTitle;
use App\Repositories\Lesson\LessonRepository;
use App\Models\Lesson\{DetailValueCategory, ValueCategory};
use Carbon\Carbon;
use App\Models\Exam\ExamGroup;
use App\Models\Exam\Exam;
use Auth;
use App\Models\Transaction\Transaction;
use App\Models\Exam\ExamGroupUser;
use App\Models\Setting;
use File;

class ExamController extends Controller
{
    protected $examRepository;

    public function __construct(ExamRepository $examRepository)
    {
        $this->examRepository = $examRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $categoryId, $lessonCategoryId, $lessonId)
    {
        return inertia('User/TryOut/Exam/Index', [
            'exams' => $this->examRepository->getAllByLessonPaginatedWithParams($request, $lessonId, 8),
            'categoryId' => $categoryId,
            'lessonCategoryId' => $lessonCategoryId,
            'lessonId' => $lessonId,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($categoryId, $lessonCategoryId, $lessonId, $id)
    {
        $grade = Grade::where('exam_id', $id)->where('user_id', auth()->user()->id)->first();

        return inertia('User/TryOut/Exam/Show', [
            'exam' => $this->examRepository->find($id),
            'grade' => $grade
        ]);
    }

    public function examStart($id, Request $request)
{
    DB::beginTransaction();

    try {
        $exam = Exam::findOrFail($id);

        if (Auth::user()->member_type == 2) {
            $transactions = Transaction::where([
                'user_id' => Auth::user()->id,
                'voucher_used' => 1,
                'category_id' => $exam->category_id
            ])
            ->where('voucher_expired_date', '>', Carbon::now())
            ->get();

            $setting = Setting::first() ?? [];

            if ($setting && $setting->add_voucher_purchase == 1) {
                if ($transactions->count() == 0) {
                    return redirect()->back()->with('error', 'Anda tidak memiliki akses member aktif untuk pembelajaran <b>' . strtoupper(strtolower($exam->category->name)) . '</b>, silakan pilih paket voucher kategori <b>' . strtoupper($exam->category->name) . '</b> terlebih dahulu.');
                }

                $startExam = false;

                foreach ($transactions as $transaction) {
                    $members = ['basic_member', 'standard_member', 'premium_member'];
                    $userMember = array_search($transaction->voucher_access_type, $members);
                    $examMember = array_search($exam->access_type, $members);

                    if ($examMember <= $userMember) {
                        $startExam = true;
                    }
                }

                if (!$startExam) {
                    return redirect()->back()->with('error', 'Try Out ini hanya bisa diakses minimal dengan jenis <b>' . ucwords(str_replace("_", " ", $exam->access_type)) . '</b> kategori <b>' . $exam->category->name . '</b>');
                }

                $examUse = $exam->exam_group_id
                    ? ExamGroup::with(['subCategories'])->find($exam->exam_group_id)
                    : $exam;

                if (count($examUse->subCategories) > 0) {
                    $collection = collect($transactions);
                    $existingSubCategories = [];

                    $filteredResponse = $collection->map(function ($item) use (&$existingSubCategories) {
                        $subCategories = $item['voucher_sub_categories'];

                        $filtered = collect($subCategories)->filter(function ($subCategory) use (&$existingSubCategories) {
                            if (!in_array($subCategory['id'], $existingSubCategories)) {
                                $existingSubCategories[] = $subCategory['id'];
                                return true;
                            }
                            return false;
                        })->values()->all();

                        $item['voucher_sub_categories'] = $filtered;
                        return $item;
                    });

                    $subCategoryAccess = collect($filteredResponse->pluck('voucher_sub_categories')->flatten(1))->pluck('id');
                    $collection1 = collect($examUse->subCategories->pluck('id'));
                    $intersect = $collection1->intersect($subCategoryAccess);

                    if (!$intersect->isNotEmpty()) {
                        $subCategoriesText = $examUse->subCategories->pluck('name')->implode(', ');

                        return redirect()->back()->with('error', 'Try Out ini hanya bisa diakses minimal dengan jenis <b>' . ucwords(str_replace("_", " ", $examUse->access_type)) . '</b> kategori <b>' . $exam->category->name . '</b> dengan sub peminatan <b>' . $subCategoriesText . '</b>');
                    }
                }
            }
        }

        $this->removeOldFiles();

        if (!empty($exam->exam_group_id)) {
            ExamGroupUser::updateOrCreate(
                ['exam_group_id' => $exam->exam_group_id, 'user_id' => Auth::user()->id],
                ['is_finished' => 0, 'grade' => 0, 'grade_calculate' => 0, 'description' => null]
            );
        }

        $gradeQuery = Grade::where('exam_id', $id)->where('user_id', Auth::id());

        if ($request->repeat == 1) {
            $gradeQuery->delete();
        }

        $totalSection = optional(QuestionTitle::find($exam->question_title_id))->total_section ?? 1;

        $grade = $gradeQuery->first();

        if (!$grade) {
            $grade = new Grade();
            $grade->category_id = $exam->category_id;
            $grade->lesson_category_id = $exam->lesson_category_id;
            $grade->lesson_id = $exam->lesson_id;
            $grade->exam_id = $exam->id;
            $grade->exam_group_id = $exam->exam_group_id;
            $grade->user_id = Auth::id();
            $grade->duration = $exam->duration;
            $grade->total_tolerance = $exam->total_tolerance;
            $grade->total_section = $totalSection;
            $grade->start_time = now();
            $grade->end_time = now()->addMinutes($exam->duration);
            $grade->answers = [];
            $grade->save();
            $grade->refresh();
        }

        $path = 'json/' . Auth::id() . '-' . $exam->id . '-' . $exam->exam_group_id . '.json';
        Storage::disk('local')->makeDirectory('json');
        Storage::delete($path);

        if (!Storage::exists($path)) {
            $question_order = 0;
            $navigation_order = 0;

            $query = DB::table('questions')->where('question_title_id', $exam->question_title_id);
            $questions = $exam->random_question == 1
                ? $query->inRandomOrder()->get()
                : $query->orderBy('created_at', 'ASC')->get();

            foreach ($questions as $question) {
                $navigation_order++;
                $question_order++;

                $options = collect([
                    $question->option_1 ? 1 : null,
                    $question->option_2 ? 2 : null,
                    $question->option_3 ? 3 : null,
                    $question->option_4 ? 4 : null,
                    $question->option_5 ? 5 : null,
                ])->filter()->all();

                if ($exam->random_answer == 1) {
                    shuffle($options);
                }

                $question->question_id = $question->id;
                $question->navigation_order = $navigation_order;
                $question->question_order = $question_order;
                $question->question_answer = $question->answer;
                $question->answer_order = implode(",", $options);
                $question->answer = 0;
                $question->is_correct = 'N';
            }

            Storage::put($path, json_encode($questions));
        }

        DB::commit();

        return redirect()->route('user.exams.exam-show-questions', [$grade->exam_id, $grade->id, $grade->section]);

    } catch (\Exception $e) {
        DB::rollBack();

        \Log::error('Exam Start Error', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()->back()->with('error', 'Terjadi kesalahan saat memulai ujian. Silakan coba lagi. (' . $e->getMessage() . ')');
    }
}


    public function examShowQuestion($examId, $gradeId, $section, Request $request)
    {
        try {
            $exam = Exam::find($examId);

            $path = 'json/' . Auth::user()->id . '-' . $exam->id .'-'.$exam->exam_group_id . '.json';

            if (!Storage::exists($path)) {
                return redirect()->route('user.exams.exam-start', $exam->id);
            }
            
            $grade = Grade::find($gradeId);

            if ($grade->is_finished == 1) {
                return redirect()->route('user.categories.lesson-categories.lessons.exams.show', [
                    $exam->category_id, $exam->lesson_category_id, $exam->lesson_id, $exam->id
                ]);
            }

            if ($section != $grade->section && empty($request->nextsection)) {
                return redirect()->route('user.exams.exam-show-questions', [$grade->exam_id, $grade->id, $grade->section]);
            }

            if ($grade->section < $section) {
                $grade->update([
                    'section' => $grade->section + 1,
                    'end_time' => Carbon::now()->addMinutes($exam->duration),
                ]);
                $grade->refresh();
            }

            $duration = ($grade->end_time > Carbon::now() || empty($grade->end_time)) ? $grade->end_time->diffInMilliseconds(Carbon::now()) : 0;

            $path = 'json/' . Auth::user()->id . '-' . $exam->id . '-' . $exam->exam_group_id . '.json';
            $json = Storage::get($path);
            $gradeAnswers = json_decode($json, true);

            $questionLists = array_values(array_filter($gradeAnswers, fn($var) => $var['section'] == $section));
            $totalQuestions = count($questionLists);

            return inertia('User/TryOut/Exam/Question', [
                'exam' => $exam,
                'grade' => $grade,
                'questionLists' => $questionLists,
                'duration' => $duration,
                'section' => (int)$grade->section,
                'indexPage' => 0,
                'lastSection' => (int)$grade->total_section,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * decrementTolerance
     *
     * @param  mixed $request
     * @return void
     */
    public function decrementTolerance(Request $request)
    {
        $grade = Grade::find($request->grade_id);
        $total_tolerance = $grade->total_tolerance > 0 ? $grade->total_tolerance - 1 : 0 ;
        $is_blocked = $total_tolerance <= 0 ? 1 : 0;
        $grade->update(['total_tolerance' => $total_tolerance, 'is_blocked' => $is_blocked]);
    }

    /**
     * endExam
     *
     * @param  mixed $request
     * @return void
     */
    public function endExam($examId, Request $request)
{
    DB::beginTransaction();

    try {
        $exam = Exam::findOrFail($examId);
        $grade = Grade::findOrFail($request->grade_id);

        $grade->update(['answers' => $request->myAnswers]);

        $path = 'json/' . Auth::user()->id . '-' . $exam->id . '-' . $exam->exam_group_id . '.json';
        if (!Storage::exists($path)) {
            return redirect()->route('user.exams.exam-start', $exam->id);
        }

        $json = Storage::get($path);
        $gradeAnswers = json_decode($json, true);

        $gradeAnswers = array_map(function ($gradeAnswer) use ($grade) {
            $data = collect($grade->answers)->firstWhere('question_id', $gradeAnswer['question_id']);

            if ($data) {
                $gradeAnswer['user_answer'] = (int) $data['answer'];
                $gradeAnswer['is_correct'] = (int) $data['answer'] === (int) $gradeAnswer['question_answer'] ? "Y" : "N";
            } else {
                $gradeAnswer['user_answer'] = null;
                $gradeAnswer['is_correct'] = "N";
            }

            return $gradeAnswer;
        }, $gradeAnswers);

        $totalCorrectPerSection = array_reduce(range(1, $exam->questionTitle->total_section), function ($carry, $i) use ($gradeAnswers) {
            $totalCorrect = array_filter($gradeAnswers, fn($var) => $var['is_correct'] === "Y" && $var['section'] == $i);
            $carry[] = count($totalCorrect);
            return $carry;
        }, []);

        $totalCorrect = array_filter($gradeAnswers, fn($var) => $var['is_correct'] === "Y" && !empty($var['user_answer']));
        $totalAnswer  = array_filter($gradeAnswers, fn($var) => !empty($var['user_answer']));

        $count_correct_answer = count($totalCorrect);
        $totalQuestionGrade   = count($gradeAnswers);

        $grade_exam = 0;
        if ($exam->questionTitle->assessment_type == 3) {
            $grade_exam = array_reduce($totalCorrect, fn($carry, $correct) => $carry + $correct['correct_point'], 0);
        } elseif ($exam->questionTitle->assessment_type == 4) {
            $grade_exam = array_reduce($totalAnswer, fn($carry, $ans) => $carry + $ans['point_' . $ans['user_answer']], 0);
        } else {
            $grade_exam = $count_correct_answer == 0 ? 0 : round($count_correct_answer / $totalQuestionGrade * 100, 2);
        }

        $updates = [
            'end_time' => now(),
            'total_correct' => $count_correct_answer,
            'grade' => $grade_exam,
            'is_finished' => 1,
            'answers' => serialize($gradeAnswers),
            'total_correct_per_section' => $totalCorrectPerSection,
        ];

        $examGroup = ExamGroup::with([
            'grade' => fn($q) => $q->where('user_id', Auth::id()),
        ])->withCount(['exam', 'grade'])->find($exam->exam_group_id);

        if ($examGroup && $examGroup->assessment_type == 2) {
            $updates['percentage_grade'] = $exam->percentage_grade ?? 0;
            $updates['final_grade'] = $grade_exam * ($updates['percentage_grade'] / 100);
        } else {
            $updates['final_grade'] = $grade_exam;
        }

        $grade->update($updates);

        DB::commit();

        return $examGroup
            ? redirect()->route('user.exam_group.show', [$examGroup->category_id, $examGroup->lesson_category_id, $examGroup->id])
            : redirect()->route('user.categories.lesson-categories.lessons.exams.show', [$exam->category_id, $exam->lesson_category_id, $exam->lesson_id, $exam->id]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


    public function removeOldFiles()
    {
        $directoryPath = storage_path('app/json');
        $currentDate = Carbon::now();
        $thresholdDate = $currentDate->subDays(1);

        $oldFiles = [];
        $allFiles = File::allFiles($directoryPath);

        foreach ($allFiles as $file) {
            $fileCreationTime = Carbon::createFromTimestamp($file->getCTime());
            if ($fileCreationTime->lessThan($thresholdDate)) {
                $oldFiles[] = $file->getPathname();
            }
        }

        foreach ($oldFiles as $file) {
            File::delete($file);
        }
    }
   public function review($examId, $gradeId)
{
    $grade = Grade::findOrFail($gradeId);
    $exam  = Exam::findOrFail($examId);

    if ($grade->is_finished != 1) {
        return redirect()->route('user.exams.exam-show-questions', [$grade->exam_id, $grade->id, $grade->section]);
    }

    $path = 'json/' . Auth::user()->id . '-' . $exam->id . '-' . $exam->exam_group_id . '.json';
    if (!Storage::exists($path)) {
        return redirect()->back()->with('error', 'Data jawaban tidak ditemukan.');
    }

    $json = Storage::get($path);
    $questionAnswers = json_decode($json, true);

    $userAnswers = is_string($grade->answers) 
        ? unserialize($grade->answers) 
        : $grade->answers;
    $userAnswers = collect($userAnswers);

    $questionAnswers = array_map(function ($q) use ($userAnswers) {
        $userAnswer = $userAnswers->firstWhere('question_id', $q['question_id']);

        $q['user_answer'] = $userAnswer['user_answer'] ?? $userAnswer['answer'] ?? null;
        $q['is_correct']  = ($q['question_answer'] == $q['user_answer']) ? "Y" : "N";

        return $q;
    }, $questionAnswers);

    return inertia('User/TryOut/Exam/Review', [
        'exam' => $exam,
        'grade' => $grade,
        'questions' => $questionAnswers,
    ]);
}

}
