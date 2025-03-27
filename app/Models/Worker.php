<?php

namespace Liamtseva\PGFKEduSystem\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Worker extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'workers';

    protected $fillable = [
        'user_id',
        'position',
        'phone_number',
    ];

    /**
     * Отримати користувача, який є адміністратором.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

