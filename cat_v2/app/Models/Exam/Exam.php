<?php

namespace App\Models\Exam;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Exam extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'exam_group_id',
        'category_id',
        'lesson_category_id',
        'lesson_id',
        'question_title_id',
        'title',
        'description',

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

        'access_type',
        'percentage_grade',
        'repeat_the_exam',
        'exam_status',
        'total_tolerance',
    ];

    public function category()
    {
        return $this->belongsTo(\App\Models\MasterData\Category::class);
    }

    public function lessonCategory()
    {
        return $this->belongsTo(\App\Models\Lesson\LessonCategory::class);
    }

    public function lesson()
    {
        return $this->belongsTo(\App\Models\Lesson\Lesson::class);
    }

    public function questionTitle()
    {
        return $this->belongsTo(\App\Models\Lesson\QuestionTitle::class);
    }

    public function grade()
    {
        return $this->hasMany(\App\Models\Exam\Grade::class);
    }

    public function gradeFinished()
    {
        return $this->hasMany(\App\Models\Exam\Grade::class)->where('is_finished', 1);
    }

    public function subCategories()
    {
        return $this->belongsToMany(\App\Models\MasterData\SubCategory::class);
    }
}
