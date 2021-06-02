<?php

namespace Database\Factories;

use App\Models\Machine;
use Illuminate\Database\Eloquent\Factories\Factory;

class MachineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Machine::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $typeArray = array('normal','arriendo');
        $type = array_rand($typeArray);
        $status = array(0,1);

        return [
            'nombre' => $this->faker->name,
            'marca' => $this->faker->state,
            'modelo' => $this->faker->city,
            'tipo' => $typeArray[$type],
            'year' => 2021,
            'serie' => $this->faker->cityPrefix,
            'status' => array_rand($status),
        ];
    }
}
