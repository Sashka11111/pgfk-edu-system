<?php

namespace Liamtseva\PGFKEduSystem\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Liamtseva\PGFKEduSystem\Enums\Qualification;

class Teacher extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'teachers';

    protected $fillable = [
        'id',
        'user_id',
        'qualification',
        'phone_number',
        'experience_years',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    protected $casts = [
        'qualification' => Qualification::class,
    ];
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher', 'teacher_id', 'subject_id')
            ->withTimestamps();
    }
}
