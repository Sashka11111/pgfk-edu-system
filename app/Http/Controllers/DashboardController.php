<?php

namespace Liamtseva\PGFKEduSystem\Http\Controllers;

use Liamtseva\PGFKEduSystem\Enums\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Liamtseva\PGFKEduSystem\Filament\Home\Pages\Dashboard;

class DashboardController extends Controller
{
    public function index()
    {
        // Перевіряємо, чи користувач аутентифікований
        if (!Auth::check()) {
            return redirect()->route('login');
        }else{
            return redirect(Dashboard::getUrl());
        }
    }
}
