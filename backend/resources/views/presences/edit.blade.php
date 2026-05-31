@extends('layouts.admin')

@section('page-title', 'Modifier une présence')
@section('page-subtitle', 'Mise à jour du statut de présence')

@section('admin-content')
<div class="sp-card">
    <form method="POST" action="{{ route('presences.update', $presence) }}">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-md-6">
                <label for="etudiant_id" class="form-label">Étudiant</label>
                <select name="etudiant_id" id="etudiant_id" class="form-select @error('etudiant_id') is-invalid @enderror" required>
                    <option value="">Sélectionner un étudiant</option>
                    @foreach($etudiants as $etudiant)
                        <option value="{{ $etudiant->id }}" {{ old('etudiant_id', $presence->etudiant_id) == $etudiant->id ? 'selected' : '' }}>
                            {{ $etudiant->user->name ?? '-' }}
                        </option>
                    @endforeach
                </select>
                @error('etudiant_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="seance_id" class="form-label">Séance</label>
                <select name="seance_id" id="seance_id" class="form-select @error('seance_id') is-invalid @enderror" required>
                    <option value="">Sélectionner une séance</option>
                    @foreach($seances as $seance)
                        <option value="{{ $seance->id }}" {{ old('seance_id', $presence->seance_id) == $seance->id ? 'selected' : '' }}>
                            {{ $seance->module->nom ?? '-' }} - {{ $seance->classe->nom ?? '-' }} - {{ $seance->date }}
                        </option>
                    @endforeach
                </select>
                @error('seance_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="status" class="form-label">Statut</label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="present" {{ old('status', $presence->status) === 'present' ? 'selected' : '' }}>Présent</option>
                    <option value="absent" {{ old('status', $presence->status) === 'absent' ? 'selected' : '' }}>Absent</option>
                    <option value="retard" {{ old('status', $presence->status) === 'retard' ? 'selected' : '' }}>Retard</option>
                    <option value="justifie" {{ old('status', $presence->status) === 'justifie' ? 'selected' : '' }}>Justifié</option>
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="heure_scan" class="form-label">Heure scan</label>
                <input type="time" name="heure_scan" id="heure_scan"
                       class="form-control @error('heure_scan') is-invalid @enderror"
                       value="{{ old('heure_scan', $presence->heure_scan) }}">
                @error('heure_scan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="sp-btn">
                <i class="bi bi-check2-circle"></i>
                Modifier
            </button>

            <a href="{{ route('presences.index') }}" class="sp-btn-light">
                <i class="bi bi-arrow-left"></i>
                Retour
            </a>
        </div>
    </form>
</div>
@endsection