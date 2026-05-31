@extends('layouts.admin')

@section('page-title', 'Détail de la séance')
@section('page-subtitle', 'Informations et présences liées à la séance')

@section('admin-content')
<div class="sp-card mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1">{{ $seance->module->nom ?? '-' }}</h4>
            <p class="text-muted mb-0">
                {{ $seance->classe->nom ?? '-' }} |
                {{ $seance->date }} |
                {{ $seance->heure_debut }} - {{ $seance->heure_fin }}
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('seances.edit', $seance) }}" class="sp-btn">
                <i class="bi bi-pencil"></i>
                Modifier
            </a>

            <a href="{{ route('seances.index') }}" class="sp-btn-light">
                <i class="bi bi-arrow-left"></i>
                Retour
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="sp-card h-100">
            <h5 class="fw-bold mb-4">Informations</h5>

            <div class="mb-3">
                <div class="text-muted fw-bold small">Professeur</div>
                <div>{{ $seance->professeur->user->name ?? '-' }}</div>
            </div>

            <div class="mb-3">
                <div class="text-muted fw-bold small">Classe</div>
                <div>{{ $seance->classe->nom ?? '-' }}</div>
            </div>

            <div>
                <div class="text-muted fw-bold small">Module</div>
                <div>{{ $seance->module->nom ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="sp-card">
            <h5 class="fw-bold mb-4">Présences de la séance</h5>

            <div class="table-responsive">
                <table class="table sp-table">
                    <thead>
                        <tr>
                            <th>Étudiant</th>
                            <th>Statut</th>
                            <th>Heure scan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($seance->presences as $presence)
                            <tr>
                                <td class="fw-bold">{{ $presence->etudiant->user->name ?? '-' }}</td>
                                <td>
                                    @if($presence->status === 'present')
                                        <span class="sp-badge sp-badge-success">Présent</span>
                                    @elseif($presence->status === 'absent')
                                        <span class="sp-badge sp-badge-danger">Absent</span>
                                    @elseif($presence->status === 'retard')
                                        <span class="sp-badge sp-badge-warning">Retard</span>
                                    @else
                                        <span class="sp-badge sp-badge-info">Justifié</span>
                                    @endif
                                </td>
                                <td>{{ $presence->heure_scan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <div class="sp-empty">
                                        <i class="bi bi-check2-square"></i>
                                        <div class="fw-bold mt-2">Aucune présence pour cette séance</div>
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