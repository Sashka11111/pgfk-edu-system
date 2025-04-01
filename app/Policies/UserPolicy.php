<?php
namespace Liamtseva\PGFKEduSystem\Policies;

use Liamtseva\PGFKEduSystem\Enums\Role;
use Liamtseva\PGFKEduSystem\Models\User;

class UserPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->role === Role::ADMIN) {
            return true;
        }

        return null; // Продовжуємо перевірку інших правил
    }
    public function viewAny(User $user): bool
    {
        return $user->role === Role::ADMIN->value;
    }

    public function view(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->role === Role::ADMIN;
    }

    public function create(User $user): bool
    {
        return $user->role === Role::ADMIN;
    }

    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->role === Role::ADMIN;
    }

    public function delete(User $user, User $model): bool
    {
        return $user->role === Role::ADMIN && $user->id !== $model->id;
    }
}
