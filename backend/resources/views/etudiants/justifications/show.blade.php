@extends('layouts.etudiant')

@section('page-title', 'Détails de la justification')
@section('page-subtitle', 'Consultation de la justification')

@section('etudiant-content')
<div class="sp-card">

    <div class="mb-3">
        <label class="form-label fw-bold">Absence</label>
        <p>
            {{ $justification->presence->seance->module->nom }}
            - {{ $justification->presence->seance->date }}
        </p>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Motif</label>
        <p>{{ $justification->motif }}</p>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Statut</label>

        @if($justification->status == 'en_attente')
            <span class="badge bg-warning">En attente</span>
        @elseif($justification->status == 'acceptee')
            <span class="badge bg-success">Acceptée</span>
        @else
            <span class="badge bg-danger">Refusée</span>
        @endif
    </div>

    @if($justification->fichier)
        <div class="mb-3">
            <label class="form-label fw-bold">Fichier justificatif</label>
            <br>
            <a href="{{ asset('storage/'.$justification->fichier) }}"
               target="_blank"
               class="sp-btn-light">
                Voir le fichier
            </a>
        </div>
    @endif

    <a href="{{ route('etudiant.justifications') }}"
       class="sp-btn-light">
        Retour
    </a>

</div>
@endsection
