@extends('layouts.app')

@section('content')
    <div class="m-4">

        @include('client.partials.navbar-client')

        <!-- Hero Banner -->
        <div class="container my-4">

            <div class="container py-4">
                <!-- Search bar -->
                <div class="mb-4 position-relative">
                    <input type="text" id="searchInput" class="form-control search-bar" placeholder="🔍 Chercher...">
                </div>

                <!-- Navigation tabs -->
                <div class="row align-items-center">
                    <!-- Navigation -->
                    <div class="col-12 col-md-8 col-lg-9 mb-3 mb-md-0">
                        <div class="d-flex flex-nowrap overflow-auto pb-2">
                            <ul class="nav nav-pills flex-nowrap">
                                <li class="nav-item">
                                    <a class="nav-link active px-3 py-2 me-2" href="#">
                                        <i class="fas fa-layer-group me-1 d-none d-sm-inline"></i>Tous
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-3 py-2 me-2" href="#">
                                        <i class="fas fa-newspaper me-1 d-none d-sm-inline"></i>Articles
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-3 py-2 me-2" href="#">
                                        <i class="fas fa-video me-1 d-none d-sm-inline"></i>Vidéos
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-3 py-2 me-2" href="#">
                                        <i class="fas fa-dumbbell me-1 d-none d-sm-inline"></i>Exercices
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-3 py-2" href="#">
                                        <i class="fas fa-star me-1 d-none d-sm-inline"></i>Recommandations
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Bouton Suggestions -->
                    <div class="col-12 col-md-4 col-lg-3">
                        <form method="POST" action="{{ route('suggestions.generate') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary1 w-100">
                                <i class="fas fa-magic me-1 d-none d-sm-inline"></i>
                                <span class="d-none d-md-inline">Obtenir des</span> suggestions
                            </button>
                        </form>
                    </div>
                </div>


                <!-- Section title -->
                <h6 class="section-title mt-4">Astuces écrites</h6>

                <div class="overflow-y-auto" style="max-height: 400px;">
                    @php
                        $LesSuggestion = $LesSuggestion ?? collect();
                    @endphp

                    <div class="container mt-4" id="suggestionsContainer">
                        @if ($LesSuggestion->isEmpty())
                            <p class="text-muted">Aucune suggestion pour le moment.</p>
                        @else
                            <div class="row">
                                @foreach ($LesSuggestion as $index => $suggestion)
                                    <div class="col-md-4 mb-4 suggestion-card">
                                        <div class="card shadow-sm h-100" style=" border: none;">
                                            <div class="card-body d-flex flex-column"
                                                style="background-color: #FEF8E7; color: black; border-radius: 20px;">
                                                <h5 class="card-title">💡 {{ ucfirst($suggestion->type) }}</h5>
                                                <p class="card-text flex-grow-1">{{ $suggestion->content }}</p>
                                                <small class="text-muted">
                                                    {{ $suggestion->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    @if (($index + 1) % 3 == 0 && !$loop->last)
                            </div>
                            <div class="row">
                        @endif
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
    </div>

    <style>
        .btn-primary1 {
            background-color: #224194;
            color: white;
        }

        .btn-primary1:hover {
            background-color: #224194;
            color: white;
        }
    </style>
    {{-- JS pour filtrer en direct --}}
    <script>
        document.getElementById("searchInput").addEventListener("keyup", function() {
            let searchValue = this.value.toLowerCase();
            let cards = document.querySelectorAll("#suggestionsContainer .suggestion-card");

            cards.forEach(card => {
                let text = card.innerText.toLowerCase();
                if (text.includes(searchValue)) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        });
    </script>
@endsection
