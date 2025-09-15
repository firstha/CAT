<?php

namespace App\Models\Lesson;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class QuestionTitle extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'category_id',
        'lesson_category_id',
        'lesson_id',
        'name',
        'total_choices',
        'total_section',
        'add_value_category',
        'assessment_type',
        'show_answer',
        'passing_grade',
        'minimum_grade',
        'created_at',
        'updated_at',
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

    public function question()
    {
        return $this->hasMany(\App\Models\Lesson\Question::class);

    }
    public function exams()
    {
        return $this->hasMany(\App\Models\Exam\Exam::class, 'question_title_id');
    }
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByLessonCategory($query, $lessonCategoryId)
    {
        return $query->where('lesson_category_id', $lessonCategoryId);
    }

    public function scopeByLesson($query, $lessonId)
    {
        return $query->where('lesson_id', $lessonId);
    }

    public function resetExamStatuses()
    {
        return $this->exams()->update([
            'exam_status' => 'active'
        ]);
    }
}