<?php

namespace Liamtseva\PGFKEduSystem\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Liamtseva\PGFKEduSystem\Enums\Role;

class Student extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'students';

    protected $fillable = [
        'user_id',
        'last_name',
        'first_name',
        'middle_name',
        'record_book_number',
        'group_id',
        'email',
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
    public function isStudent(): bool
    {
        return $this->role->value === Role::STUDENT->value;
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
}

