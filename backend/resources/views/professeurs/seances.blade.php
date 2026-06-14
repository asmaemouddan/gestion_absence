@extends('layouts.professeur')

@section('page-title', 'Mes séances')

@section('professeur-content')

<div class="card">
    <div class="card-header">
        <h4>Liste des séances</h4>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Module</th>
                    <th>Classe</th>
                    <th>Date</th>
                    <th>Horaire</th>
                    <th>Photo séance</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($seances as $seance)
                    <tr>
                        <td>{{ $seance->module->nom ?? '-' }}</td>

                        <td>{{ $seance->classe->nom ?? '-' }}</td>

                        <td>{{ $seance->date }}</td>

                        <td>
                            {{ $seance->heure_debut }}
                            -
                            {{ $seance->heure_fin }}
                        </td>

                        <td style="width:250px">

                            @if($seance->photo)
                                <img
                                    src="{{ asset('storage/' . $seance->photo) }}"
                                    width="120"
                                    class="img-thumbnail mb-2">
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('professeur.seance.presences', $seance->id) }}"
                               class="btn btn-primary btn-sm">
                                Voir présences
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            Aucune séance trouvée
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>

@endsection
