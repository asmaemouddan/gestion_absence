@extends('layouts.etudiant')

@section('page-title', 'Mes Justifications')
@section('page-subtitle', 'Liste de mes justifications')

@section('etudiant-content')

<div class="container-fluid">


    <h3 class="mb-4">Mes Justifications</h3>

    <a href="{{ route('etudiant.justifications.create') }}"
   class="btn btn-success mb-3">
    Ajouter une justification
</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Module</th>
                <th>Date</th>
                <th>Motif</th>
                <th>Statut</th>
                <th>Fichier</th>
                <th>Action</th>
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

            <td>
                <a href="{{ route('etudiant.justifications.edit', $justification->id) }}"
                   class="btn btn-warning btn-sm">
                    Modifier
                </a>

                <form action="{{ route('etudiant.justifications.destroy', $justification->id) }}"
                      method="POST"
                      style="display:inline;">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Supprimer cette justification ?')">
                        Supprimer
                    </button>
                </form>
            </td>
        </tr>

    @empty

        <tr>
            <td colspan="6" class="text-center">
                Aucune justification trouvée
            </td>
        </tr>

    @endforelse
</tbody>
    </table>

</div>

@endsection