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
        Schema::create('student_subject', function (Blueprint $table) {
            $table->foreignUlid('student_id')->constrained('students')->cascadeOnDelete(); // Посилання на студента
            $table->foreignUlid('subject_id')->constrained('subjects')->cascadeOnDelete(); // Посилання на предмет
            $table->primary(['student_id', 'subject_id']);
            $table->timestamps(); // Дата створення та оновлення запису
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_subject');
    }
};
