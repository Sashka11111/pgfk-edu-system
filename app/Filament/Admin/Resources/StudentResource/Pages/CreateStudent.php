<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources\StudentResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\StudentResource;
use Liamtseva\PGFKEduSystem\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected function beforeSave(): void
    {
        if (!$this->data['user_id']) {
            $user = User::create([
                'name' => $this->data['user_name'], // Додаємо поле в форму
                'email' => $this->data['user_email'],
                'password' => Hash::make(Str::random(12)), // Генеруємо пароль
            ]);

            $this->data['user_id'] = $user->id;
        }
    }
}
