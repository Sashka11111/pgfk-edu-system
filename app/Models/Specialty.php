<?php

namespace Liamtseva\PGFKEduSystem\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Liamtseva\PGFKEduSystem\Enums\Department;

class Specialty extends Model
{
    use HasFactory, HasUlids;

    /**
     * Назва таблиці в БД.
     *
     * @var string
     */
    protected $table = 'specialties';

    /**
     * Масово заповнювані атрибути.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'code',
        'department',
        'description',
    ];

    /**
     * Автоматичне приведення типів.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'department' => Department::class, // Enum приведення
    ];
}
