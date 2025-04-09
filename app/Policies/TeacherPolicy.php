<?php

namespace Liamtseva\PGFKEduSystem\Policies;

use Liamtseva\PGFKEduSystem\Enums\Role;
use Liamtseva\PGFKEduSystem\Models\Teacher;
use Liamtseva\PGFKEduSystem\Models\User;

class TeacherPolicy
{
    /**
     * Виконується перед усіма іншими методами політики.
     * Адміністратор має доступ до всього.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->role === Role::ADMIN) {
            return true;
        }

        return null; // Продовжуємо перевірку інших правил
    }

    /**
     * Перевіряє, чи може користувач переглядати список викладачів.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Перевіряє, чи може користувач переглядати конкретного викладача.
     */
    public function view(User $user, Teacher $teacher): bool
    {
        return true;
    }

    /**
     * Перевіряє, чи може користувач створювати нових викладачів.
     */
    public function create(User $user): bool
    {
        // Тільки адміністратори можуть створювати викладачів
        return $user->role === Role::ADMIN;
    }

    /**
     * Перевіряє, чи може користувач редагувати викладача.
     */
    public function update(User $user, Teacher $teacher): bool
    {
        return $user->role === Role::ADMIN ||
            ($user->role === Role::TEACHER && $user->id === $teacher->user_id);
    }

    /**
     * Перевіряє, чи може користувач видаляти викладача.
     */
    public function delete(User $user, Teacher $teacher): bool
    {
        // Тільки адміністратори можуть видаляти викладачів
        return $user->role === Role::ADMIN;
    }

    /**
     * Перевіряє, чи може користувач відновлювати видаленого викладача.
     */
    public function restore(User $user, Teacher $teacher): bool
    {
        // Тільки адміністратори можуть відновлювати викладачів
        return $user->role === Role::ADMIN;
    }

    /**
     * Перевіряє, чи може користувач остаточно видаляти викладача.
     */
    public function forceDelete(User $user, Teacher $teacher): bool
    {
        // Тільки адміністратори можуть остаточно видаляти викладачів
        return $user->role === Role::ADMIN;
    }
}
