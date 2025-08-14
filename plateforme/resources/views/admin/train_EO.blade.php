@extends('layouts.app')

@section('content')
<h2>Génération de nouvelles tâches d'expression orale</h2>

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('expression-orale.generer') }}" method="POST">
    @csrf
    <label>Nombre de tâches à générer :</label>
    <input type="number" name="nb_taches" min="1" max="10" value="1">
    <button type="submit" class="btn btn-primary">Générer</button>
</form>

<h3>Dernières tâches générées</h3>
<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Numéro</th>
            <th>Type</th>
            <th>Contexte</th>
            <th>Consigne</th>
            <th>Audio</th>
        </tr>
    </thead>
    <tbody>
        @foreach($taches as $t)
        <tr>
            <td>{{ $t->id }}</td>
            <td>{{ $t->numero }}</td>
            <td>{{ $t->type }}</td>
            <td>{{ $t->contexte }}</td>
            <td>{{ $t->consigne }}</td>
            <td>
                @if($t->consigne_audio)
                    <audio controls>
                        <source src="{{ asset('storage/' . $t->consigne_audio) }}" type="audio/mpeg">
                        Votre navigateur ne supporte pas l'audio.
                    </audio>
                @else
                    Non généré
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
