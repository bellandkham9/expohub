@extends('layouts.app')

@section('content')
    <div class="m-4">

        @include('client.partials.navbar-client')
        <!-- Hero Banner -->
        <div class="container my-4">
            <section id="">
                <div class="row justify-between align-items-start g-4">

                    <div class="col-lg-9">
                        <div class="m-4">
                            <!-- Main Content -->
                            <div class="container my-4">
                                <section id="result-details">
                                    <div class="row g-4">
                                        <!-- Left Column - General Info -->
                                        <div class="col-lg-4">
                                            <div class="card shadow-sm rounded-lg border-0 sticky-top" style="top: 20px;">
                                                <div class="card-header btn-primary1 text-white">
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

                                                    <!-- Final Score -->
                                                    <div class="alert alert-success1 text-center fs-4 mb-4">
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            <i class="fas fa-star me-3"></i>
                                                            <div>
                                                                <strong>Note finale :</strong> {{ $note }}/3
                                                            </div>
                                                        </div>
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
                                                                        @if (isset($reponses[$index]->score))
                                                                            <span class="badge bg-{{ isset($reponses[$index]) && $reponses[$index]->score >= 0.5 ? 'success' : 'warning' }}">
                                                                                {{ $reponses[$index]->score ?? 0 }}/1
                                                                            </span>

                                                                        @endif
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
                                                            <div class="card-header bg-primary1 text-white">
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
                                                                        <i class="fas fa-user-edit me-2 text-muted"></i>Votre réponse
                                                                    </h5>
                                                                    <div class="bg-light p-3 rounded border" style="height: 20vh; overflow-y: scroll;">
                                                                        <p>{{ $reponses[$index]->reponse ?? 'Aucune réponse fournie' }}</p>
                                                                    </div>
                                                                </div>

                                                                <!-- AI Feedback -->
                                                                @if(isset($reponses[$index]) && $reponses[$index]->commentaire)
                                                                    <div class="ai-feedback">
                                                                        <h5 class="fw-bold border-bottom pb-2">
                                                                            <i class="fas fa-robot me-2 text-muted"></i>
                                                                            Feedback IA
                                                                        </h5>
                                                                        <div class="bg-light p-3 rounded border border-info" style="height: 15vh; overflow-y: scroll;">
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
                                                <a href="{{ route($route) }}" class="btn btn-primary1 px-4 py-2">
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
                        <!-- Profil -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body text-center">
                                <div class="row align-items-center">
                                    <!-- Avatar -->
                                    <div class="col-6">
                                        <div class="avatar-container">
                                            <img src="{{ auth()->user()->avatar_url ? asset(auth()->user()->avatar_url) : asset('images/user-person.png') }}"
                                                alt="Avatar" class="rounded-circle avatar-img img-fluid" width="80"
                                                height="80">
                                        </div>
                                    </div>

                                    <!-- Nom utilisateur -->
                                    <div class="col-6">
                                        <h5 class="card-title mb-0">{{ Auth::user()->name }}</h5>
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
                                    <h6 class="fw-bold mb-3">Vos niveaux par test</h6>

                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($testTypes as $testType)
                                            @php
                                                $modalId = 'modal_' . $testType->id;
                                                $key = $testType->examen;
                                                $niveaux = $userLevels[$key] ?? null;
                                            @endphp

                                            <button type="button"
                                                class="btn btn-level {{ $testType->paye ? 'btn-outline-primary' : 'btn-secondary' }} {{ $testType->paye ? '' : 'disabled' }}"
                                                @if ($testType->paye) data-bs-toggle="modal" data-bs-target="#{{ $modalId }}" @endif>
                                                @if (!$testType->paye)
                                                    <i class="fas fa-lock me-1"></i>
                                                @endif
                                                {{ strtoupper($key) }}
                                            </button>

                                            <!-- Modal -->
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

                        .btn-primary1 {
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

                        <style>.card-body:hover {
                            color: black;
                            background-color: transparent;
                        }
                    </style>
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
@endsection
