@extends('layouts.etudiant')

@section('page-title', 'Tableau de bord')
@section('page-subtitle', 'Suivi personnel des présences et justifications')

@section('etudiant-content')
@php
    $etudiant = \App\Models\Etudiant::with(
        'classe',
        'presences.seance.module',
        'presences.justification'
    )->where('user_id', Auth::id())->first();

    $presences = $etudiant?->presences ?? collect();

    $totalPresences = $presences->count();
    $totalAbsences = $presences->where('status', 'absent')->count();
    $totalRetards = $presences->where('status', 'retard')->count();
    $totalJustifiees = $presences->where('status', 'justifie')->count();

    $dernieresPresences = $presences->sortByDesc('created_at')->take(6);
@endphp

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="sp-card sp-stat-card">
            <div class="sp-stat-icon sp-icon-blue">
                <i class="bi bi-check2-square"></i>
            </div>
            <div>
                <div class="sp-stat-label">Présences</div>
                <div class="sp-stat-number">{{ $totalPresences }}</div>
                <div class="sp-stat-note">Total enregistré</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="sp-card sp-stat-card">
            <div class="sp-stat-icon sp-icon-red">
                <i class="bi bi-x-circle"></i>
            </div>
            <div>
                <div class="sp-stat-label">Absences</div>
                <div class="sp-stat-number">{{ $totalAbsences }}</div>
                <div class="sp-stat-note">À justifier</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="sp-card sp-stat-card">
            <div class="sp-stat-icon sp-icon-orange">
                <i class="bi bi-clock"></i>
            </div>
            <div>
                <div class="sp-stat-label">Retards</div>
                <div class="sp-stat-number">{{ $totalRetards }}</div>
                <div class="sp-stat-note">Retards enregistrés</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="sp-card sp-stat-card">
            <div class="sp-stat-icon sp-icon-green">
                <i class="bi bi-file-earmark-check"></i>
            </div>
            <div>
                <div class="sp-stat-label">Justifiées</div>
                <div class="sp-stat-number">{{ $totalJustifiees }}</div>
                <div class="sp-stat-note">Absences justifiées</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
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
                <div class="text-muted fw-bold small">Classe</div>
                <div>{{ $etudiant->classe->nom ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="sp-card">
            <h5 class="fw-bold mb-4">Dernières présences</h5>

            <div class="table-responsive">
                <table class="table sp-table">
                    <thead>
                        <tr>
                            <th>Module</th>
                            <th>Date séance</th>
                            <th>Statut</th>
                            <th>Justification</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dernieresPresences as $presence)
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
                                    @else
                                        <span class="sp-badge sp-badge-info">Justifié</span>
                                    @endif
                                </td>
                                <td>
                                    @if($presence->justification)
                                        @if($presence->justification->status === 'acceptee')
                                            <span class="sp-badge sp-badge-success">Acceptée</span>
                                        @elseif($presence->justification->status === 'refusee')
                                            <span class="sp-badge sp-badge-danger">Refusée</span>
                                        @else
                                            <span class="sp-badge sp-badge-warning">En attente</span>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
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