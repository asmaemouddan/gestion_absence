<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Presence;
use App\Models\Seance;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PresenceController extends Controller
{
    public function index()
    {
        $presences = Presence::with('etudiant.user', 'seance.module', 'seance.classe')
            ->latest()
            ->paginate(10);

        return view('presences.index', compact('presences'));
    }

    public function create()
    {
        $etudiants = Etudiant::with('user')->get();
        $seances = Seance::with('classe', 'module')->get();

        return view('presences.create', compact('etudiants', 'seances'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'etudiant_id' => [
                'required',
                'exists:etudiants,id',
                Rule::unique('presences')->where(function ($query) use ($request) {
                    return $query->where('seance_id', $request->seance_id);
                }),
            ],
            'seance_id' => 'required|exists:seances,id',
            'status' => 'required|in:present,absent,retard,justifie',
            'heure_scan' => 'nullable',
        ]);

        Presence::create([
            'etudiant_id' => $request->etudiant_id,
            'seance_id' => $request->seance_id,
            'status' => $request->status,
            'heure_scan' => $request->heure_scan,
        ]);

        return redirect()
            ->route('presences.index')
            ->with('success', 'Présence ajoutée avec succès.');
    }

    public function show(Presence $presence)
    {
        $presence->load(
            'etudiant.user',
            'seance.module',
            'seance.classe',
            'justification'
        );

        return view('presences.show', compact('presence'));
    }

    public function edit(Presence $presence)
    {
        $etudiants = Etudiant::with('user')->get();
        $seances = Seance::with('classe', 'module')->get();

        return view('presences.edit', compact('presence', 'etudiants', 'seances'));
    }

    public function update(Request $request, Presence $presence)
    {
        $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'seance_id' => 'required|exists:seances,id',
            'status' => 'required|in:present,absent,retard,justifie',
            'heure_scan' => 'nullable',
        ]);

        $presence->update([
            'etudiant_id' => $request->etudiant_id,
            'seance_id' => $request->seance_id,
            'status' => $request->status,
            'heure_scan' => $request->heure_scan,
        ]);

        return redirect()
            ->route('presences.index')
            ->with('success', 'Présence modifiée avec succès.');
    }

    public function destroy(Presence $presence)
    {
        $presence->delete();

        return redirect()
            ->route('presences.index')
            ->with('success', 'Présence supprimée avec succès.');
    }
}
