<?php

namespace Liamtseva\PGFKEduSystem\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Liamtseva\PGFKEduSystem\Enums\StudyForm;

class Group extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'groups';

    protected $fillable = [
        'id',
        'name',
        'year_of_study',
        'study_form',
        'specialty_id',
        'teacher_id',
    ];

    /**
     * Отримати спеціальність, до якої належить група.
     */
    public function specialty()
    {
        return $this->belongsTo(Specialty::class, 'specialty_id');
    }

    /**
     * Отримати викладача-куратора групи.
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'group_subject', 'group_id', 'subject_id')
            ->withTimestamps();
    }
    /**
     * Отримати студентів, які входять до групи.
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    protected $casts = [
        'study_form' => StudyForm::class, // Enum приведення
    ];
}
