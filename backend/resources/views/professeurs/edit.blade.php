@extends('layouts.admin')

@section('page-title', 'Modifier un professeur')
@section('page-subtitle', 'Mise à jour du compte professeur')

@section('admin-content')
<div class="sp-card">
    <form method="POST" action="{{ route('professeurs.update', $professeur) }}">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-md-6">
                <label for="name" class="form-label">Nom complet</label>
                <input type="text" name="name" id="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $professeur->user->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label">Adresse email</label>
                <input type="email" name="email" id="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $professeur->user->email) }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="text" name="telephone" id="telephone"
                       class="form-control @error('telephone') is-invalid @enderror"
                       value="{{ old('telephone', $professeur->user->telephone) }}">
                @error('telephone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="specialite" class="form-label">Spécialité</label>
                <input type="text" name="specialite" id="specialite"
                       class="form-control @error('specialite') is-invalid @enderror"
                       value="{{ old('specialite', $professeur->specialite) }}">
                @error('specialite') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="password" class="form-label">Nouveau mot de passe</label>
                <input type="password" name="password" id="password"
                       class="form-control @error('password') is-invalid @enderror">
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Modules affectés</label>
                <div class="sp-card" style="box-shadow:none; padding:14px;">
                    @php
                        $selectedModules = old('module_ids', $professeur->modules->pluck('id')->toArray());
                    @endphp

                    @forelse($modules as $module)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox"
                                   name="module_ids[]"
                                   value="{{ $module->id }}"
                                   id="module_{{ $module->id }}"
                                   {{ in_array($module->id, $selectedModules) ? 'checked' : '' }}>
                            <label class="form-check-label" for="module_{{ $module->id }}">
                                {{ $module->nom }}
                            </label>
                        </div>
                    @empty
                        <span class="text-muted">Aucun module disponible</span>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="sp-btn">
                <i class="bi bi-check2-circle"></i>
                Modifier
            </button>

            <a href="{{ route('professeurs.index') }}" class="sp-btn-light">
                <i class="bi bi-arrow-left"></i>
                Retour
            </a>
        </div>
    </form>
</div>
@endsection