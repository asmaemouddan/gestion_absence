@extends('layouts.admin')

@section('page-title', 'Modifier un module')
@section('page-subtitle', 'Mise à jour du module')

@section('admin-content')
<div class="sp-card">
    <form method="POST" action="{{ route('modules.update', $module) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nom" class="form-label">Nom du module</label>
            <input type="text" name="nom" id="nom"
                   class="form-control @error('nom') is-invalid @enderror"
                   value="{{ old('nom', $module->nom) }}"
                   required>

            @error('nom')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="sp-btn">
                <i class="bi bi-check2-circle"></i>
                Modifier
            </button>

            <a href="{{ route('modules.index') }}" class="sp-btn-light">
                <i class="bi bi-arrow-left"></i>
                Retour
            </a>
        </div>
    </form>
</div>
@endsection