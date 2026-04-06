<?php

namespace App\Http\Controllers;

use App\Models\Trainee;
use App\Models\Filiere;
use Illuminate\Http\Request;
use App\Imports\TraineesImport;
use Maatwebsite\Excel\Facades\Excel;

class TraineeController extends Controller
{
    public function index(Request $request)
    {
        $query = Trainee::query()->with('filiere');

        if ($request->filiere_id) $query->where('filiere_id', $request->filiere_id);
        if ($request->group) $query->where('group', $request->group);
        if ($request->graduation_year) $query->where('graduation_year', $request->graduation_year);

        $trainees = $query->orderBy('last_name')->paginate(15);

        $filieres = Filiere::all();
        $groups = Trainee::distinct()->pluck('group');
        $years = Trainee::distinct()->pluck('graduation_year');

        return view('trainees.index', compact('trainees','filieres','groups','years'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new TraineesImport, $request->file('file'));

        return back()->with('success', 'Import réussi ✅');
    }
}