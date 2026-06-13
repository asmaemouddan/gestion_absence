@extends('layouts.etudiant')

@section('page-title', 'Mes Justifications')
@section('page-subtitle', 'Liste de mes justifications')

@section('etudiant-content')

<div class="container-fluid">

    <h3 class="mb-4">Mes Justifications</h3>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Module</th>
                <th>Date</th>
                <th>Motif</th>
                <th>Statut</th>
                <th>Fichier</th>
            </tr>
        </thead>

        <tbody>
            @forelse($justifications as $justification)
                <tr>
                    <td>
                        {{ $justification->presence->seance->module->nom ?? '-' }}
                    </td>

                    <td>
                        {{ $justification->presence->seance->date ?? '-' }}
                    </td>

                    <td>
                        {{ $justification->motif }}
                    </td>

                    <td>
                        {{ $justification->status }}
                    </td>

                    <td>
                        @if($justification->fichier)
                            <a href="{{ asset('storage/'.$justification->fichier) }}"
                               target="_blank"
                               class="btn btn-sm btn-primary">
                                Voir
                            </a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Aucune justification trouvée
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection