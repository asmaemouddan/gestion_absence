<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Professeur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfesseurController extends Controller
{
    public function index()
    {
        $professeurs = Professeur::with('user', 'modules')->latest()->paginate(10);
        return view('professeurs.index', compact('professeurs'));
    }

    public function create()
    {
        $modules = Module::all();
        return view('professeurs.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telephone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
            'specialite' => 'nullable|string|max:255',
            'module_ids' => 'nullable|array',
            'module_ids.*' => 'exists:modules,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => Hash::make($request->password),
            'role' => 'professeur',
        ]);

        $professeur = Professeur::create([
            'user_id' => $user->id,
            'specialite' => $request->specialite,
        ]);

        $professeur->modules()->sync($request->module_ids ?? []);

        return redirect()->route('professeurs.index')
            ->with('success', 'Professeur ajouté avec succès.');
    }

    public function show(Professeur $professeur)
    {
        $professeur->load('user', 'modules', 'seances.classe', 'seances.module');

        return view('professeurs.show', compact('professeur'));
    }

    public function edit(Professeur $professeur)
    {
        $professeur->load('user', 'modules');
        $modules = Module::all();

        return view('professeurs.edit', compact('professeur', 'modules'));
    }

    public function update(Request $request, Professeur $professeur)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $professeur->user_id,
            'telephone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8',
            'specialite' => 'nullable|string|max:255',
            'module_ids' => 'nullable|array',
            'module_ids.*' => 'exists:modules,id',
        ]);

        $professeur->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $request->telephone,
        ]);

        if ($request->filled('password')) {
            $professeur->user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        $professeur->update([
            'specialite' => $request->specialite,
        ]);

        $professeur->modules()->sync($request->module_ids ?? []);

        return redirect()->route('professeurs.index')
            ->with('success', 'Professeur modifié avec succès.');
    }

    public function destroy(Professeur $professeur)
    {
        $professeur->modules()->detach();
        $professeur->delete();
        $professeur->user?->delete();

        return redirect()->route('professeurs.index')
            ->with('success', 'Professeur supprimé avec succès.');
    }
}
