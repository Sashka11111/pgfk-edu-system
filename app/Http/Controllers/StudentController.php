<?php

namespace Liamtseva\PGFKEduSystem\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Liamtseva\PGFKEduSystem\Models\Student;

class StudentController extends Controller
{
    public function show($id)
    {
        // Знаходимо студента за ID з пов'язаними даними
        $student = Student::with(['user', 'group.specialty'])->findOrFail($id);

        // Перевіряємо, чи авторизований користувач має доступ до цього студента
        if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isTeacher() || Auth::user()->id === $student->user_id)) {
            return view('student.show', compact('student'));
        }

        // Якщо користувач не має доступу, повертаємо помилку 403
        abort(403, 'Unauthorized access.');
    }
}
