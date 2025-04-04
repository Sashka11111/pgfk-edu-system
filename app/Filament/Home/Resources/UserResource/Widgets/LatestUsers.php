<?php

namespace Liamtseva\PGFKEduSystem\Filament\Home\Resources\UserResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Liamtseva\PGFKEduSystem\Enums\Role;
use Liamtseva\PGFKEduSystem\Models\User;

class LatestUsers extends BaseWidget
{
    protected ?string $heading = 'Останні активні користувачі';

    protected function getStats(): array
    {
        $latestUsers = User::latest()->limit(6)->get();

        $stats = [];

        foreach ($latestUsers as $user) {
            $role = $user->role;
            $stats[] = Stat::make($user->name, '')
                ->description("Зареєстровано: {$user->created_at->format('d.m.Y')}")
                ->color('primary');
        }

        return $stats;
    }
}
