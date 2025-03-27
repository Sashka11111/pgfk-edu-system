<?php

namespace Liamtseva\PGFKEduSystem\Policies;

use Liamtseva\PGFKEduSystem\Enums\Role;
use Liamtseva\PGFKEduSystem\Models\User;
use Liamtseva\PGFKEduSystem\Models\Course;

class CoursePolicy
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
     * Перевіряє, чи може користувач переглядати список курсів.
     */
    public function viewAny(User $user): bool
    {
        return true; // Доступно всім авторизованим користувачам
    }

    /**
     * Перевіряє, чи може користувач переглядати конкретний курс.
     */
    public function view(User $user, Course $course): bool
    {
        return true; // Доступно всім (можна змінити логіку)
    }

    /**
     * Перевіряє, чи може користувач створювати курси.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, [Role::TEACHER->value, Role::ADMIN->value]);
    }

    /**
     * Перевіряє, чи може користувач оновлювати курс.
     */
    public function update(User $user, Course $course): bool
    {
        return $user->id === $course->teacher_id || $user->role === Role::ADMIN->value;
    }

    /**
     * Перевіряє, чи може користувач видаляти курс.
     */
    public function delete(User $user, Course $course): bool
    {
        return $user->id === $course->teacher_id || $user->role === Role::ADMIN->value;
    }
}
