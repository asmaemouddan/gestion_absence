@extends('layouts.admin')

@section('page-title', 'Détail de la classe')
@section('page-subtitle', 'Informations et étudiants de la classe')

@section('admin-content')
<div class="sp-card mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1">{{ $classe->nom }}</h4>
            <p class="text-muted mb-0">Classe créée le {{ $classe->created_at?->format('d/m/Y') }}</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('classes.edit', ['classe' => $classe->id]) }}" class="sp-btn">
                <i class="bi bi-pencil"></i>
                Modifier
            </a>

            <a href="{{ route('classes.index') }}" class="sp-btn-light">
                <i class="bi bi-arrow-left"></i>
                Retour
            </a>
        </div>
    </div>
</div>

<div class="sp-card">
    <h5 class="fw-bold mb-4">Étudiants de cette classe</h5>

    <div class="table-responsive">
        <table class="table sp-table">
            <thead>
                <tr>
                    <th>Étudiant</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classe->etudiants as $etudiant)
                    <tr>
                        <td class="fw-bold">{{ $etudiant->user->name ?? '-' }}</td>
                        <td>{{ $etudiant->user->email ?? '-' }}</td>
                        <td>{{ $etudiant->user->telephone ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">
                            <div class="sp-empty">
                                <i class="bi bi-mortarboard"></i>
                                <div class="fw-bold mt-2">Aucun étudiant dans cette classe</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection