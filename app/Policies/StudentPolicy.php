<?php

namespace Liamtseva\PGFKEduSystem\Policies;

use Liamtseva\PGFKEduSystem\Enums\Role;
use Liamtseva\PGFKEduSystem\Models\Student;
use Liamtseva\PGFKEduSystem\Models\User;

class StudentPolicy
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
     * Перевіряє, чи може користувач переглядати список студентів.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Перевіряє, чи може користувач переглядати конкретного студента.
     */
    public function view(User $user, Student $student): bool
    {
        return true;
    }

    /**
     * Перевіряє, чи може користувач створювати нових студентів.
     */
    public function create(User $user): bool
    {
        // Тільки адміністратори можуть створювати студентів
        return $user->role === Role::ADMIN;
    }

    /**
     * Перевіряє, чи може користувач редагувати студента.
     */
    public function update(User $user, Student $student): bool
    {
        return $user->role === Role::ADMIN;
    }

    /**
     * Перевіряє, чи може користувач видаляти студента.
     */
    public function delete(User $user, Student $student): bool
    {
        // Тільки адміністратори можуть видаляти студентів
        return $user->role === Role::ADMIN;
    }

    /**
     * Перевіряє, чи може користувач відновлювати видаленого студента.
     */
    public function restore(User $user, Student $student): bool
    {
        // Тільки адміністратори можуть відновлювати студентів
        return $user->role === Role::ADMIN;
    }

    /**
     * Перевіряє, чи може користувач остаточно видаляти студента.
     */
    public function forceDelete(User $user, Student $student): bool
    {
        // Тільки адміністратори можуть остаточно видаляти студентів
        return $user->role === Role::ADMIN;
    }
}
