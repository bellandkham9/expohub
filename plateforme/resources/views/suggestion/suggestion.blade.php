@extends('layouts.app')

@section('content')
    <div class="m-4">

       @include('client.partials.navbar-client')
   
        <!-- Hero Banner -->
        <div class="container my-4">

            <div class="container py-4">
                <!-- Search bar -->
                <div class="mb-4 position-relative">
                    <input type="text" class="form-control search-bar" placeholder="🔍 Chercher...">
                </div>

                <!-- Navigation tabs -->
                <ul class="nav nav-pills mb-3">
                    <li class="nav-item"><a class="nav-link active" href="#">Touts</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Articles</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Vidéos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Exercices</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Recommandations</a></li>
                </ul>
                <form method="POST" action="{{ route('suggestions.generate') }}">
                    @csrf
                    <button type="submit">Obtenir des suggestions</button>
                </form>


                <!-- Section title -->
                <h6 class="section-title">Astuces écrites</h6>

                <div class="overflow-y-auto" style="max-height: 400px;">

  @php
    // Assurer que $LesSuggestion existe
    $LesSuggestion = $LesSuggestion ?? collect();
@endphp

<div class="container mt-4">
    @if($LesSuggestion->isEmpty())
        <p class="text-muted">Aucune suggestion pour le moment.</p>
    @else
        <div class="row">
            @foreach($LesSuggestion as $index => $suggestion)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">💡 {{ ucfirst($suggestion->type) }}</h5>
                            <p class="card-text flex-grow-1">{{ $suggestion->content }}</p>
                            <small class="text-muted">
                                {{ $suggestion->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Fermer et rouvrir une row après chaque 3 cartes --}}
                @if(($index + 1) % 3 == 0 && !$loop->last)
                    </div><div class="row">
                @endif
            @endforeach
        </div>
    @endif
</div>
            </div>

        </div>
    </div>
@endsection
