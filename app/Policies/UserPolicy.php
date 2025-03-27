<?php

namespace Liamtseva\PGFKEduSystem\Policies;

use Liamtseva\PGFKEduSystem\Enums\Role;
use Liamtseva\PGFKEduSystem\Models\User;

class UserPolicy
{
    /**
     * Виконується перед усіма іншими методами політики.
     * Адміністратор має доступ до всього.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->role === Role::ADMIN->value) {
            return true;
        }

        return null; // Продовжуємо перевірку інших правил
    }

    /**
     * Перевіряє, чи може користувач переглядати список інших користувачів.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [Role::ADMIN->value]);
    }

    /**
     * Перевіряє, чи може користувач переглядати конкретного користувача.
     */
    public function view(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->role === Role::ADMIN->value;
    }

    /**
     * Перевіряє, чи може користувач створювати нових користувачів.
     */
    public function create(User $user): bool
    {
        return $user->role === Role::ADMIN->value;
    }

    /**
     * Перевіряє, чи може користувач редагувати профіль.
     */
    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->role === Role::ADMIN->value;
    }

    /**
     * Перевіряє, чи може користувач видаляти користувачів.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->role === Role::ADMIN->value && $user->id !== $model->id;
    }
}
