<?php

namespace Liamtseva\PGFKEduSystem\Http\Controllers;

use Liamtseva\PGFKEduSystem\Enums\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Liamtseva\PGFKEduSystem\Filament\Admin\Pages\Dashboard;

class DashboardController extends Controller
{
    public function index()
    {
        // Перевіряємо, чи користувач аутентифікований
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role->value;
        // Перевіряємо роль студента
        if ($userRole === Role::STUDENT->value) {
            return redirect()->route('profile');
        }else{
            return redirect(Dashboard::getUrl());
        }
    }
}
