<?php

namespace Liamtseva\PGFKEduSystem\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Liamtseva\PGFKEduSystem\Enums\Department;

class Course extends Model
{
    use HasFactory, HasUlids;

    /**
     * Назва таблиці в БД.
     *
     * @var string
     */
    protected $table = 'courses';

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


}
