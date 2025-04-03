<?php

namespace Liamtseva\PGFKEduSystem\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'grades';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'student_id',
        'subject_id',
        'grade',
        'is_failed',
        'exam_date',
        'semester',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_failed' => 'boolean',
        'exam_date' => 'date',
    ];

    /**
     * Get the student that owns the grade.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Get the subject that owns the grade.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    /**
     * Check if the grade represents a failed subject.
     *
     * @return bool
     */
    public function isFailed(): bool
    {
        return $this->is_failed;
    }

    /**
     * Get the formatted exam date.
     *
     * @return string|null
     */
    public function getFormattedExamDateAttribute(): ?string
    {
        return $this->exam_date ? $this->exam_date->format('d.m.Y') : null;
    }

    /**
     * Scope a query to only include failed grades.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFailed($query)
    {
        return $query->where('is_failed', true);
    }
}
