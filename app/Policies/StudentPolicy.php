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
        // Забороняємо студентам без запису в таблиці Student
        if ($user->role === Role::STUDENT) {
            $student = Student::where('user_id', $user->id)->first();
            return $student !== null; // Доступ, якщо є запис
        }

        return true; // Інші ролі мають доступ
    }

    /**
     * Перевіряє, чи може користувач переглядати конкретного студента.
     */
    public function view(User $user, Student $student): bool
    {
        // Студент без запису в таблиці Student не має доступу
        if ($user->role === Role::STUDENT) {
            $userStudent = Student::where('user_id', $user->id)->first();
            if ($userStudent === null) {
                return false; // Немає запису — доступ заборонено
            }
            // Дозволяємо студенту бачити лише свій профіль
            return $user->id === $student->user_id;
        }

        return true; // Інші ролі мають доступ
    }

    /**
     * Перевіряє, чи може користувач створювати нових студентів.
     */
    public function create(User $user): bool
    {
        return $user->role === Role::TEACHER || $user->role === Role::ADMIN;
    }

    /**
     * Перевіряє, чи може користувач редагувати студента.
     */
    public function update(User $user, Student $student): bool
    {
        return $user->role === Role::TEACHER || $user->role === Role::ADMIN;
    }

    /**
     * Перевіряє, чи може користувач видаляти студента.
     */
    public function delete(User $user, Student $student): bool
    {
        return $user->role === Role::TEACHER || $user->role === Role::ADMIN;
    }

    /**
     * Перевіряє, чи може користувач відновлювати видаленого студента.
     */
    public function restore(User $user, Student $student): bool
    {
        return $user->role === Role::TEACHER || $user->role === Role::ADMIN;
    }

    /**
     * Перевіряє, чи може користувач остаточно видаляти студента.
     */
    public function forceDelete(User $user, Student $student): bool
    {
        return $user->role === Role::TEACHER || $user->role === Role::ADMIN;
    }
}
