<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Liamtseva\PGFKEduSystem\Enums\Department;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('specialties', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');           // Назва спеціальності (наприклад, "Інформаційні технології")
            $table->string('code')->unique(); // Код спеціальності (наприклад, "121" для "Інженерія ПЗ")
            $table->enumAlterColumn('department', 'department', Department::class); // Відділення
            $table->text('description')->nullable(); // Опис спеціальності (опціонально)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
        Schema::dropIfExists('specialties');
    }
};
