<?php

namespace Database\Factories;

use App\Models\Filiere;
use Illuminate\Database\Eloquent\Factories\Factory;

class TraineeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'filiere_id'      => Filiere::inRandomOrder()->first()->id,
            'cin'             => strtoupper($this->faker->unique()->bothify('??######')),
            'cef'             => strtoupper($this->faker->unique()->bothify('??#########')),
            'first_name'      => $this->faker->firstName(),
            'last_name'       => $this->faker->lastName(),
            'date_naissance'  => $this->faker->dateTimeBetween('-30 years', '-18 years'),
            'phone'           => '06' . $this->faker->numerify('########'),
            'group'           => $this->faker->randomElement(['G1','G2','G3','G4']),
            'graduation_year' => $this->faker->randomElement([2022, 2023, 2024, 2025]),
        ];
    }
}