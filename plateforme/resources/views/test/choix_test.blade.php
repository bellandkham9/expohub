@extends('layouts.app')

@section('content')
    <div class="m-4">
        @include('client.partials.navbar-client')

        <div class="container my-4">
            <section>
                <div class="row justify-between align-items-start g-4">

                    <div class="col-lg-9">
                        <section class="hero-section mb-4">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-10 text-start">
                                        <h2>Préparez-vous efficacement aux tests officiels de français</h2>
                                        <p>
                                            Choisissez l’un des tests disponibles ci-dessous pour évaluer vos compétences
                                            linguistiques dans un cadre officiel. Chaque test est adapté aux exigences des
                                            examens comme le TCF, TEF, DELF et DALF.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="container mb-5">
                            <div class="row g-4 justify-content-center">
                                @foreach ($testTypes as $testType)
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="test-card text-center h-100 p-4">
                                            <h3 class="test-title h5 mb-3">{{ strtoupper($testType->examen) }} <span
                                                    style="color: #F8B70D; font-size: 12px;">({{ strtoupper($testType->nom_du_plan) }})</span>
                                            </h3>
                                            <p class="mb-4 text-muted">
                                                {{ $testType->description ?? 'Test de langue officiel pour tous niveaux.' }}
                                            </p>

                                            <button
                                                class="btn {{ $testType->paye ? 'btn-primary' : 'btn-secondary' }} 
                                                     {{ $testType->paye ? '' : 'disabled' }}"
                                                @if ($testType->paye) data-bs-toggle="modal"
                                                     data-type="{{ $testType->nom }}"
                                                     data-id="{{ $testType->id }}"
                                                     data-bs-target="#testModal" @endif>
                                                @if (!$testType->paye)
                                                    <i class="fas fa-lock me-2"></i>
                                                @endif
                                                Commencer
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </section>
                        <div class="modal fade" id="testModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Choisissez une compétence</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <a href="{{ route('test.comprehension_ecrite') }}"
                                                    class="card h-100 text-decoration-none text-center p-3 border-0 shadow-sm"
                                                    style="background-color: #F8B70D;">
                                                    <img src="{{ asset('images/lecture.png') }}" width="40"
                                                        class="mb-2 mx-auto">
                                                    <h6 class="mb-0">Compréhension Écrite</h6>
                                                </a>
                                            </div>
                                            <div class="col-6">
                                                <a href="{{ route('test.comprehension_orale') }}"
                                                    class="card h-100 text-decoration-none text-center p-3 border-0 shadow-sm"
                                                    style="background-color: #FF3B30;">
                                                    <img src="{{ asset('images/ecoute.png') }}" width="40"
                                                        class="mb-2 mx-auto">
                                                    <h6 class="mb-0">Compréhension Orale</h6>
                                                </a>
                                            </div>
                                            <div class="col-6">
                                                <a href="{{ route('test.expression_ecrite') }}"
                                                    class="card h-100 text-decoration-none text-center p-3 border-0 shadow-sm"
                                                    style="background-color: #224194;">
                                                    <img src="{{ asset('images/ecrite.png') }}" width="40"
                                                        class="mb-2 mx-auto">
                                                    <h6 class="mb-0">Expression Écrite</h6>
                                                </a>
                                            </div>
                                            <div class="col-6">
                                                <a href="{{ route('test.expression_orale') }}"
                                                    class="card h-100 text-decoration-none text-center p-3 border-0 shadow-sm"
                                                    style="background-color: #249DB8;">
                                                    <img src="{{ asset('images/orale.png') }}" width="40"
                                                        class="mb-2 mx-auto">
                                                    <h6 class="mb-0">Expression Orale</h6>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section du profil avec les niveaux (corrigée) --}}
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
                                                $key = $testType->examen . '_' . $testType->nom_du_plan;
                                                $key1 = $testType->examen;
                                                $key2 = $testType->nom_du_plan;
                                                $niveaux = $userLevels[$key] ?? null;

                                                $skills = [
                                                    'Compréhension Écrite' => 'comprehension_ecrite',
                                                    'Compréhension Orale' => 'comprehension_orale',
                                                    'Expression Écrite' => 'expression_ecrite',
                                                    'Expression Orale' => 'expression_orale',
                                                ];
                                            @endphp
                                            <button type="button"
                                                class="btn btn-level {{ $testType->paye ? 'btn-outline-primary' : 'btn-secondary' }} {{ $testType->paye ? '' : 'disabled' }}"
                                                @if ($testType->paye) data-bs-toggle="modal" data-bs-target="#{{ $modalId }}" @endif>
                                                @if (!$testType->paye)
                                                    <i class="fas fa-lock me-1"></i>
                                                @endif
                                                {{ strtoupper($key1) }}
                                                <p style="font-size: 10px; color: #F8B70D;">({{ strtoupper($key2) }})</p>
                                            </button>
                                            <div class="modal fade" id="{{ $modalId }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Niveaux pour {{ strtoupper($key) }}
                                                            </h5>
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
                                                                                'B1', 'A2', 'A1','A0' => 'warning',
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
    @include('start.chatbot')

    <style>
        .btn-primary {
            border-radius: 20px;
            background-color: #224194;
            color: white;
        }

        .btn-secondary {
            border-radius: 20px;
            color: white;
        }

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
@endsection
