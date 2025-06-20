<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NutritionLibrary extends Model
{
    protected $fillbale = [
        'name', 'calories', 'fat', 'protein', 'carbs', 'image', 
        'calories_per_100g', 'carbs_per_100g', 'protein_per_100g', 'fat_per_100g',
        'fiber_per_100g', 'sugar_per_100g', 'sodium_per_100g'
    ];

    public function foods() { return $this->hasMany(Food::class); }
    
    // Calculate nutrients based on portion
    public function calculateNutrients($portion_grams) {
        $multiplier = $portion_grams / 100;
        return [
            'calories' => $this->calories_per_100g * $multiplier,
            'fat' => $this->fat_per_100g * $multiplier,
            'protein' => $this->protein_per_100g * $multiplier,
            'carbs' => $this->carbs_per_100g * $multiplier,
        ];
    }
}
