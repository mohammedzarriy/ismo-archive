<?php

namespace App\Http\Controllers;

use App\Models\Validation;
use App\Models\Trainee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidationController extends Controller
{
    public function index()
    {
        $validations = Validation::with('trainee.filiere', 'user')
            ->latest('date_validation')
            ->paginate(15);
        return view('validations.index', compact('validations'));
    }

    public function create(Trainee $trainee)
    {
        // تحقق واش جميع الوثائق مسلمة
        $docs = $trainee->documents;
        $types = ['Bac', 'Diplome', 'Attestation', 'Bulletin'];
        $missing = [];

        foreach ($types as $type) {
            $doc = $docs->where('type', $type)->first();
            if (!$doc || !in_array($doc->status, ['Final_Out', 'Remis'])) {
                $missing[] = $type;
            }
        }

        return view('validations.create', compact('trainee', 'missing'));
    }

    public function store(Request $request, Trainee $trainee)
    {
        $request->validate([
            'date_validation' => 'required|date',
            'signature_scan'  => 'required|image|max:5120',
            'observations'    => 'nullable|string',
        ]);

        // حفظ الصورة
        $path = $request->file('signature_scan')
            ->store('signatures', 'public');

        Validation::create([
            'trainee_id'      => $trainee->id,
            'user_id'         => Auth::id(),
            'date_validation' => $request->date_validation,
            'signature_scan'  => $path,
            'observations'    => $request->observations,
        ]);

        return redirect()->route('trainees.show', $trainee)
            ->with('success', 'Validation enregistrée avec succès!');
    }

    public function show(Trainee $trainee)
    {
        $validation = $trainee->validation;
        if (!$validation) {
            return redirect()->route('trainees.show', $trainee)
                ->with('error', 'Aucune validation trouvée!');
        }
        return view('validations.show', compact('trainee', 'validation'));
    }

    public function destroy(Validation $validation)
    {
        $trainee = $validation->trainee;
        $validation->delete();
        return redirect()->route('trainees.show', $trainee)
            ->with('success', 'Validation supprimée!');
    }
}