<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Secteur;
use Illuminate\Http\Request;

class FiliereController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage-users');
    }

    public function index()
    {
        $filieres = Filiere::with('secteur')->withCount('trainees')->latest()->get();
        return view('filieres.index', compact('filieres'));
    }

    public function create()
    {
        $secteurs = Secteur::all();
        return view('filieres.create', compact('secteurs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'secteur_id'   => 'required|exists:secteurs,id',
            'code_filiere' => 'required|string|max:20|unique:filieres',
            'nom_filiere'  => 'required|string|max:100',
            'niveau'       => 'required|in:TS,T,Q,S,BP',
        ]);

        Filiere::create($request->all());

        return redirect()->route('filieres.index')
            ->with('success', 'Filière ajoutée avec succès!');
    }

    public function edit(Filiere $filiere)
    {
        $secteurs = Secteur::all();
        return view('filieres.edit', compact('filiere', 'secteurs'));
    }

    public function update(Request $request, Filiere $filiere)
    {
        $request->validate([
            'secteur_id'   => 'required|exists:secteurs,id',
            'code_filiere' => 'required|string|max:20|unique:filieres,code_filiere,' . $filiere->id,
            'nom_filiere'  => 'required|string|max:100',
            'niveau'       => 'required|in:TS,T,Q,S,BP',
        ]);

        $filiere->update($request->all());

        return redirect()->route('filieres.index')
            ->with('success', 'Filière modifiée avec succès!');
    }

    public function destroy(Filiere $filiere)
    {
        if ($filiere->trainees()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer — des stagiaires sont associés!');
        }

        $filiere->delete();
        return redirect()->route('filieres.index')
            ->with('success', 'Filière supprimée!');
    }
}