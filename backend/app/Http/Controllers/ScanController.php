<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use App\Models\Presence;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ScanController extends Controller
{
    public function store(Request $request, Seance $seance)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        // Sauvegarder photo séance
        $imagePath = $request->file('image')->store('seances', 'public');

        $seance->update([
            'image_classe' => $imagePath
        ]);

        // Récupérer étudiants de la classe
        $etudiants = Etudiant::where('classe_id', $seance->classe_id)
            ->whereNotNull('image')
            ->get();

        if ($etudiants->isEmpty()) {
            return back()->with('error', 'Aucun étudiant avec photo.');
        }

        // Préparer requête vers Python
        $http = Http::asMultipart();

        // Photo séance
        $http = $http->attach(
            'photo_seance',
            file_get_contents($request->file('image')->getRealPath()),
            'seance.jpg'
        );

        // Photos étudiants
        foreach ($etudiants as $etudiant) {

            $path = Storage::disk('public')->path($etudiant->image);

            if (file_exists($path)) {

                $http = $http->attach(
                    "etudiants[$etudiant->id]",
                    file_get_contents($path),
                    "$etudiant->id.jpg"
                );
            }
        }

        // Appel API Python
        $response = $http
            ->timeout(120)
            ->post(env('FACE_SERVICE_URL') . '/scan');

        if (!$response->successful()) {
            return back()->with(
                'error',
                'Erreur service reconnaissance faciale'
            );
        }

        $data = $response->json();
        dd($response->json());
        $absentsIds = $data['absents'] ?? [];

        // Enregistrer présences
        foreach ($etudiants as $etudiant) {

            $status = in_array($etudiant->id, $absentsIds)
                ? 'absent'
                : 'present';

            Presence::updateOrCreate(
                [
                    'etudiant_id' => $etudiant->id,
                    'seance_id'   => $seance->id,
                ],
                [
                    'status'      => $status,
                    'heure_scan'  => now()->format('H:i:s'),
                ]
            );
        }

        $nbAbsents = count($absentsIds);
        $nbPresents = $etudiants->count() - $nbAbsents;

        return back()->with(
            'success',
            "Scan terminé : $nbPresents présents, $nbAbsents absents"
        );
    }
}
