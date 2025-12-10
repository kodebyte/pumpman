<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true); // Contoh: "Audio Systems"
        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'image' => null,
        ];
    }
}