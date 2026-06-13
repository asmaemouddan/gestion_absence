<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Module;
use App\Models\Professeur;
use App\Models\Seance;
use Illuminate\Http\Request;

class SeanceController extends Controller
{
    public function index()
    {
        $seances = Seance::with('classe', 'professeur.user', 'module')
            ->latest()
            ->paginate(10);

        return view('seances.index', compact('seances'));
    }

    public function create()
    {
        $classes = Classe::all();
        $professeurs = Professeur::with('user')->get();
        $modules = Module::all();

        return view('seances.create', compact('classes', 'professeurs', 'modules'));
    }

   public function store(Request $request)
{
    $request->validate([
        'classe_id' => 'required|exists:classes,id',
        'professeur_id' => 'required|exists:professeurs,id',
        'module_id' => 'required|exists:modules,id',
        'date' => 'required|date',
        'heure_debut' => 'required',
        'heure_fin' => 'required|after:heure_debut',
        'photo' => 'nullable|image|mimes:jpg,png,jpeg',
    ]);

    $photoPath = null;

    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('seances', 'public');
    }

    Seance::create([
        'classe_id' => $request->classe_id,
        'professeur_id' => $request->professeur_id,
        'module_id' => $request->module_id,
        'date' => $request->date,
        'heure_debut' => $request->heure_debut,
        'heure_fin' => $request->heure_fin,
        'photo' => $photoPath,
    ]);

    return redirect()->route('seances.index')
        ->with('success', 'Séance ajoutée avec succès.');
}
    public function show(Seance $seance)
    {
        $seance->load(
            'classe',
            'professeur.user',
            'module',
            'presences.etudiant.user'
        );

        return view('seances.show', compact('seance'));
    }

    public function edit(Seance $seance)
    {
        $classes = Classe::all();
        $professeurs = Professeur::with('user')->get();
        $modules = Module::all();

        return view('seances.edit', compact('seance', 'classes', 'professeurs', 'modules'));
    }

    public function update(Request $request, Seance $seance)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'professeur_id' => 'required|exists:professeurs,id',
            'module_id' => 'required|exists:modules,id',
            'date' => 'required|date',
            'heure_debut' => 'required',
            'heure_fin' => 'required|after:heure_debut',
        ]);

        $seance->update([
            'classe_id' => $request->classe_id,
            'professeur_id' => $request->professeur_id,
            'module_id' => $request->module_id,
            'date' => $request->date,
            'heure_debut' => $request->heure_debut,
            'heure_fin' => $request->heure_fin,
        ]);

        return redirect()
            ->route('seances.index')
            ->with('success', 'Séance modifiée avec succès.');
    }

    public function destroy(Seance $seance)
    {
        $seance->delete();

        return redirect()
            ->route('seances.index')
            ->with('success', 'Séance supprimée avec succès.');
    }
}
