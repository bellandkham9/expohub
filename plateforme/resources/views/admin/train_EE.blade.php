@extends('layouts.app')

@section('title', 'Générer des tâches - Expression Écrite')

@section('content')
<div class="container mt-4">

    <h2>Génération de nouvelles tâches d'Expression Écrite</h2>

    {{-- Messages succès / erreur --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Formulaire pour générer des tâches --}}
    <form action="{{ route('expression-ecrite.generer') }}" method="POST" class="mb-4">
        @csrf
        <div class="form-group mb-2">
            <label for="nb_taches">Nombre de nouvelles tâches à générer :</label>
            <input type="number" name="nb_taches" id="nb_taches" class="form-control" value="1" min="1" max="10" required>
        </div>
        <button type="submit" class="btn btn-primary">Générer</button>
    </form>

    {{-- Liste des dernières tâches --}}
    <h4>Dernières tâches générées</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Numéro</th>
                <th>Contexte</th>
                <th>Consigne</th>
                <th>Créée le</th>
            </tr>
        </thead>
        <tbody>
            @foreach($taches as $t)
            <tr>
                <td>{{ $t->id }}</td>
                <td>{{ $t->numero_tache }}</td>
                <td>{{ Str::limit($t->contexte_texte, 50) }}</td>
                <td>{{ Str::limit($t->consigne, 50) }}</td>
                <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
