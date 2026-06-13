@extends('layouts.admin')

@section('page-title', 'Séances')
@section('page-subtitle', 'Planification et suivi des séances')

@section('admin-content')
<div class="sp-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Liste des séances</h5>
            <p class="text-muted mb-0">Séances liées aux classes, modules et professeurs.</p>
        </div>

        <a href="{{ route('seances.create') }}" class="sp-btn">
            <i class="bi bi-plus-circle"></i>
            Ajouter
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
                    <th>Heure début</th>
                    <th>Heure fin</th>
                    <th>Photo</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($seances as $seance)
                    <tr>
                        <td class="fw-bold">{{ $seance->module->nom ?? '-' }}</td>
                        <td>{{ $seance->classe->nom ?? '-' }}</td>
                        <td>{{ $seance->professeur->user->name ?? '-' }}</td>
                        <td>{{ $seance->date }}</td>
                        <td>{{ $seance->heure_debut }}</td>
                        <td>{{ $seance->heure_fin }}</td>

                        <td>
                                        @if($seance->photo)
                <img src="{{ asset('storage/' . $seance->photo) }}" width="60" height="60" style="object-fit:cover;">
            @else
                <span class="text-muted">-</span>
            @endif
                                    </td>

                        <td class="text-end">
                            <a href="{{ route('seances.show', $seance) }}" class="sp-action">
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="{{ route('seances.edit', $seance) }}" class="sp-action">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('seances.destroy', $seance) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="sp-action" onclick="return confirm('Supprimer cette séance ?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="sp-empty">
                                <i class="bi bi-calendar-event"></i>
                                <div class="fw-bold mt-2">Aucune séance enregistrée</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $seances->links() }}
    </div>
</div>
@endsection