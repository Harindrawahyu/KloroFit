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
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('nutrition_libraries_id')->constrained('nutrition_libraries')->onDelete('cascade');
            $table->decimal('portion_grams', 8, 2);    
            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner', 'snack']);
            $table->date('date');
            $table->timestamps();

            $table->index(['user_id', 'date']);
            $table->index('meal_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};
