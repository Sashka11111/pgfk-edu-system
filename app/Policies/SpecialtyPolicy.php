<?php

namespace Liamtseva\PGFKEduSystem\Policies;

use Liamtseva\PGFKEduSystem\Enums\Role;
use Liamtseva\PGFKEduSystem\Models\Specialty;
use Liamtseva\PGFKEduSystem\Models\User;

class SpecialtyPolicy
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
     * Перевіряє, чи може користувач переглядати список спеціальностей.
     */
    public function viewAny(User $user): bool
    {
        // Дозволяємо переглядати список спеціальностей адміністраторам і викладачам
        return in_array($user->role, [Role::ADMIN, Role::TEACHER]);
    }

    /**
     * Перевіряє, чи може користувач переглядати конкретну спеціальність.
     */
    public function view(User $user, Specialty $specialty): bool
    {
        // Дозволяємо переглядати спеціальність адміністраторам і викладачам
        return in_array($user->role, [Role::ADMIN, Role::TEACHER]);
    }

    /**
     * Перевіряє, чи може користувач створювати нові спеціальності.
     */
    public function create(User $user): bool
    {
        // Тільки адміністратори можуть створювати спеціальності
        return $user->role === Role::ADMIN;
    }

    /**
     * Перевіряє, чи може користувач редагувати спеціальність.
     */
    public function update(User $user, Specialty $specialty): bool
    {
        // Тільки адміністратори можуть редагувати спеціальності
        return $user->role === Role::ADMIN;
    }

    /**
     * Перевіряє, чи може користувач видаляти спеціальність.
     */
    public function delete(User $user, Specialty $specialty): bool
    {
        // Тільки адміністратори можуть видаляти спеціальності
        return $user->role === Role::ADMIN;
    }

    /**
     * Перевіряє, чи може користувач відновлювати видалену спеціальність.
     */
    public function restore(User $user, Specialty $specialty): bool
    {
        // Тільки адміністратори можуть відновлювати спеціальності
        return $user->role === Role::ADMIN;
    }

    /**
     * Перевіряє, чи може користувач остаточно видаляти спеціальність.
     */
    public function forceDelete(User $user, Specialty $specialty): bool
    {
        // Тільки адміністратори можуть остаточно видаляти спеціальності
        return $user->role === Role::ADMIN;
    }
}
