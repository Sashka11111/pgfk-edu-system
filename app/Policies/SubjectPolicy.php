<?php

namespace Liamtseva\PGFKEduSystem\Policies;

use Liamtseva\PGFKEduSystem\Enums\Role;
use Liamtseva\PGFKEduSystem\Models\User;
use Liamtseva\PGFKEduSystem\Models\Subject;

class SubjectPolicy
{
    /**
     * Адміністратор має доступ до всього.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->role === Role::ADMIN->value) {
            return true;
        }

        return null;
    }

    /**
     * Перевіряє, чи може користувач переглядати список предметів.
     */
    public function viewAny(User $user): bool
    {
        return true; // Доступно всім авторизованим користувачам
    }

    /**
     * Перевіряє, чи може користувач переглядати конкретний предмет.
     */
    public function view(User $user, Subject $subject): bool
    {
        return true; // Доступно всім (можна змінити логіку)
    }

    /**
     * Перевіряє, чи може користувач створювати предмети.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, [Role::TEACHER->value, Role::ADMIN->value]);
    }

    /**
     * Перевіряє, чи може користувач оновлювати предмет.
     */
    public function update(User $user, Subject $subject): bool
    {
        return $user->id === $subject->teacher_id || $user->role === Role::ADMIN->value;
    }

    /**
     * Перевіряє, чи може користувач видаляти предмет.
     */
    public function delete(User $user, Subject $subject): bool
    {
        return $user->id === $subject->teacher_id || $user->role === Role::ADMIN->value;
    }
}
