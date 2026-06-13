<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Etudiant;
use App\Models\Justification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EtudiantController extends Controller
{
    public function index()
    {
        $etudiants = Etudiant::with('user', 'classe')->latest()->get();
        return view('etudiants.index', compact('etudiants'));
    }

    public function create()
    {
        $classes = Classe::all();

        return view('etudiants.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telephone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
            'classe_id' => 'nullable|exists:classes,id',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = $request->file('image')->store('etudiants', 'public');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => Hash::make($request->password),
            'role' => 'etudiant',
        ]);

        Etudiant::create([
            'user_id' => $user->id,
            'classe_id' => $request->classe_id,
            'image' => $imagePath,
        ]);

        return redirect()->route('etudiants.index') ->with('success', 'Étudiant ajouté avec succès.');
    }

    public function show(Etudiant $etudiant)
    {
        $etudiant->load('user', 'classe', 'presences.seance.module');
        return view('etudiants.show', compact('etudiant'));
    }

    public function edit(Etudiant $etudiant)
    {
        $etudiant->load('user', 'classe');
        $classes = Classe::all();

        return view('etudiants.edit', compact('etudiant', 'classes'));
    }

    public function update(Request $request, Etudiant $etudiant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $etudiant->user_id,
            'telephone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8',
            'classe_id' => 'nullable|exists:classes,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $etudiant->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $request->telephone,
        ]);

        if ($request->filled('password')) {
            $etudiant->user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        $data = [
            'classe_id' => $request->classe_id,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('etudiants', 'public');
        }
        $etudiant->update($data);

        return redirect()->route('etudiants.index')->with('success', 'Étudiant modifié avec succès.');
    }

    public function destroy(Etudiant $etudiant)
    {
        $etudiant->delete();
        $etudiant->user?->delete();

        return redirect()->route('etudiants.index')->with('success', 'Étudiant supprimé avec succès.');
    }

public function justifications()
{
    $etudiant = auth()->user()->etudiant;

    $justifications = Justification::with(
        'presence.seance.module'
    )
    ->whereHas('presence', function ($query) use ($etudiant) {
        $query->where('etudiant_id', $etudiant->id);
    })
    ->get();

    return view('etudiants.justifications', compact('justifications'));
}
}
