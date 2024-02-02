<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserDomicilioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'domicilio' => ('Domicilio ' . $this->faker->text(10)),
            'numero_exterior' => ('No. ' . $this->faker->text(5)),
            'colonia' => ('Colonia ' . $this->faker->text(10)),
            'cp' => $this->faker->randomNumber(5, true),
            'ciudad' => ('Ciudad ' . $this->faker->text(10)),
        ];
    }
}
