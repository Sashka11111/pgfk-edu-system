<?php

namespace Liamtseva\PGFKEduSystem\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Student extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'students';

    protected $fillable = [
        'user_id',
        'record_book_number',
        'group_id',
        'enrollment_date',
        'is_scholarship_holder',
        'birthplace',
        'birthdate',
        'phone_number',
        'address',
        'guardian_name',
        'guardian_phone',
    ];

    /**
     * Отримати користувача, до якого належить студент.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Отримати групу, до якої належить студент.
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject')
            ->withTimestamps();
    }
    public function grades()
    {
        return $this->hasMany(Grade::class, 'student_id');
    }

    // Метод для отримання незарахованих предметів
    public function failedSubjects()
    {
        return $this->subjects()->whereHas('grades', function ($query) {
            $query->where('is_failed', true);
        });
    }
}

