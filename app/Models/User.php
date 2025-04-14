<?php

namespace Liamtseva\PGFKEduSystem\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Liamtseva\PGFKEduSystem\Enums\Gender;
use Liamtseva\PGFKEduSystem\Enums\Role;

class User extends Authenticatable implements MustVerifyEmail,FilamentUser
{
    use HasFactory, Notifiable, HasUlids;
    protected $table = 'users';
    /**
     * Масово заповнювані атрибути.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'role',
        'gender',
    ];

    /**
     * Атрибути, які повинні бути приховані.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function isAuthenticated(): bool
    {
        return auth()->check();  // Перевіряє, чи користувач аутентифікований
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
    /**
     * Автоматичне приведення типів.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => Role::class,
        'gender' => Gender::class,
    ];
}
