@extends('layouts.admin')

@section('page-title', 'Ajouter une classe')
@section('page-subtitle', 'Création d’une nouvelle classe')

@section('admin-content')
<div class="sp-card">
    <form method="POST" action="{{ route('classes.store') }}">
        @csrf

        <div class="mb-4">
            <label for="nom" class="form-label">Nom de la classe</label>
            <input type="text" name="nom" id="nom"
                   class="form-control @error('nom') is-invalid @enderror"
                   value="{{ old('nom') }}"
                   required>

            @error('nom')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="sp-btn">
                <i class="bi bi-check2-circle"></i>
                Enregistrer
            </button>

            <a href="{{ route('classes.index') }}" class="sp-btn-light">
                <i class="bi bi-arrow-left"></i>
                Retour
            </a>
        </div>
    </form>
</div>
@endsection