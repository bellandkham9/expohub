@extends('layouts.app')

@section('content')
    <div class="m-4">

        @include('client.partials.navbar-client')

        <div class="container my-4">
            <section id="">
                <div class="row justify-between align-items-start g-4">
                    <div class="col-lg-9">
                        <!-- Résumé du test -->
                        <section class="container mb-5">
                            <div class="mt-3">
                                <div style="max-height: 70vh; overflow-y: auto;">
                                    <ul>
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
                                                    <div class="row">
                                                        <div class="col-md-9">

                                                        </div>
                                                        <div class="col-md-3">
                                                            <a href="{{ route($route) }}" class="btn"
                                                                style="background-color:  #224194; color: white;">
                                                                Refaire le test
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </section>

                        <!-- Résultats détaillés -->
                        <section class="container mb-5" style="padding-left: 45px; padding-right: 45px;">
                            
                            @foreach ($reponses as $reponse)
                                <div class="row g-4 justify-content-center align-items-center mt-1 mb-3">
                                    <!-- Colonne gauche -->
                                    <div class="col-12 col-md-10 col-lg-6" style="height: 20vh">
                                        <div class="result-card astuce p-4 h-100 text-justify rounded shadow-sm">
                                            @if (Str::endsWith($reponse->contexte_texte, ['.jpg', '.jpeg', '.png', '.gif', '.webp']))
                                                <img src="{{ asset('storage/' . $reponse->contexte_texte) }}"
                                                    alt="situation" class="img-fluid rounded"
                                                    style="max-height: 100%; object-fit: contain;">
                                            @else
                                                <p class="text-justify">{{ $reponse->contexte_texte }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Colonne droite -->
                                    <div class="col-12 col-md-10 col-lg-6" style="height: 20vh">
                                        <div class="p-2 text-justify rounded">
                                            <div class="row justify-between align-items-center mb-2">
                                                <div class="col-12">
                                                    <p class="fw-bold">Question
                                                        {{ $reponse->numero ?? $reponse->question_id }}:</p>

                                                    @if (Str::endsWith($reponse->question_audio, '.mp3') || Str::endsWith($reponse->question_audio, '.wav'))
                                                        <audio controls class="mt-2 w-100">
                                                            <source src="{{ asset('storage/' . $reponse->question_audio) }}"
                                                                type="audio/mpeg">
                                                            Votre navigateur ne supporte pas l'élément audio.
                                                        </audio>
                                                    @endif
                                                </div>
                                            </div>
                                            <p>
                                                <span style="color: {{ $reponse->is_correct ? '#0DF840' : '#FF3B30' }}"
                                                    class="fw-bold">Votre réponse :</span>
                                                {{ $reponse->reponse_utilisateur }}<br>
                                                <span class="fw-bold" style="color: #0DF840">Bonne réponse :</span>
                                                {{ $reponse->bonne_reponse }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </section>
                    </div>

                    <div class="col-lg-3">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body text-center">
                                <div class="d-flex flex-column align-items-center mb-3">
                                    <div class="avatar-container mb-2">
                                        <img src="{{ auth()->user()->avatar_url ? asset(auth()->user()->avatar_url) : asset('images/user-person.png') }}"
                                             alt="Avatar" class="rounded-circle avatar-img img-fluid">
                                    </div>
                                    <h5 class="card-title mb-0">{{ Auth::user()->name }}</h5>
                                </div>
                                <div class="mt-4">
                                    <h6 class="fw-bold mb-3">Vos niveaux par test</h6>
                                    <button onclick="showNiveauxInfo()" class="btn btn-info btn-sm mb-3">
                                        ℹ️ Infos niveaux
                                    </button>
                                    <div class="d-flex flex-wrap justify-content-center gap-2">
                                        @foreach ($testTypes as $testType)
                                            @php
                                                $modalId = 'modal_' . $testType->id;
                                                $key = $testType->examen;
                                                $niveaux = $userLevels[$key] ?? null;
                                                $skills = [
                                                    'Compréhension Écrite' => 'comprehension_ecrite',
                                                    'Compréhension Orale' => 'comprehension_orale',
                                                    'Expression Écrite' => 'expression_ecrite',
                                                    'Expression Orale' => 'expression_orale',
                                                ];
                                            @endphp
                                            <button type="button" class="btn btn-level {{ $testType->paye ? 'btn-outline-primary' : 'btn-secondary' }} {{ $testType->paye ? '' : 'disabled' }}"
                                                    @if($testType->paye) data-bs-toggle="modal" data-bs-target="#{{ $modalId }}" @endif>
                                                @if(!$testType->paye)
                                                <i class="fas fa-lock me-1"></i>
                                                @endif
                                                {{ strtoupper($key) }}
                                            </button>
                                            <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Niveaux pour {{ strtoupper($key) }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @if($niveaux)
                                                            <div class="row g-2">
                                                                @foreach($skills as $label => $champ)
                                                                @php
                                                                $level = $niveaux[$champ] ?? 'Non défini';
                                                                $color = match($level) {
                                                                    'C2', 'C1', 'B2' => 'success',
                                                                    'B1', 'A2', 'A1' => 'warning',
                                                                    default => 'secondary'
                                                                };
                                                                @endphp
                                                                <div class="col-6">
                                                                    <div class="p-2 bg-light rounded">
                                                                        <small class="d-block text-muted">{{ $label }}</small>
                                                                        <strong class="text-{{ $color }}">{{ $level }}</strong>
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                            @else
                                                            <p class="text-muted">Aucun niveau enregistré pour ce test.</p>
                                                            @endif
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


     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function showNiveauxInfo() {
            Swal.fire({
                title: 'Information sur les niveaux',
                html: `
                    <div style="text-align:left;">
                        <b>A0 (0-99 points)</b> : Débutant, reconnaissance de quelques mots.<br><br>
                        <b>A1 (100-199 points)</b> : Utilisateur élémentaire débutant, phrases simples liées à la vie quotidienne.<br><br>
                        <b>A2 (200-299 points)</b> : Utilisateur élémentaire intermédiaire, capacité à parler de l'environnement quotidien.<br><br>
                        <b>B1 (300-399 points)</b> : Utilisateur indépendant, autonome lors d'un voyage ou au travail.<br><br>
                        <b>B2 (400-499 points)</b> : Utilisateur indépendant avancé, conversation spontanée sur divers sujets.<br><br>
                        <b>C1 (500-599 points)</b> : Utilisateur expérimenté autonome, bonne compréhension des textes et dialogues complexes.<br><br>
                        <b>C2 (600-699 points)</b> : Utilisateur expérimenté maîtrise, proche du bilinguisme.
                    </div>
                `,
                icon: 'info',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6',
            });
        }
    </script>

<style>
            /* Styles pour la card de profil */
    .avatar-container {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid #e9ecef;
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

     .btn-level {
            width: 120px;
            height: 45px;
            border-radius: 8px;
            font-size: 0.85rem;
        }

        @media (max-width: 991.98px) {
            .col-lg-3 .card-body .row {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .col-lg-3 .card-body .row .col-6 {
                width: 100%;
                text-align: center;
            }

            .col-lg-3 .card-body .row .col-6:first-child {
                margin-bottom: 1rem;
            }
        }
</style>
@endsection
