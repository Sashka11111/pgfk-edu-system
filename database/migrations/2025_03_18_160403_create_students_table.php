<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->ulid('id')->primary(); // Унікальний ідентифікатор ULID
            $table->foreignUlid('user_id')->constrained('users')->cascadeOnDelete(); // Посилання на користувача
            $table->string('record_book_number')->unique(); // Номер залікової книжки
            $table->foreignUlid('group_id')->nullable()->constrained('groups')->cascadeOnDelete(); // Посилання на групу
            $table->date('enrollment_date')->nullable(); // Дата вступу
            $table->boolean('is_scholarship_holder')->default(false); // Чи отримує стипендію
            $table->string('birthplace')->nullable(); // Місце народження
            $table->date('birthdate')->nullable(); // Дата народження
            $table->string('phone_number')->nullable(); // Номер телефону
            $table->string('address')->nullable(); // Домашня адреса
            $table->string('guardian_name')->nullable(); // Ім'я опікуна
            $table->string('guardian_phone')->nullable(); // Телефон опікуна
            $table->timestamps(); // Дата створення та оновлення запису
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
