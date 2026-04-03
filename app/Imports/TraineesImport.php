<?php

namespace App\Imports;

use App\Models\Trainee;
use App\Models\Filiere;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TraineesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $filiere = Filiere::where('code_filiere', $row['filiere'] ?? null)->first();

        return new Trainee([
            'filiere_id'      => $filiere?->id ?? 1,
            'cin'             => $row['cin'] ?? null,
            'cef'             => $row['cef'] ?? null,                       // جديد
            'first_name'      => $row['prenom'] ?? null,
            'last_name'       => $row['nom'] ?? null,
            'group'           => $row['groupe'] ?? null,
            'graduation_year' => $row['annee'] ?? date('Y'),
            'date_of_birth'   => isset($row['date_de_naissance']) ? date('Y-m-d', strtotime($row['date_de_naissance'])) : null, // جديد
        ]);
    }
}