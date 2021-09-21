<?php

namespace Database\Factories;

use App\Models\Jelovnik;
use Illuminate\Database\Eloquent\Factories\Factory;

class JelovnikFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Jelovnik::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
           'ime' => $this->faker->word(4),
           'opis' => $this->faker->text(),
           'cena' => $this->faker->randomFloat(2,200.00,1000.00),
           'slika' => 'default.png', 
           'created_at' => now(),
        ];
    }
}
