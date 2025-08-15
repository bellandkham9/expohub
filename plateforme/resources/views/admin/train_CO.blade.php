@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Générer des questions de Compréhension Orale</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('comprehension-orale.generer') }}">
        @csrf
        <div class="mb-3">
            <label for="nb_questions" class="form-label">Nombre de questions à générer</label>
            <input type="number" name="nb_questions" id="nb_questions" class="form-control" min="1" max="5" value="1" required>
        </div>

        <button type="submit" class="btn btn-primary">Générer</button>
    </form>

    @if(isset($questions) && $questions->count() > 0)
        <h4 class="mt-5">Dernières questions générées</h4>
        <ul class="list-group">
            @foreach($questions as $q)
                <li class="list-group-item">
                    <strong>Contexte :</strong> {{ $q->contexte_texte }}<br>
                    <strong>Question :</strong> {{ Str::limit(strip_tags($q->question_audio), 50, '...') }}<br>
                    <audio controls src="{{ asset('storage/' . $q->question_audio) }}"></audio>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
