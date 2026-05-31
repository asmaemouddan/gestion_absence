@extends('layouts.admin')

@section('page-title', 'Professeurs')
@section('page-subtitle', 'Liste des professeurs enregistrés')

@section('admin-content')
<div class="sp-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Gestion des professeurs</h5>
            <p class="text-muted mb-0">Comptes professeurs, spécialités et modules affectés.</p>
        </div>

        <a href="{{ route('professeurs.create') }}" class="sp-btn">
            <i class="bi bi-plus-circle"></i>
            Ajouter
        </a>
    </div>

    <div class="table-responsive">
        <table class="table sp-table">
            <thead>
                <tr>
                    <th>Nom complet</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Spécialité</th>
                    <th>Modules</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($professeurs as $professeur)
                    <tr>
                        <td class="fw-bold">{{ $professeur->user->name ?? '-' }}</td>
                        <td>{{ $professeur->user->email ?? '-' }}</td>
                        <td>{{ $professeur->user->telephone ?? '-' }}</td>
                        <td>{{ $professeur->specialite ?? '-' }}</td>
                        <td>
                            @forelse($professeur->modules as $module)
                                <span class="sp-badge sp-badge-info me-1 mb-1">{{ $module->nom }}</span>
                            @empty
                                <span class="text-muted">-</span>
                            @endforelse
                        </td>
                        <td class="text-end">
                            <a href="{{ route('professeurs.show', $professeur) }}" class="sp-action"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('professeurs.edit', $professeur) }}" class="sp-action"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('professeurs.destroy', $professeur) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="sp-action" onclick="return confirm('Supprimer ce professeur ?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="sp-empty">
                                <i class="bi bi-person-badge"></i>
                                <div class="fw-bold mt-2">Aucun professeur enregistré</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $professeurs->links() }}
    </div>
</div>
@endsection