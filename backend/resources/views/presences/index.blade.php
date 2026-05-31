@extends('layouts.admin')

@section('page-title', 'Présences')
@section('page-subtitle', 'Suivi des présences, absences et retards')

@section('admin-content')
<div class="sp-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Liste des présences</h5>
            <p class="text-muted mb-0">Présences enregistrées par étudiant et par séance.</p>
        </div>

        <a href="{{ route('presences.create') }}" class="sp-btn">
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
                    <th>Date séance</th>
                    <th>Statut</th>
                    <th>Heure scan</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($presences as $presence)
                    <tr>
                        <td class="fw-bold">{{ $presence->etudiant->user->name ?? '-' }}</td>
                        <td>{{ $presence->seance->classe->nom ?? '-' }}</td>
                        <td>{{ $presence->seance->module->nom ?? '-' }}</td>
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
                        <td class="text-end">
                            <a href="{{ route('presences.show', $presence) }}" class="sp-action"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('presences.edit', $presence) }}" class="sp-action"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('presences.destroy', $presence) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="sp-action" onclick="return confirm('Supprimer cette présence ?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
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

    <div class="mt-4">
        {{ $presences->links() }}
    </div>
</div>
@endsection