@extends('layouts.admin')

@section('page-title', 'Modifier une justification')
@section('page-subtitle', 'Traitement de la demande de justification')

@section('admin-content')
<div class="sp-card">
    <form method="POST" action="{{ route('justifications.update', $justification) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-md-12">
                <label class="form-label">Absence concernée</label>
                <input type="text" class="form-control"
                       value="{{ $justification->presence->etudiant->user->name ?? '-' }} - {{ $justification->presence->seance->module->nom ?? '-' }} - {{ $justification->presence->seance->date ?? '-' }}"
                       disabled>
            </div>

            <div class="col-md-12">
                <label for="motif" class="form-label">Motif</label>
                <textarea name="motif" id="motif" rows="5"
                          class="form-control @error('motif') is-invalid @enderror"
                          required>{{ old('motif', $justification->motif) }}</textarea>
                @error('motif') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="status" class="form-label">Statut</label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="en_attente" {{ old('status', $justification->status) === 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="acceptee" {{ old('status', $justification->status) === 'acceptee' ? 'selected' : '' }}>Acceptée</option>
                    <option value="refusee" {{ old('status', $justification->status) === 'refusee' ? 'selected' : '' }}>Refusée</option>
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="fichier" class="form-label">Nouveau fichier justificatif</label>
                <input type="file" name="fichier" id="fichier"
                       class="form-control @error('fichier') is-invalid @enderror"
                       accept=".pdf,image/png,image/jpeg,image/jpg">
                @error('fichier') <div class="invalid-feedback">{{ $message }}</div> @enderror

                @if($justification->fichier)
                    <a href="{{ asset('storage/' . $justification->fichier) }}" target="_blank" class="sp-badge sp-badge-info mt-3">
                        <i class="bi bi-paperclip"></i>
                        Voir le fichier actuel
                    </a>
                @endif
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="sp-btn">
                <i class="bi bi-check2-circle"></i>
                Modifier
            </button>

            <a href="{{ route('justifications.index') }}" class="sp-btn-light">
                <i class="bi bi-arrow-left"></i>
                Retour
            </a>
        </div>
    </form>
</div>
@endsection