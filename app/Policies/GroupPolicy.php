<?php

namespace Liamtseva\PGFKEduSystem\Policies;

use Liamtseva\PGFKEduSystem\Enums\Role;
use Liamtseva\PGFKEduSystem\Models\Group;
use Liamtseva\PGFKEduSystem\Models\User;

class GroupPolicy
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
     * Перевіряє, чи може користувач переглядати список груп.
     */
    public function viewAny(User $user): bool
    {
        // Дозволяємо переглядати список груп адміністраторам і викладачам
        return in_array($user->role, [Role::ADMIN, Role::TEACHER]);
    }

    /**
     * Перевіряє, чи може користувач переглядати конкретну групу.
     */
    public function view(User $user, Group $group): bool
    {
        // Дозволяємо переглядати групу адміністраторам і викладачам
        return in_array($user->role, [Role::ADMIN, Role::TEACHER]);
    }

    /**
     * Перевіряє, чи може користувач створювати нові групи.
     */
    public function create(User $user): bool
    {
        // Тільки адміністратори можуть створювати групи
        return $user->role === Role::ADMIN;
    }

    /**
     * Перевіряє, чи може користувач редагувати групу.
     */
    public function update(User $user, Group $group): bool
    {
        // Тільки адміністратори можуть редагувати групи
        return $user->role === Role::ADMIN;
    }

    /**
     * Перевіряє, чи може користувач видаляти групу.
     */
    public function delete(User $user, Group $group): bool
    {
        // Тільки адміністратори можуть видаляти групи
        return $user->role === Role::ADMIN;
    }

    /**
     * Перевіряє, чи може користувач відновлювати видалену групу.
     */
    public function restore(User $user, Group $group): bool
    {
        // Тільки адміністратори можуть відновлювати групи
        return $user->role === Role::ADMIN;
    }

    /**
     * Перевіряє, чи може користувач остаточно видаляти групу.
     */
    public function forceDelete(User $user, Group $group): bool
    {
        // Тільки адміністратори можуть остаточно видаляти групи
        return $user->role === Role::ADMIN;
    }
}
