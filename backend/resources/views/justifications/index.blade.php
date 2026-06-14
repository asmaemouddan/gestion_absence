@extends('layouts.admin')

@section('page-title', 'Justifications')
@section('page-subtitle', 'Gestion des demandes de justification')

@section('admin-content')
<div class="sp-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Liste des justifications</h5>
            <p class="text-muted mb-0">Traitement des motifs et fichiers justificatifs.</p>
        </div>

        <a href="{{ route('justifications.create') }}" class="sp-btn">
            <i class="bi bi-plus-circle"></i>
            Ajouter
        </a>
    </div>

    <div class="table-responsive">
        <table class="table sp-table">
            <thead>
                <tr>
                    <th>Étudiant</th>
                    <th>Classe</th>
                    <th>Module</th>
                    <th>Motif</th>
                    <th>Fichier</th>
                    <th>Statut</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($justifications as $justification)
                    <tr>
                        <td class="fw-bold">{{ $justification->presence->etudiant->user->name ?? '-' }}</td>
                        <td>{{ $justification->presence->seance->classe->nom ?? '-' }}</td>
                        <td>{{ $justification->presence->seance->module->nom ?? '-' }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($justification->motif, 45) }}</td>
                        <td>
                            @if($justification->fichier)
                                <a href="{{ asset('storage/' . $justification->fichier) }}" target="_blank" class="sp-badge sp-badge-info">
                                    <i class="bi bi-paperclip"></i>
                                    Voir
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($justification->status === 'acceptee')
                                <span class="sp-badge sp-badge-success">Acceptée</span>
                            @elseif($justification->status === 'refusee')
                                <span class="sp-badge sp-badge-danger">Refusée</span>
                            @else
                                <span class="sp-badge sp-badge-warning">En attente</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('justifications.show', $justification) }}" class="sp-action"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('justifications.edit', $justification) }}" class="sp-action"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('justifications.destroy', $justification) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="sp-action" onclick="return confirm('Supprimer cette justification ?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="sp-empty">
                                <i class="bi bi-file-earmark-text"></i>
                                <div class="fw-bold mt-2">Aucune justification enregistrée</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
