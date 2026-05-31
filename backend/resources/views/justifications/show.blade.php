@extends('layouts.admin')

@section('page-title', 'Détail de la justification')
@section('page-subtitle', 'Informations de la demande')

@section('admin-content')
<div class="sp-card mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1">{{ $justification->presence->etudiant->user->name ?? '-' }}</h4>
            <p class="text-muted mb-0">
                {{ $justification->presence->seance->module->nom ?? '-' }} |
                {{ $justification->presence->seance->classe->nom ?? '-' }}
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('justifications.edit', $justification) }}" class="sp-btn">
                <i class="bi bi-pencil"></i>
                Modifier
            </a>

            <a href="{{ route('justifications.index') }}" class="sp-btn-light">
                <i class="bi bi-arrow-left"></i>
                Retour
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="sp-card h-100">
            <h5 class="fw-bold mb-4">Justification</h5>

            <div class="mb-3">
                <div class="text-muted fw-bold small">Motif</div>
                <div>{{ $justification->motif }}</div>
            </div>

            <div class="mb-3">
                <div class="text-muted fw-bold small">Statut</div>
                <div class="mt-2">
                    @if($justification->status === 'acceptee')
                        <span class="sp-badge sp-badge-success">Acceptée</span>
                    @elseif($justification->status === 'refusee')
                        <span class="sp-badge sp-badge-danger">Refusée</span>
                    @else
                        <span class="sp-badge sp-badge-warning">En attente</span>
                    @endif
                </div>
            </div>

            @if($justification->fichier)
                <a href="{{ asset('storage/' . $justification->fichier) }}" target="_blank" class="sp-btn-light">
                    <i class="bi bi-paperclip"></i>
                    Voir le fichier
                </a>
            @endif
        </div>
    </div>

    <div class="col-lg-6">
        <div class="sp-card h-100">
            <h5 class="fw-bold mb-4">Absence concernée</h5>

            <div class="mb-3">
                <div class="text-muted fw-bold small">Étudiant</div>
                <div>{{ $justification->presence->etudiant->user->name ?? '-' }}</div>
            </div>

            <div class="mb-3">
                <div class="text-muted fw-bold small">Classe</div>
                <div>{{ $justification->presence->seance->classe->nom ?? '-' }}</div>
            </div>

            <div class="mb-3">
                <div class="text-muted fw-bold small">Module</div>
                <div>{{ $justification->presence->seance->module->nom ?? '-' }}</div>
            </div>

            <div>
                <div class="text-muted fw-bold small">Date séance</div>
                <div>{{ $justification->presence->seance->date ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>
@endsection