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
        Schema::create('nutrition_libraries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->float('calories')->nullable();
            $table->float('fat')->nullable();
            $table->float('protein')->nullable();
            $table->float('carbs')->nullable();
            $table->text('image')->nullable();

            $table->decimal('calories_per_100g', 8, 2);
            $table->decimal('fat_per_100g', 8, 2);
            $table->decimal('protein_per_100g', 8, 2);
            $table->decimal('carbs_per_100g', 8, 2);
    
            $table->boolean('is_verified')->default(false); // Admin verified
            $table->timestamps();
    
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutrition_libraries');
    }
};
