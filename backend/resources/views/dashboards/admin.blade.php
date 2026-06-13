@extends('layouts.admin')

@section('page-title', 'Tableau de bord')
@section('page-subtitle', 'Vue générale de la gestion des présences')

@section('admin-content')
@php
    $totalEtudiants = \App\Models\Etudiant::count();
    $totalClasses = \App\Models\Classe::count();
    $totalModules = \App\Models\Module::count();
    $totalProfesseurs = \App\Models\Professeur::count();
    $totalSeances = \App\Models\Seance::count();
    $totalPresences = \App\Models\Presence::count();
    $presencesPresent = \App\Models\Presence::where('status', 'present')->count();
    $presencesAbsent = \App\Models\Presence::where('status', 'absent')->count();
    $justificationsAttente = \App\Models\Justification::where('status', 'en_attente')->count();

    $dernieresSeances = \App\Models\Seance::with('classe', 'module', 'professeur.user')
        ->latest()
        ->take(5)
        ->get();

    $dernieresJustifications = \App\Models\Justification::with(
        'presence.etudiant.user',
        'presence.seance.module',
        'presence.seance.classe'
    )
        ->latest()
        ->take(4)
        ->get();
@endphp

<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="sp-card sp-stat-card">
            <div class="sp-stat-icon sp-icon-green">
                <i class="bi bi-mortarboard"></i>
            </div>
            <div>
                <div class="sp-stat-label">Étudiants</div>
                <div class="sp-stat-number">{{ $totalEtudiants }}</div>
                <div class="sp-stat-note">Inscrits dans la plateforme</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="sp-card sp-stat-card">
            <div class="sp-stat-icon sp-icon-blue">
                <i class="bi bi-building"></i>
            </div>
            <div>
                <div class="sp-stat-label">Classes</div>
                <div class="sp-stat-number">{{ $totalClasses }}</div>
                <div class="sp-stat-note">Groupes configurés</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="sp-card sp-stat-card">
            <div class="sp-stat-icon sp-icon-orange">
                <i class="bi bi-calendar-event"></i>
            </div>
            <div>
                <div class="sp-stat-label">Séances</div>
                <div class="sp-stat-number">{{ $totalSeances }}</div>
                <div class="sp-stat-note">Séances enregistrées</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="sp-card sp-stat-card">
            <div class="sp-stat-icon sp-icon-red">
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <div>
                <div class="sp-stat-label">Justifications</div>
                <div class="sp-stat-number">{{ $justificationsAttente }}</div>
                <div class="sp-stat-note">En attente de traitement</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="sp-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-1">Résumé des présences</h5>
                    <p class="text-muted mb-0">Données calculées depuis les enregistrements de présence</p>
                </div>

                <a href="{{ route('presences.index') }}" class="sp-btn-light">
                    <i class="bi bi-eye"></i>
                    Voir les présences
                </a>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <div class="p-4 rounded-4" style="background:#f1fbf8;">
                        <div class="text-muted fw-bold small">Présents</div>
                        <div class="fs-3 fw-bold" style="color:#007f68;">
                            {{ $presencesPresent }}
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-4 rounded-4" style="background:#fff0f3;">
                        <div class="text-muted fw-bold small">Absents</div>
                        <div class="fs-3 fw-bold" style="color:#d92d45;">
                            {{ $presencesAbsent }}
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-4 rounded-4" style="background:#e5efff;">
                        <div class="text-muted fw-bold small">Total présences</div>
                        <div class="fs-3 fw-bold" style="color:#2563eb;">
                            {{ $totalPresences }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="sp-card h-100">
            <h5 class="fw-bold mb-1">Organisation</h5>
            <p class="text-muted mb-4">Structure pédagogique</p>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="fw-bold">
                    <i class="bi bi-person-badge me-2" style="color:#007f68;"></i>
                    Professeurs
                </span>
                <span class="sp-badge sp-badge-success">{{ $totalProfesseurs }}</span>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="fw-bold">
                    <i class="bi bi-book me-2" style="color:#2563eb;"></i>
                    Modules
                </span>
                <span class="sp-badge sp-badge-info">{{ $totalModules }}</span>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold">
                    <i class="bi bi-building me-2" style="color:#ad7300;"></i>
                    Classes
                </span>
                <span class="sp-badge sp-badge-warning">{{ $totalClasses }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="sp-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-1">Dernières séances</h5>
                    <p class="text-muted mb-0">Les dernières séances enregistrées</p>
                </div>

                <a href="{{ route('seances.index') }}" class="sp-btn">
                    <i class="bi bi-calendar-event"></i>
                    Gérer
                </a>
            </div>

            <div class="table-responsive">
                <table class="table sp-table">
                    <thead>
                        <tr>
                            <th>Module</th>
                            <th>Classe</th>
                            <th>Professeur</th>
                            <th>Date</th>
                            <th>Horaire</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($dernieresSeances as $seance)
                            <tr>
                                <td class="fw-bold">{{ $seance->module->nom ?? '-' }}</td>
                                <td>{{ $seance->classe->nom ?? '-' }}</td>
                                <td>{{ $seance->professeur->user->name ?? '-' }}</td>
                                <td>{{ $seance->date }}</td>
                                <td>{{ $seance->heure_debut }} - {{ $seance->heure_fin }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
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

    <div class="col-lg-4">
        <div class="sp-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-1">Justifications</h5>
                    <p class="text-muted mb-0">Dernières demandes</p>
                </div>

                <a href="{{ route('justifications.index') }}" class="sp-btn-light">
                    Voir
                </a>
            </div>

            @forelse ($dernieresJustifications as $justification)
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="sp-avatar">
                        {{ strtoupper(substr($justification->presence->etudiant->user->name ?? 'E', 0, 1)) }}
                    </div>

                    <div class="flex-grow-1">
                        <div class="fw-bold">
                            {{ $justification->presence->etudiant->user->name ?? '-' }}
                        </div>
                        <small class="text-muted">
                            {{ $justification->presence->seance->module->nom ?? '-' }}
                        </small>
                    </div>

                    @if ($justification->status === 'acceptee')
                        <span class="sp-badge sp-badge-success">Acceptée</span>
                    @elseif ($justification->status === 'refusee')
                        <span class="sp-badge sp-badge-danger">Refusée</span>
                    @else
                        <span class="sp-badge sp-badge-warning">En attente</span>
                    @endif
                </div>
            @empty
                <div class="sp-empty">
                    <i class="bi bi-file-earmark-check"></i>
                    <div class="fw-bold mt-2">Aucune justification</div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
