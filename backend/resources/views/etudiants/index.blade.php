@extends('layouts.admin')

@section('page-title', 'Étudiants')
@section('page-subtitle', 'Liste des étudiants inscrits')

@section('admin-content')
<div class="sp-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Gestion des étudiants</h5>
            <p class="text-muted mb-0">Consulter, ajouter, modifier ou supprimer les étudiants.</p>
        </div>

        <a href="{{ route('etudiants.create') }}" class="sp-btn">
            <i class="bi bi-plus-circle"></i>
            Ajouter
        </a>
    </div>

    <div class="table-responsive">
        <table class="table sp-table">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Nom complet</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Classe</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($etudiants as $etudiant)
                    <tr>
                        <td>
                           @if($etudiant->image && file_exists(public_path('storage/' . $etudiant->image)))
    <img src="{{ asset('storage/' . $etudiant->image) }}" width="46" height="46" class="rounded-circle object-fit-cover">
@else
    <div class="sp-avatar">{{ strtoupper(substr($etudiant->user->name ?? 'E', 0, 1)) }}</div>
@endif
                        </td>
                        <td class="fw-bold">{{ $etudiant->user->name ?? '-' }}</td>
                        <td>{{ $etudiant->user->email ?? '-' }}</td>
                        <td>{{ $etudiant->user->telephone ?? '-' }}</td>
                        <td>{{ $etudiant->classe->nom ?? '-' }}</td>
                        <td class="text-end">
                            <a href="{{ route('etudiants.show', $etudiant) }}" class="sp-action"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('etudiants.edit', $etudiant) }}" class="sp-action"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('etudiants.destroy', $etudiant) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="sp-action" onclick="return confirm('Supprimer cet étudiant ?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="sp-empty">
                                <i class="bi bi-mortarboard"></i>
                                <div class="fw-bold mt-2">Aucun étudiant enregistré</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection