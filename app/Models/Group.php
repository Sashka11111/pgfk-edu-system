<?php

namespace Liamtseva\PGFKEduSystem\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'groups';

    protected $fillable = [
        'id',
        'name',
        'year_of_study',
        'specialty_id',
        'teacher_id',
    ];

    /**
     * Отримати спеціальність, до якої належить група.
     */
    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    /**
     * Отримати викладача-куратора групи.
     */
    public function curator()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    /**
     * Отримати студентів, які входять до групи.
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
