@extends('layouts.admin')

@section('page-title', 'Détail de la présence')
@section('page-subtitle', 'Informations liées à l’étudiant et à la séance')

@section('admin-content')
<div class="sp-card mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1">{{ $presence->etudiant->user->name ?? '-' }}</h4>
            <p class="text-muted mb-0">
                {{ $presence->seance->module->nom ?? '-' }} |
                {{ $presence->seance->classe->nom ?? '-' }}
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('presences.edit', $presence) }}" class="sp-btn">
                <i class="bi bi-pencil"></i>
                Modifier
            </a>

            <a href="{{ route('presences.index') }}" class="sp-btn-light">
                <i class="bi bi-arrow-left"></i>
                Retour
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="sp-card h-100">
            <h5 class="fw-bold mb-4">Informations de présence</h5>

            <div class="mb-3">
                <div class="text-muted fw-bold small">Statut</div>
                <div class="mt-2">
                    @if($presence->status === 'present')
                        <span class="sp-badge sp-badge-success">Présent</span>
                    @elseif($presence->status === 'absent')
                        <span class="sp-badge sp-badge-danger">Absent</span>
                    @elseif($presence->status === 'retard')
                        <span class="sp-badge sp-badge-warning">Retard</span>
                    @else
                        <span class="sp-badge sp-badge-info">Justifié</span>
                    @endif
                </div>
            </div>

            <div class="mb-3">
                <div class="text-muted fw-bold small">Heure scan</div>
                <div>{{ $presence->heure_scan ?? '-' }}</div>
            </div>

            <div>
                <div class="text-muted fw-bold small">Date séance</div>
                <div>{{ $presence->seance->date ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="sp-card h-100">
            <h5 class="fw-bold mb-4">Justification</h5>

            @if($presence->justification)
                <div class="mb-3">
                    <div class="text-muted fw-bold small">Motif</div>
                    <div>{{ $presence->justification->motif }}</div>
                </div>

                <div class="mb-3">
                    <div class="text-muted fw-bold small">Statut</div>
                    <div class="mt-2">
                        @if($presence->justification->status === 'acceptee')
                            <span class="sp-badge sp-badge-success">Acceptée</span>
                        @elseif($presence->justification->status === 'refusee')
                            <span class="sp-badge sp-badge-danger">Refusée</span>
                        @else
                            <span class="sp-badge sp-badge-warning">En attente</span>
                        @endif
                    </div>
                </div>

                @if($presence->justification->fichier)
                    <a href="{{ asset('storage/' . $presence->justification->fichier) }}" target="_blank" class="sp-btn-light">
                        <i class="bi bi-paperclip"></i>
                        Voir le fichier
                    </a>
                @endif
            @else
                <div class="sp-empty">
                    <i class="bi bi-file-earmark-text"></i>
                    <div class="fw-bold mt-2">Aucune justification liée</div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection