<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClasseRequest;
use App\Models\Classe;

class ClasseController extends Controller
{
    public function index()
    {
        $classes = Classe::all();
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        return view('classes.create');
    }

    public function store(ClasseRequest $request)
    {
        Classe::create($request->validated());

        return redirect()
            ->route('classes.index')
            ->with('success', 'Classe ajoutée avec succès.');
    }

    public function show(Classe $classe)
    {
        $classe->load('etudiants.user');

        return view('classes.show', compact('classe'));
    }

    public function edit(Classe $classe)
    {
        return view('classes.edit', compact('classe'));
    }

    public function update(ClasseRequest $request, Classe $classe)
    {
        $classe->update($request->validated());

        return redirect()
            ->route('classes.index')
            ->with('success', 'Classe modifiée avec succès.');
    }

    public function destroy(Classe $classe)
    {
        $classe->delete();

        return redirect()
            ->route('classes.index')
            ->with('success', 'Classe supprimée avec succès.');
    }
}