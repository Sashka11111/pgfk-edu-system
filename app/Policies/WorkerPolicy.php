<?php

namespace Liamtseva\PGFKEduSystem\Policies;

use Liamtseva\PGFKEduSystem\Enums\Role;
use Liamtseva\PGFKEduSystem\Models\User;
use Liamtseva\PGFKEduSystem\Models\Worker;

class WorkerPolicy
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
     * Перевіряє, чи може користувач переглядати список працівників.
     */
    public function viewAny(User $user): bool
    {
        // Дозволяємо переглядати список працівників лише адміністраторам
        return $user->role === Role::ADMIN || $user->role === Role::TEACHER;
    }

    /**
     * Перевіряє, чи може користувач переглядати конкретного працівника.
     */
    public function view(User $user, Worker $worker): bool
    {
        return $user->role === Role::ADMIN || $user->role === Role::TEACHER;
    }

    /**
     * Перевіряє, чи може користувач створювати нових працівників.
     */
    public function create(User $user): bool
    {
        // Тільки адміністратори можуть створювати працівників
        return $user->role === Role::ADMIN;
    }

    /**
     * Перевіряє, чи може користувач редагувати працівника.
     */
    public function update(User $user, Worker $worker): bool
    {
        // Дозволяємо редагувати:
        // - Адміністраторам
        // - Самому працівнику (якщо є зв’язок із User)
        return $user->role === Role::ADMIN ||
            ($user->role === Role::TEACHER && $user->id === $worker->user_id);
    }

    /**
     * Перевіряє, чи може користувач видаляти працівника.
     */
    public function delete(User $user, Worker $worker): bool
    {
        // Тільки адміністратори можуть видаляти працівників
        return $user->role === Role::ADMIN;
    }

    /**
     * Перевіряє, чи може користувач відновлювати видаленого працівника.
     */
    public function restore(User $user, Worker $worker): bool
    {
        // Тільки адміністратори можуть відновлювати працівників
        return $user->role === Role::ADMIN;
    }

    /**
     * Перевіряє, чи може користувач остаточно видаляти працівника.
     */
    public function forceDelete(User $user, Worker $worker): bool
    {
        // Тільки адміністратори можуть остаточно видаляти працівників
        return $user->role === Role::ADMIN;
    }
}
