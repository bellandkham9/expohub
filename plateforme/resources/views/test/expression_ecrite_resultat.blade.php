@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Résultat - Expression écrite</h2>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Sujet
        </div>
        <div class="card-body">
            <p><strong>Contexte :</strong> {{ $question->contexte_texte }}</p>
            <p><strong>Consigne :</strong> {{ $question->consigne }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            Vos échanges avec l’IA
        </div>
        <div class="card-body">
            @forelse($reponses as $index => $rep)
                <div class="mb-3">
                    <p><strong>Vous ({{ $index + 1 }}):</strong> {{ $rep->reponse }}</p>
                    <p><strong>Assistant:</strong> {{ $rep->prompt }}</p>
                    <hr>
                </div>
            @empty
                <p>Aucune réponse enregistrée.</p>
            @endforelse
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            Analyse automatique
        </div>
        <div class="card-body">
            <p><strong>Nombre d’échanges :</strong> {{ count($reponses) }}</p>
            <p><strong>Score estimé :</strong> {{ $score }}/100</p>
            <p><strong>Commentaires IA :</strong> {{ $commentaire ?? 'Analyse non disponible.' }}</p>
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('expression_ecrite') }}" class="btn btn-primary">Recommencer un test</a>
        <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary">Retour à l’accueil</a>
    </div>
</div>
@endsection
