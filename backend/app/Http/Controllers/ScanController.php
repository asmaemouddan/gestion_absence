<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ScanController extends Controller
{
      public function store(Request $request, Seance $seance)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $response = Http::attach(
            'image',
            file_get_contents($request->file('image')->getRealPath()),
            $request->file('image')->getClientOriginalName()
        )->post(env('FACE_SERVICE_URL') . '/scan');

        if (!$response->successful()) {
            return back()->with('error', 'Erreur avec le service de reconnaissance faciale.');
        }

        $data = $response->json();

        return back()->with('success', 'Image envoyée au face-service avec succès.');
    }
}
