@extends('layouts.professeur')

@section('page-title', 'Tableau de bord')
@section('page-subtitle', 'Suivi des séances et modules affectés')

@section('professeur-content')
@php
    $professeur = \App\Models\Professeur::with('modules', 'seances.classe', 'seances.module')
        ->where('user_id', Auth::id())
        ->first();

    $modules = $professeur?->modules ?? collect();
    $seances = $professeur?->seances ?? collect();

    $totalModules = $modules->count();
    $totalSeances = $seances->count();
    $prochainesSeances = $seances->sortByDesc('date')->take(5);
@endphp

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="sp-card sp-stat-card">
            <div class="sp-stat-icon sp-icon-green">
                <i class="bi bi-book"></i>
            </div>
            <div>
                <div class="sp-stat-label">Modules</div>
                <div class="sp-stat-number">{{ $totalModules }}</div>
                <div class="sp-stat-note">Modules affectés</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="sp-card sp-stat-card">
            <div class="sp-stat-icon sp-icon-blue">
                <i class="bi bi-calendar-event"></i>
            </div>
            <div>
                <div class="sp-stat-label">Séances</div>
                <div class="sp-stat-number">{{ $totalSeances }}</div>
                <div class="sp-stat-note">Séances enregistrées</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="sp-card sp-stat-card">
            <div class="sp-stat-icon sp-icon-orange">
                <i class="bi bi-person-badge"></i>
            </div>
            <div>
                <div class="sp-stat-label">Profil</div>
                <div class="sp-stat-number">{{ $professeur ? 'OK' : '-' }}</div>
                <div class="sp-stat-note">Compte professeur</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="sp-card h-100">
            <h5 class="fw-bold mb-4">Mes informations</h5>

            <div class="mb-3">
                <div class="text-muted fw-bold small">Nom complet</div>
                <div>{{ Auth::user()->name }}</div>
            </div>

            <div class="mb-3">
                <div class="text-muted fw-bold small">Email</div>
                <div>{{ Auth::user()->email }}</div>
            </div>

            <div class="mb-3">
                <div class="text-muted fw-bold small">Téléphone</div>
                <div>{{ Auth::user()->telephone ?? '-' }}</div>
            </div>

            <div>
                <div class="text-muted fw-bold small">Modules</div>
                <div class="mt-2">
                    @forelse($modules as $module)
                        <span class="sp-badge sp-badge-info me-1 mb-1">{{ $module->nom }}</span>
                    @empty
                        <span class="text-muted">Aucun module affecté</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="sp-card h-100">
            <h5 class="fw-bold mb-4">Mes séances</h5>
            <div class="table-responsive">
                <table class="table sp-table">
                    <thead>
                        <tr>
                            <th>Module</th>
                            <th>Classe</th>
                            <th>Date</th>
                            <th>Horaire</th>
                            <th>photos seancd</th>

                        </tr>
                    </thead>
        <tbody>
@forelse($prochainesSeances as $seance)
<tr>
    <td class="fw-bold">{{ $seance->module->nom ?? '-' }}</td>
    <td>{{ $seance->classe->nom ?? '-' }}</td>
    <td>{{ $seance->date }}</td>
    <td>{{ $seance->heure_debut }} - {{ $seance->heure_fin }}</td>

    <td>
        <form action="{{ route('seances.photo', $seance->id) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <input type="file" name="image" class="form-control mb-2" accept="image/*" />
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn btn-primary btn-sm border-rounded">
                Scanner
            </button>
        </form>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center">
        Aucune séance enregistrée
    </td>
</tr>
@endforelse
</tbody>
                </table>


            </div>
        </div>
    </div>
</div>


</div>
@endsection
