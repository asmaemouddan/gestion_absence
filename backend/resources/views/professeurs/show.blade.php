@extends('layouts.admin')

@section('page-title', 'Détail du professeur')
@section('page-subtitle', 'Informations du professeur')

@section('admin-content')
<div class="sp-card mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <div class="sp-avatar">
                {{ strtoupper(substr($professeur->user->name ?? 'P', 0, 1)) }}
            </div>
            <div>
                <h4 class="fw-bold mb-1">{{ $professeur->user->name ?? '-' }}</h4>
                <p class="text-muted mb-0">{{ $professeur->specialite ?? 'Sans spécialité' }}</p>
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('professeurs.edit', $professeur) }}" class="sp-btn">
                <i class="bi bi-pencil"></i>
                Modifier
            </a>

            <a href="{{ route('professeurs.index') }}" class="sp-btn-light">
                <i class="bi bi-arrow-left"></i>
                Retour
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="sp-card h-100">
            <h5 class="fw-bold mb-4">Informations</h5>

            <div class="mb-3">
                <div class="text-muted fw-bold small">Email</div>
                <div>{{ $professeur->user->email ?? '-' }}</div>
            </div>

            <div class="mb-3">
                <div class="text-muted fw-bold small">Téléphone</div>
                <div>{{ $professeur->user->telephone ?? '-' }}</div>
            </div>

            <div>
                <div class="text-muted fw-bold small">Modules</div>
                <div class="mt-2">
                    @forelse($professeur->modules as $module)
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
            <h5 class="fw-bold mb-4">Séances du professeur</h5>

            <div class="table-responsive">
                <table class="table sp-table">
                    <thead>
                        <tr>
                            <th>Module</th>
                            <th>Classe</th>
                            <th>Date</th>
                            <th>Horaire</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($professeur->seances as $seance)
                            <tr>
                                <td class="fw-bold">{{ $seance->module->nom ?? '-' }}</td>
                                <td>{{ $seance->classe->nom ?? '-' }}</td>
                                <td>{{ $seance->date }}</td>
                                <td>{{ $seance->heure_debut }} - {{ $seance->heure_fin }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="sp-empty">
                                        <i class="bi bi-calendar-x"></i>
                                        <div class="fw-bold mt-2">Aucune séance enregistrée</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection