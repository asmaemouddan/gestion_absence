@extends('layouts.admin')

@section('page-title', 'Classes')
@section('page-subtitle', 'Gestion des classes et groupes')

@section('admin-content')
<div class="sp-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Liste des classes</h5>
            <p class="text-muted mb-0">Organisation des étudiants par classe.</p>
        </div>

        <a href="{{ route('classes.create') }}" class="sp-btn">
            <i class="bi bi-plus-circle"></i>
            Ajouter
        </a>
    </div>

    <div class="table-responsive">
        <table class="table sp-table">
            <thead>
                <tr>
                    <th>Nom de la classe</th>
                    <th>Date de création</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classes as $classe)
                    <tr>
                        <td class="fw-bold">{{ $classe->nom ?? '-' }}</td>
                        <td>{{ $classe->created_at?->format('d/m/Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('classes.show', $classe) }}" class="sp-action"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('classes.edit', $classe) }}" class="sp-action"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('classes.destroy', $classe) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="sp-action" onclick="return confirm('Supprimer cette classe ?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">
                            <div class="sp-empty">
                                <i class="bi bi-building"></i>
                                <div class="fw-bold mt-2">Aucune classe enregistrée</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection