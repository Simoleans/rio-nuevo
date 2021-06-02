<?php

namespace Database\Factories;

use App\Models\Variedad;
use Illuminate\Database\Eloquent\Factories\Factory;

class VariedadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Variedad::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tipo_cultivo' => $this->faker->city,
            'nombre' => $this->faker->name
        ];
    }
}
