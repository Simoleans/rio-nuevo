<?php

namespace Database\Factories;

use App\Models\TipoCultivo;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipoCultivoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TipoCultivo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->name
        ];
    }
}
