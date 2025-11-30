@extends('layouts.app')

@section('meta_title', 'Tests TCF Canada en ligne - ExpoHub Academy')
@section('meta_description', 'Entraînez-vous efficacement pour le TCF Canada grâce à nos tests interactifs de
    compréhension et d’expression.')
@section('meta_keywords', 'tcf canada, test de français, compréhension, expression, plateforme apprentissage, tef, delf,
    dalf')

@section('content')
    <div class="m-4">

        @include('client.partials.navbar-client')
        <!-- Hero Banner -->
        <div class="container my-2">
            <section id="">
                <div class="row justify-between align-items-start g-4">

                    <div class="col-lg-9">
                        <div class="m-2">
                            <!-- Main Content -->
                            <div class="container my-4">
                                <section id="result-details">
                                    <div class="row g-4">
                                        <!-- Left Column - General Info -->
                                        <div class="col-lg-4">
                                            <div class="card shadow-sm rounded-lg border-0" style="top: 20px;">
                                                <div id="btn-primary1" class="card-header btn-primary1 text-white">
                                                    <h2 class="h4 mb-0">{{ $titre }}</h2>
                                                </div>
                                                <div class="card-body">
                                                    <!-- Level Badge -->
                                                    <div class="text-center mb-4">
                                                        <span class="badge bg-danger fs-6 px-3 py-2 rounded-pill">
                                                            <i class="fas fa-chart-line me-2"></i>Niveau estimé :
                                                            {{ $niveau }}
                                                        </span>
                                                    </div>
                                                    <!-- Global Comment -->
                                                    <div class="mb-4">
                                                        <h5 class="fw-bold border-bottom pb-2">
                                                            <i class="fas fa-robot me-2 text-muted"></i>Commentaire global
                                                        </h5>
                                                        <div class="bg-light p-3 rounded border">
                                                            {!! nl2br(e($commentaire)) !!}
                                                        </div>
                                                    </div>

                                                    <!-- Task Navigation -->
                                                    <div class="task-navigation">
                                                        <h5 class="fw-bold border-bottom pb-2 mb-3">
                                                            <i class="fas fa-tasks me-2 text-muted"></i>Tâches
                                                        </h5>
                                                        <div class="list-group">
                                                            @foreach ($taches as $index => $tache)
                                                                <a href="#task-{{ $index + 1 }}"
                                                                    class="list-group-item list-group-item-action task-link @if ($loop->first) active @endif"
                                                                    data-bs-toggle="tab" data-task="{{ $index + 1 }}">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <span>Tâche {{ $index + 1 }}</span>
                                                                    </div>
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right Column - Task Details -->
                                        <div class="col-lg-8">
                                            <div class="tab-content">
                                                @foreach ($taches as $index => $tache)
                                                    <div class="tab-pane fade @if ($loop->first) show active @endif"
                                                        id="task-{{ $index + 1 }}">
                                                        <div class="card shadow-sm rounded-lg border-0 mb-4">
                                                            <div id="btn-primary1" class="card-header bg-primary1 text-white">
                                                                <p class=" mb-0"><span
                                                                        style="font-size: 18px; font-weight: bold;">Tâche
                                                                        {{ $index + 1 }}:</span>
                                                                    {{ $tache->consigne ?? 'Sans titre' }}</p>
                                                            </div>
                                                            <div class="card-body">
                                                                <!-- Task Content -->
                                                                <div class="mb-4">
                                                                    <h5 class="fw-bold border-bottom pb-2">
                                                                        <i
                                                                            class="fas fa-info-circle me-2 text-muted"></i>Contexte
                                                                    </h5>
                                                                    <div class="bg-light p-3 rounded border">
                                                                        {!! nl2br(e($tache->contexte_texte)) !!}
                                                                    </div>
                                                                </div>
                                                                <!-- Student Response -->
                                                                <div class="mb-4">
                                                                    <h5 class="fw-bold border-bottom pb-2">
                                                                        <i
                                                                            class="fas fa-user-edit me-2 text-muted"></i>Votre
                                                                        réponse
                                                                    </h5>
                                                                    <div class="bg-light p-3 rounded border"
                                                                        style="height: 20vh; overflow-y: scroll;">
                                                                        <p>{{ $reponses[$index]->reponse ?? 'Aucune réponse fournie' }}
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <!-- AI Feedback -->
                                                                @if (isset($reponses[$index]) && $reponses[$index]->commentaire)
                                                                    <div class="ai-feedback">
                                                                        <h5 class="fw-bold border-bottom pb-2">
                                                                            <i class="fas fa-robot me-2 text-muted"></i>
                                                                            Feedback IA
                                                                        </h5>
                                                                        <div class="bg-light p-3 rounded border border-info"
                                                                            style="height: 15vh; overflow-y: scroll;">
                                                                            <p>{{ $reponses[$index]->commentaire }}</p>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Navigation Button -->
                                            <div class="text-center mt-4">
                                                <a href="{{ route($route) }}" id="btn-primary1" class="btn btn-primary1 px-4 py-2">
                                                    <i class="fas fa-arrow-left me-2"></i>Retour
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
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
                                    <div class="d-flex flex-wrap justify-content-center gap-2"
                                        style="height: 100px; overflow-y: scroll;">
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
                                                class="btn btn-level d-flex flex-column
                                                    {{ $testType->paye ? 'btn-outline-primary' : 'btn-secondary disabled' }}"
                                                @if ($testType->paye) data-bs-toggle="modal" data-bs-target="#{{ $modalId }}" @endif
                                                style="min-width: 120px; max-width: 140px; white-space: normal;">

                                                <div class="d-flex align-items-center">
                                                    @if (!$testType->paye)
                                                        <i class="fas fa-lock me-1" style="font-size: 14px;"></i>
                                                    @endif

                                                    <span class="fw-bold text-truncate"
                                                        style="font-size: 10px; max-width: 100px;">
                                                        {{ strtoupper($key) }}
                                                    </span>
                                                </div>

                                                <span class="small align-self-center"
                                                    style="font-size: 8px; color: #F8B70D;">
                                                    ({{ strtoupper($key1) }})
                                                </span>
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
                                                                                'B1', 'A2', 'A1', 'A0' => 'warning',
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

                    <style>
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

                        .task-link.active {
                            background-color: #224194;
                            color: white;
                            border-color: #224194;
                        }

                        .task-link:hover:not(.active) {
                            background-color: #f8f9fa;
                        }

                        .card:hover {
                            background-color: transparent;
                            color: black;
                        }

                        #btn-primary1 {
                            border-radius: 20px;
                            background-color: #224194;
                            color: white;
                        }

                        .bg-primary1 {
                            background-color: #224194;
                        }

                        .alert-success1 {
                            background-color: #FEF8E7;
                            border: none;
                            color: black;
                        }

                        .bg-danger {
                            background-color: red;
                        }

                        .card-body:hover {
                            color: black;
                            background-color: transparent;
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

                    <script>
                        // Active le premier onglet par défaut
                        document.addEventListener('DOMContentLoaded', function() {
                            // Ajoute un effet smooth lors du changement d'onglet
                            const taskLinks = document.querySelectorAll('.task-link');
                            taskLinks.forEach(link => {
                                link.addEventListener('click', function() {
                                    taskLinks.forEach(l => l.classList.remove('active'));
                                    this.classList.add('active');
                                });
                            });
                        });
                    </script>
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
                <b>A1 (1-5 points)</b> : Niveau élémentaire débutant, compréhension très limitée, capacité à utiliser des phrases simples.<br><br>
                <b>A2 (1-15 points)</b> : Niveau élémentaire avancé, peut comprendre et utiliser des phrases fréquentes sur des sujets familiers.<br><br>
                <b>B1 (1-20 points)</b> : Niveau de base, utilisateur indépendant débutant, capable de communiquer dans des situations courantes.<br><br>
                <b>B2 (1-25 points)</b> : Niveau intermédiaire, peut discuter de sujets variés et comprendre des textes plus complexes.<br><br>
                <b>C1 (1-33 points)</b> : Niveau avancé, utilisateur expérimenté autonome, bonne compréhension des textes et dialogues complexes, capacité d'expression détaillée.<br><br>
                <b>C2 (1-39 points)</b> : Niveau très avancé, maîtrise proche du bilinguisme, capable de comprendre et produire des textes et discours très complexes.
            </div>
        `,
                icon: 'info',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6',
            });
        }
    </script>


@endsection
