<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Liamtseva\PGFKEduSystem\Enums\Department;
use Liamtseva\PGFKEduSystem\Enums\Qualification;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->ulid('id')->primary(); // Унікальний ідентифікатор ULID
            $table->foreignUlid('user_id')->constrained('users')->cascadeOnDelete(); // Посилання на users
            $table->enumAlterColumn('qualification', 'qualification', Qualification::class);
            $table->string('phone_number')->nullable(); // Номер телефону
            $table->integer('experience_years')->default(0); // Досвід роботи (у роках)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
