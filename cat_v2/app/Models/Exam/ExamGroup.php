<?php

namespace App\Models\Exam;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class ExamGroup extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'category_id',
        'lesson_category_id',
        'title',
        'description',

        'exam_group_type',
        'duration',
        'random_question',
        'random_answer',
        'show_answer',
        'show_question_number_navigation',
        'show_question_number',
        'next_question_automatically',
        'show_prev_next_button',
        'type_option',
        'button_type_finish',
        'repeat_the_exam',
        'total_tolerance',

        'assessment_type',
        'minimal_grade_type',
        'minimal_grade',
        'description_grade_less_than_minimal',
        'description_grade_more_than_minimal',
        'smallest_value_limit',
        'biggest_value_limit',
        'access_type',
        'certificate_print_user',
        'exam_status',    
    ];

    public function category()
    {
        return $this->belongsTo(\App\Models\MasterData\Category::class);
    }

    public function lessonCategory()
    {
        return $this->belongsTo(\App\Models\Lesson\LessonCategory::class);
    }

    public function exam()
    {
        return $this->hasMany(\App\Models\Exam\Exam::class);
    }

    public function examGroupUser()
    {
        return $this->hasMany(\App\Models\Exam\ExamGroupUser::class);
    }

    public function grade()
    {
        return $this->hasMany(\App\Models\Exam\Grade::class);
    }

    public function subCategories()
    {
        return $this->belongsToMany(\App\Models\MasterData\SubCategory::class);
    }
}
