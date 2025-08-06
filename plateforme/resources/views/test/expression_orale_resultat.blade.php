@extends('layouts.app')

@section('content')
    <div class="m-4">
        @include('client.partials.navbar-client')
        <!-- Hero Banner -->
        <div class="container my-4">
            <section id="test-results">
                <div class="row justify-content-between align-items-start g-4">
                    <div class="col-lg-9">
                        <!-- Section Résultats du Test -->
                        <section class="container mb-2">
                            <div class="mt-3">
                                <div class="" style="max-height: 70vh; overflow-y: auto;">
                                    <ul class="list-unstyled">
                                        <li>
                                            <div class="container my-3">
                                                <div class="border rounded shadow-sm p-3">
                                                    <div class="d-flex flex-column flex-md-row justify-content-between">
                                                        <div>
                                                            <h6 class="fw-bold mb-1">{{ $titre }}</h6>
                                                        </div>
                                                        <div class="text-md-end text-muted small">
                                                            <div><strong>60 min</strong></div>
                                                            <div>{{ now()->format('d M Y') }}</div>
                                                        </div>
                                                    </div>

                                                    <hr class="my-2">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-8">
                                                            <div class="row g-2 mb-3">
                                                                <div class="col-12 col-md-6">
                                                                    <strong>Niveau :</strong> {{ $niveau }}
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <strong>Score total :</strong> {{ $note }} / 600
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 text-md-end">
                                                            <a href="{{ route($route) }}" class="btn"
                                                                style="background-color: #224194; color: white;"
                                                                onclick="event.preventDefault(); 
                if(confirm('Êtes-vous sûr de vouloir recommencer le test ?')) { 
                    document.getElementById('reset-form').submit(); 
                }">
                                                                Refaire le test
                                                            </a>

                                                            <form id="reset-form"
                                                                action="{{ route('expression_orale.reinitialiser') }}"
                                                                method="POST" class="d-none">
                                                                @csrf
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </section>

                        <!-- Section Détails des Réponses -->
                        <section class="container mb-5 px-lg-5">


                            <!-- Section Tâches du Test -->
                            <h5 class="fw-bold mt-5 mb-4">Tâches du test</h5>

                            @isset($taches)
                                @foreach ($taches as $tache)
                                    <div class="row g-3 justify-content-between mb-4">
                                        <div class="col-12">
                                            <p class="fw-bold" style="color: #224194">
                                                <span class="me-2">Tâche {{ $tache->numero_tache }}</span>
                                            </p>
                                        </div>

                                        <div class="col-12 col-lg-6">
                                            <div class="card h-100 border-0 shadow-sm">
                                                <div class="card-body p-2" style="height: 30vh; overflow-y: scroll;">
                                                    <h6 class="card-title fw-bold">Consigne</h6>
                                                    <p class="card-text">{{ $tache->consigne }}</p>
                                                    <hr>
                                                    <h6 class="card-title fw-bold">Contexte</h6>
                                                    <p class="card-text">{{ $tache->contexte }}</p>
                                                </div>
                                            </div>
                                        </div>

                                       <div class="col-12 col-lg-6 mb-4">
                                            <div class="card h-100 shadow-sm border-0 rounded-3">
                                                <div class="card-body">
                                                    <h5 class="card-title fw-semibold text-success mb-3">
                                                        Votre enregistrement
                                                    </h5>

                                                    @php
                                                        $userReponse = $reponses->firstWhere('expression_orale_id', $tache->id);
                                                    @endphp

                                                    @if ($userReponse && $userReponse->audio_eleve)
                                                        <audio controls class="w-100">
                                                            <source src="{{ asset($userReponse->audio_eleve) }}" type="audio/mp3">
                                                            Votre navigateur ne prend pas en charge la lecture audio.
                                                        </audio>

                                                        <button class="btn btn-outline-primary btn-sm mt-2"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#responseModal{{ $tache->id }}">
                                                            Voir les détails
                                                        </button>
                                                    @else
                                                        <p class="text-muted fst-italic">Aucune réponse enregistrée</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-warning">Aucune tâche disponible pour afficher les détails.</div>
                            @endisset
                       <div class="justify-items-center mt-4">
                        <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary">🏠 Retour à l’accueil</a>
                       </div>
                        </section>
                    </div>

                    <!-- Sidebar Profil -->
                    <div class="col-lg-3">
                        <div class="card text-center p-3 rounded-4 "
                            style="border: none; box-shadow: 2px 2px 2px 2px gainsboro; background-color: #fef8e7;">
                            <div class="card-body">
                                <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                                    <img src="{{ asset('images/beautiful-woman.png') }}" alt="Profil"
                                        class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                    <h6 class="fw-bold mb-0">Emmanuelle</h6>
                                </div>

                                <hr class="my-2">
                                <h6 class="fw-semibold text-start mb-3">Niveaux de langue</h6>

                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="p-2 rounded shadow-sm bg-white">
                                            <small class="fw-semibold">TCF CANADA</small>
                                            <div class="badge bg-primary mt-1">{{ $niveau }}</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-2 rounded shadow-sm bg-white">
                                            <small class="fw-semibold">TCF QUEBEC</small>
                                            <div class="badge bg-secondary mt-1">A1</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-2 rounded shadow-sm bg-white">
                                            <small class="fw-semibold">TEF</small>
                                            <div class="badge bg-info mt-1">A1</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-2 rounded shadow-sm bg-white">
                                            <small class="fw-semibold">DELF</small>
                                            <div class="badge bg-success mt-1">A1</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="p-2 rounded shadow-sm bg-white">
                                            <small class="fw-semibold">DALF</small>
                                            <div class="badge bg-warning mt-1">A1</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Modals pour les réponses complètes -->
    @foreach ($reponses as $reponse)
        @if ($reponse->question)
            <div class="modal fade" id="responseModal{{ $reponse->question->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Réponse complète - Tâche {{ $reponse->question->numero_tache }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <h6>Votre réponse :</h6>
                                <p>{{ $reponse->reponse }}</p>
                            </div>
                            <div class="alert alert-light">
                                <h6>Commentaire :</h6>
                                <p>{{ $reponse->commentaire }}</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="badge bg-primary rounded-pill">Score : {{ $reponse->score }} / 200</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

@endsection
