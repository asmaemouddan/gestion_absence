<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modules = Module::all();
        return view('modules.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('modules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'nom' => 'required|string|max:255|unique:modules,nom',
        ]);

        Module::create([
            'nom' => $request->nom,
        ]);

        return redirect()->route('modules.index')
            ->with('success', 'Module ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Module $module)
    {
        $module->load('professeurs.user', 'seances');
        return view('modules.show', compact('module'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Module $module)
    {
        return view('modules.edit', compact('module'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Module $module)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:modules,nom,' . $module->id,
        ]);

        $module->update([
            'nom' => $request->nom,
        ]);

        return redirect()->route('modules.index')
            ->with('success', 'Module mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $module)
    {
        $module->delete();
        return redirect()->route('modules.index')
            ->with('success', 'Module supprimé avec succès.');
    }
}
