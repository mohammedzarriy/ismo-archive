<?php

namespace Database\Seeders;

use App\Models\Trainee;
use App\Models\Document;
use App\Models\Movement;
use Illuminate\Database\Seeder;

class TraineesTestSeeder extends Seeder
{
    public function run(): void
    {
        // زيد 600 متدرب
        Trainee::factory(600)->create()->each(function ($trainee) {

            // كل متدرب عنده Bac
            $bac = Document::create([
                'trainee_id'       => $trainee->id,
                'type'             => 'Bac',
                'status'           => fake()->randomElement(['Stock','Temp_Out','Final_Out']),
                'reference_number' => strtoupper(fake()->bothify('BAC-####')),
                'level_year'       => null,
            ]);

            Movement::create([
                'document_id'  => $bac->id,
                'user_id'      => 1,
                'action_type'  => 'Saisie',
                'date_action'  => now(),
                'observations' => 'Import test',
            ]);

            // بعض المتدربين عندهم Diplome
            if (fake()->boolean(60)) {
                $diplome = Document::create([
                    'trainee_id'       => $trainee->id,
                    'type'             => 'Diplome',
                    'status'           => fake()->randomElement(['Stock','Final_Out']),
                    'reference_number' => strtoupper(fake()->bothify('DIP-####')),
                    'level_year'       => null,
                ]);

                Movement::create([
                    'document_id'  => $diplome->id,
                    'user_id'      => 1,
                    'action_type'  => 'Saisie',
                    'date_action'  => now(),
                    'observations' => 'Import test',
                ]);
            }
        });
    }
}