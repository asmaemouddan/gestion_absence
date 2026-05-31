@extends('layouts.admin')

@section('page-title', 'Modules')
@section('page-subtitle', 'Gestion des modules enseignés')

@section('admin-content')
<div class="sp-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Liste des modules</h5>
            <p class="text-muted mb-0">Modules utilisés dans les séances.</p>
        </div>

        <a href="{{ route('modules.create') }}" class="sp-btn">
            <i class="bi bi-plus-circle"></i>
            Ajouter
        </a>
    </div>

    <div class="table-responsive">
        <table class="table sp-table">
            <thead>
                <tr>
                    <th>Nom du module</th>
                    <th>Date de création</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($modules as $module)
                    <tr>
                        <td class="fw-bold">{{ $module->nom ?? '-' }}</td>
                        <td>{{ $module->created_at?->format('d/m/Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('modules.show', $module) }}" class="sp-action"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('modules.edit', $module) }}" class="sp-action"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('modules.destroy', $module) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="sp-action" onclick="return confirm('Supprimer ce module ?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">
                            <div class="sp-empty">
                                <i class="bi bi-book"></i>
                                <div class="fw-bold mt-2">Aucun module enregistré</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection