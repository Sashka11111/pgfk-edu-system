<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Liamtseva\PGFKEduSystem\Enums\Department;
use Liamtseva\PGFKEduSystem\Enums\StudyForm;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->ulid('id')->primary(); // Унікальний ідентифікатор ULID
            $table->string('name')->unique(); // Назва групи
            $table->integer('year_of_study'); // Рік навчання
            $table->enumAlterColumn('study_form', 'study_form', StudyForm::class,default: StudyForm::FULL_TIME->value);
            $table->foreignUlid('specialty_id')->nullable()->constrained('specialties')->cascadeOnDelete(); // Спеціальність
            $table->foreignUlid('teacher_id')->nullable()->constrained('teachers')->cascadeOnDelete(); // Куратор (викладач)
            $table->timestamps(); // Дата створення та оновлення запису
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
        Schema::dropIfExists('groups');
    }
};
