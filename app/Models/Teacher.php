<?php

namespace Liamtseva\PGFKEduSystem\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'teachers';

    protected $fillable = [
        'id',
        'user_id',
        'qualification',
        'department',
        'phone_number',
        'experience_years',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
