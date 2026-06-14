<?php

namespace App\Http\Controllers;

use App\Models\Justification;
use App\Models\Presence;
use Illuminate\Http\Request;

class JustificationController extends Controller
{
    public function index()
    {
        $justifications = Justification::with(
            'presence.etudiant.user',
            'presence.seance.module',
            'presence.seance.classe'
        )->latest()->get();

        return view('justifications.index', compact('justifications'));
    }

   public function create()
{
    $presences = Presence::with(
        'etudiant.user',
        'seance.module',
        'seance.classe'
    )
    ->where('status', 'absent')
    ->get();

    if(auth()->user()->role === 'etudiant') {
        return view('etudiants.justifications.create', compact('presences'));
    }

    return view('justifications.create', compact('presences'));
}

    public function store(Request $request)
    {
        $request->validate([
            'presence_id' => 'required|exists:presences,id|unique:justifications,presence_id',
            'motif' => 'required|string',
            'fichier' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $fichierPath = null;

        if ($request->hasFile('fichier')) {
            $fichierPath = $request->file('fichier')->store('justifications', 'public');
        }

        Justification::create([
            'presence_id' => $request->presence_id,
            'motif' => $request->motif,
            'fichier' => $fichierPath,
            'status' => 'en_attente',
        ]);

       if(auth()->user()->role === 'etudiant'){
    return redirect()->route('etudiant.justifications')
        ->with('success', 'Justification ajoutée avec succès.');
}

return redirect()->route('justifications.index')
    ->with('success', 'Justification ajoutée avec succès.');
    }

    public function show(Justification $justification)
    {
        $justification->load(
            'presence.etudiant.user',
            'presence.seance.module',
            'presence.seance.classe'
        );

        return view('justifications.show', compact('justification'));
    }

    public function edit(Justification $justification)
    {
        $presences = Presence::with('etudiant.user', 'seance.module', 'seance.classe')
            ->where('status', 'absent')
            ->get();

        return view('justifications.edit', compact('justification', 'presences'));
    }

   public function update(Request $request, Justification $justification)
{
    $request->validate([
        'motif' => 'required|string',
        'status' => 'required|in:en_attente,acceptee,refusee',
    ]);

    $justification->update([
        'motif' => $request->motif,
        'status' => $request->status,
    ]);

    if ($request->status === 'acceptee') {
        $justification->presence->update([
            'status' => 'justifie',
        ]);
    }

    if ($request->status === 'refusee') {
        $justification->presence->update([
            'status' => 'absent',
        ]);
    }

    if ($request->status === 'en_attente') {
        $justification->presence->update([
            'status' => 'absent',
        ]);
    }

    return redirect()
        ->route('justifications.index')
        ->with('success', 'Justification modifiée avec succès.');
}
    public function destroy(Justification $justification)
    {
        $justification->delete();

        return redirect()
            ->route('justifications.index')
            ->with('success', 'Justification supprimée avec succès.');
    }
}
