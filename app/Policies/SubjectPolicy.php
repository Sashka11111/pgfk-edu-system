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
     * Дозволяє перегляд списку предметів всім.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Дозволяє перегляд конкретного предмета всім.
     */
    public function view(User $user, Subject $subject): bool
    {
        return true;
    }

    /**
     * Дозволяє створення предмета тільки вчителям та адміністраторам.
     */
    public function create(User $user): bool
    {
        return $user->role === Role::TEACHER || $user->role === Role::ADMIN;
    }

    /**
     * Дозволяє оновлення предмета тільки адміністратору.
     */
    public function update(User $user, Subject $subject): bool
    {
        return $user->role === Role::TEACHER || $user->role === Role::ADMIN;
    }

    /**
     * Дозволяє видалення предмета тільки адміністратору.
     */
    public function delete(User $user, Subject $subject): bool
    {
        return $user->role === Role::TEACHER || $user->role === Role::ADMIN;
    }

}
