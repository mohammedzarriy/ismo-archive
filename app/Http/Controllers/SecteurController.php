<?php

namespace App\Http\Controllers;

use App\Models\Secteur;
use Illuminate\Http\Request;

class SecteurController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage-users');
    }

    public function index()
    {
        $secteurs = Secteur::withCount('filieres')->latest()->get();
        return view('secteurs.index', compact('secteurs'));
    }

    public function create()
    {
        return view('secteurs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_secteur' => 'required|string|max:100|unique:secteurs',
        ]);

        Secteur::create($request->all());

        return redirect()->route('secteurs.index')
            ->with('success', 'Secteur ajouté avec succès!');
    }

    public function edit(Secteur $secteur)
    {
        return view('secteurs.edit', compact('secteur'));
    }

    public function update(Request $request, Secteur $secteur)
    {
        $request->validate([
            'nom_secteur' => 'required|string|max:100|unique:secteurs,nom_secteur,' . $secteur->id,
        ]);

        $secteur->update($request->all());

        return redirect()->route('secteurs.index')
            ->with('success', 'Secteur modifié avec succès!');
    }

    public function destroy(Secteur $secteur)
    {
        if ($secteur->filieres()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer — des filières sont associées!');
        }

        $secteur->delete();
        return redirect()->route('secteurs.index')
            ->with('success', 'Secteur supprimé!');
    }
}