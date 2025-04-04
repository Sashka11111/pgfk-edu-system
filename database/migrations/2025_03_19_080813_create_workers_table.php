<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Liamtseva\PGFKEduSystem\Enums\Position;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('workers', function (Blueprint $table) {
            $table->ulid('id')->primary(); // Унікальний ідентифікатор ULID
            $table->string('last_name'); // Прізвище
            $table->string('first_name'); // Ім’я
            $table->string('middle_name')->nullable(); // По батькові
            $table->foreignUlid('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enumAlterColumn('position', 'position', Position::class);
            $table->string('phone_number')->nullable(); // Номер телефону
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workers');
    }
};
