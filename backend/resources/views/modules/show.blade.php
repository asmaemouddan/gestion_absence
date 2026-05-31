@extends('layouts.admin')

@section('page-title', 'Détail du module')
@section('page-subtitle', 'Informations du module et affectations')

@section('admin-content')
<div class="sp-card mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1">{{ $module->nom }}</h4>
            <p class="text-muted mb-0">Module créé le {{ $module->created_at?->format('d/m/Y') }}</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('modules.edit', $module) }}" class="sp-btn">
                <i class="bi bi-pencil"></i>
                Modifier
            </a>

            <a href="{{ route('modules.index') }}" class="sp-btn-light">
                <i class="bi bi-arrow-left"></i>
                Retour
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="sp-card h-100">
            <h5 class="fw-bold mb-4">Professeurs affectés</h5>

            @forelse($module->professeurs as $professeur)
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="sp-avatar">
                        {{ strtoupper(substr($professeur->user->name ?? 'P', 0, 1)) }}
                    </div>
                    <div>
                        <div class="fw-bold">{{ $professeur->user->name ?? '-' }}</div>
                        <small class="text-muted">{{ $professeur->specialite ?? 'Sans spécialité' }}</small>
                    </div>
                </div>
            @empty
                <div class="sp-empty">
                    <i class="bi bi-person-badge"></i>
                    <div class="fw-bold mt-2">Aucun professeur affecté</div>
                </div>
            @endforelse
        </div>
    </div>

    <div class="col-lg-6">
        <div class="sp-card h-100">
            <h5 class="fw-bold mb-4">Séances liées</h5>

            @forelse($module->seances as $seance)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <div class="fw-bold">{{ $seance->classe->nom ?? '-' }}</div>
                        <small class="text-muted">{{ $seance->date }} | {{ $seance->heure_debut }} - {{ $seance->heure_fin }}</small>
                    </div>
                    <a href="{{ route('seances.show', $seance) }}" class="sp-action">
                        <i class="bi bi-eye"></i>
                    </a>
                </div>
            @empty
                <div class="sp-empty">
                    <i class="bi bi-calendar-event"></i>
                    <div class="fw-bold mt-2">Aucune séance liée</div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection