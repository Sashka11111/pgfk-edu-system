<?php

namespace Liamtseva\PGFKEduSystem\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Liamtseva\PGFKEduSystem\Enums\Department;

class Subject extends Model
{
    use HasFactory, HasUlids;

    /**
     * Назва таблиці в БД.
     *
     * @var string
     */
    protected $table = 'subjects';

    /**
     * Масово заповнювані атрибути.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'description',
        'hours',
    ];
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'subject_teacher', 'subject_id', 'teacher_id')
            ->withTimestamps();
    }
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_subject', 'subject_id', 'group_id')
            ->withTimestamps();
    }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_subject')
            ->withTimestamps();
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'subject_id');
    }

    // Метод для отримання студентів, які не зарахували цей предмет
    public function failedStudents()
    {
        return $this->students()->whereHas('grades', function ($query) {
            $query->where('is_failed', true);
        });
    }
}
