<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClasseRequest;
use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = Classe::all();
        return view('classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('classes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClasseRequest $request)
    {
        Classe::create($request->validated());
        return redirect()->route('classes.index')->with('success', 'Classe created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Classe $class)
    {
        // $classe->load('etudiants.user');
        $classe = Classe::with('etudiants.user')->findOrFail($class->id);
        return view('classes.show', compact('classe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classe $class)
    {
        return view('classes.edit', compact('class'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClasseRequest $request, Classe $class)
    {
        $class->update($request->validated());
        return redirect()->route('classes.index')->with('success', 'Classe updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classe $class)
    {
        $class->delete();
        return redirect()->route('classes.index')->with('success', 'Classe deleted successfully.');
    }
}
