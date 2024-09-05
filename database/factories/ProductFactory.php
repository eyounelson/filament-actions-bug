<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $name = $this->faker->catchPhrase,
            'sku' => Str::limit($name, 2, '').'_'.$this->faker->randomNumber(6, true),
            'price' => $this->faker->numberBetween(5, 15),
        ];
    }
}
