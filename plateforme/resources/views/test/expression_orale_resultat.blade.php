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
                                                            <div>{{ now()->addMonth()->format('d M Y') }}</div>
                                                        </div>
                                                    </div>

                                                    <hr class="my-2">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-8">

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
                                                        $userReponse = $reponses->firstWhere(
                                                            'expression_orale_id',
                                                            $tache->id,
                                                        );
                                                    @endphp

                                                    @if ($userReponse && $userReponse->audio_eleve)
                                                        <audio controls class="w-100">
                                                            <source src="{{ asset($userReponse->audio_eleve) }}"
                                                                type="audio/mp3">
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
                                <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary">🏠 Retour à
                                    l’accueil</a>
                            </div>
                        </section>
                    </div>

                   <div class="col-lg-3">
                        <!-- Profil -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body text-center">
                                <div class="row align-items-center">
                                    <!-- Avatar -->
                                    <div class="col-6 col-sm-5 col-md-5 col-lg-5  mb-2 mb-md-0">
                                        <div class="avatar-container text-center text-md-start">
                                            <img src="{{ auth()->user()->avatar_url ? asset(auth()->user()->avatar_url) : asset('images/user-person.png') }}"
                                                alt="Avatar" class="rounded-circle avatar-img img-fluid" width="150"
                                                height="150">
                                        </div>
                                    </div>

                                    <!-- Nom utilisateur -->
                                    <div class="col-6 col-sm-7 col-md-7 col-lg-7">
                                        <h5 class="card-title mb-0 text-center text-md-start">
                                            {{ Auth::user()->name }}
                                        </h5>
                                    </div>
                                </div>

                                @php
                                    $skills = [
                                        'Compréhension Écrite' => 'comprehension_ecrite',
                                        'Compréhension Orale' => 'comprehension_orale',
                                        'Expression Écrite' => 'expression_ecrite',
                                        'Expression Orale' => 'expression_orale',
                                    ];
                                @endphp

                                <div class="mt-4">
                                    <h6 class="text-start fw-bold mb-3">Vos niveaux par test</h6>

                                    <div class="d-flex flex-wrap gap-2">
                                        {{-- Assurez-vous que la variable passée depuis le contrôleur est bien $abonnementsPourAffichage --}}
                                        @foreach ($testTypes as $testType)
                                            @php
                                                $modalId = 'modal_' . $testType->id;
                                                $key = $testType->examen; // Assumant que 'examen' est la propriété à afficher
                                                // N'oubliez pas que $userLevels n'est pas passé dans le contrôleur modifié.
                                                // Si vous avez besoin de $userLevels, assurez-vous de le passer depuis le contrôleur.
                                                $niveaux = $userLevels[$key] ?? null;
                                            @endphp

                                            {{-- Le bouton principal --}}
                                            <button style="width: 130px; height: 50px; border-radius: 8px;" type="button"
                                                class="btn {{ $testType->paye ? 'btn-outline-primary' : 'btn-secondary' }}
                                                {{ $testType->paye ? '' : 'disabled' }}"
                                                @if ($testType->paye) data-bs-toggle="modal" data-bs-target="#{{ $modalId }}" @endif>
                                                @if (!$testType->paye)
                                                    {{-- Icône de cadenas pour les abonnements non payés --}}
                                                    <i class="fas fa-lock me-2"></i>
                                                @endif
                                                {{ strtoupper($key) }}
                                            </button>


                                            {{-- Le Modal (s'affiche seulement si l'abonnement est payé et le bouton cliquable) --}}
                                            <div class="modal fade" id="{{ $modalId }}" tabindex="-1"
                                                aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="{{ $modalId }}Label">Niveaux
                                                                pour
                                                                {{ strtoupper($key) }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Fermer"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @if ($niveaux)
                                                                <div class="row g-2">
                                                                    @foreach ($skills as $label => $champ)
                                                                        @php
                                                                            $level = $niveaux[$champ] ?? 'Non défini';
                                                                            $color = match ($level) {
                                                                                'C2', 'C1', 'B2' => 'success',
                                                                                'B1', 'A2', 'A1' => 'warning',
                                                                                default => 'secondary',
                                                                            };
                                                                        @endphp
                                                                        <div class="col-6">
                                                                            <div class="p-2 bg-light rounded">
                                                                                <small
                                                                                    class="d-block text-muted">{{ $label }}</small>
                                                                                <strong
                                                                                    class="text-{{ $color }}">{{ $level }}</strong>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @else
                                                                <p class="text-muted">Aucun niveau enregistré pour ce test.
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Fermer</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
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

    <style>
        .card:hover{
            color: black;
            background-color: transparent;
        }
        .card-body:hover{
            color: black;
            background-color: transparent;
        }
    </style>
@endsection
