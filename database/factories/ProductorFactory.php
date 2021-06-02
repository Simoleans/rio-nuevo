<?php

namespace Database\Factories;

use App\Models\Productor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Productor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $status = array(0,1);

        return [
                'rut' => $this->faker->ean8,
                'razon_social' => $this->faker->name,
                'localidad' => $this->faker->state,
                'region' => $this->faker->citySuffix,
                'comuna' => $this->faker->cityPrefix,
                'direccion' => $this->faker->address,
                'nombre_responsable' => $this->faker->name,
                'email' => $this->faker->email,
                'telefono' => $this->faker->phoneNumber,
                'status' => array_rand($status)
        ];
    }
}
