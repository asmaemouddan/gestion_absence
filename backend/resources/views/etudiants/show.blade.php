@extends('layouts.admin')

@section('page-title', 'Détail de l’étudiant')
@section('page-subtitle', 'Informations et historique des présences')

@section('admin-content')
<div class="sp-card mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            @if($etudiant->image && file_exists(public_path('storage/' . $etudiant->image)))
                <img src="{{ asset('storage/' . $etudiant->image) }}"
                     width="60"
                     height="60"
                     class="rounded-circle object-fit-cover">
            @else
                <div class="sp-avatar" style="width:60px;height:60px;">
                    {{ strtoupper(substr($etudiant->user->name ?? 'E', 0, 1)) }}
                </div>
            @endif

            <div>
                <h4 class="fw-bold mb-1">{{ $etudiant->user->name ?? '-' }}</h4>
                <p class="text-muted mb-0">{{ $etudiant->classe->nom ?? '-' }}</p>
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('etudiants.index') }}" class="sp-btn-light">
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
                <div class="text-muted fw-bold small">Nom complet</div>
                <div>{{ $etudiant->user->name ?? '-' }}</div>
            </div>

            <div class="mb-3">
                <div class="text-muted fw-bold small">Email</div>
                <div>{{ $etudiant->user->email ?? '-' }}</div>
            </div>

            <div class="mb-3">
                <div class="text-muted fw-bold small">Téléphone</div>
                <div>{{ $etudiant->user->telephone ?? '-' }}</div>
            </div>

            <div>
                <div class="text-muted fw-bold small">Classe</div>
                <div>{{ $etudiant->classe->nom ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="sp-card">
            <h5 class="fw-bold mb-4">Historique des présences</h5>

            <div class="table-responsive">
                <table class="table sp-table">
                    <thead>
                        <tr>
                            <th>Module</th>
                            <th>Date séance</th>
                            <th>Statut</th>
                            <th>Heure scan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($etudiant->presences as $presence)
                            <tr>
                                <td class="fw-bold">{{ $presence->seance->module->nom ?? '-' }}</td>
                                <td>{{ $presence->seance->date ?? '-' }}</td>
                                <td>
                                    @if($presence->status === 'present')
                                        <span class="sp-badge sp-badge-success">Présent</span>
                                    @elseif($presence->status === 'absent')
                                        <span class="sp-badge sp-badge-danger">Absent</span>
                                    @elseif($presence->status === 'retard')
                                        <span class="sp-badge sp-badge-warning">Retard</span>
                                    @elseif($presence->status === 'justifie')
                                        <span class="sp-badge sp-badge-info">Justifié</span>
                                    @else
                                        <span class="sp-badge sp-badge-info">{{ $presence->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $presence->heure_scan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="sp-empty">
                                        <i class="bi bi-check2-square"></i>
                                        <div class="fw-bold mt-2">Aucune présence enregistrée</div>
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