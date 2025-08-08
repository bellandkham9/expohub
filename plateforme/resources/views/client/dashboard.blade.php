@extends('layouts.app')

@section('content')
    <div class="m-4">
        @if (auth()->check())
            @include('client.partials.navbar-client')
        @else
            @include('client.partials.navbar')
        @endif

        <!-- Hero Banner -->
        <div class="container my-4">
            <div class="row justify-between align-items-start g-4">
                <!-- Colonne principale -->
                <div class="col-lg-9">
                    <!-- Hero Section -->
                    <section class="hero-section mb-2">
                        <div class="bg-light p-4 rounded">
                            <h2 class="fw-bold mb-3">Votre tableau de bord linguistique</h2>
                            <p class="lead">
                                Suivez votre progression et préparez-vous efficacement aux tests officiels de français.
                            </p>

                            <div class="col-lg-9">

                                <!-- Section Tests Disponibles -->
                                <section class="container mb-5">

                                    <!-- Modal : Choix discipline -->
                                    <div class="modal fade" id="choisirDisciplineModal" tabindex="-1"
                                        aria-labelledby="choisirDisciplineLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content p-4 text-center">
                                                <div class="modal-header border-0">
                                                    <h5 class="modal-title w-100" id="choisirDisciplineLabel">
                                                        Choisissez la discipline</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Fermer"></button>
                                                </div>

                                                <div class="row g-4 justify-content-center mr-6">

                                                    <!-- Carte TCF QUEBEC 1 -->
                                                    <div class="btn col-12 col-md-6 col-lg-6"
                                                        onclick="window.location.href='{{ route('test.comprehension_ecrite') }}'">
                                                        <div class="test-card text-center h-100 p-4"
                                                            style="background-color: #F8B70D;">
                                                            <div class="test-icon mb-3 mt-4">
                                                                <img src="{{ asset('images/lecture.png') }}" alt="Logo"
                                                                    style="height: 40px;">
                                                            </div>
                                                            <h3 style="color: white;" class="test-title h5 mb-3">
                                                                Compréhension Écrite
                                                            </h3>
                                                        </div>
                                                    </div>


                                                    <!-- Carte TCF CANADA 2 -->
                                                    <div class="btn col-12 col-md-6 col-lg-6"
                                                        onclick="window.location.href='{{ route('test.comprehension_orale') }}'">
                                                        <div class="test-card text-center h-100 p-4"
                                                            style="background-color: #FF3B30;">
                                                            <div class="test-icon mb-3">
                                                                <img src="{{ asset('images/ecoute.png') }}" alt="Logo"
                                                                    style="height: 40px;">
                                                            </div>
                                                            <h3 style="color: white" class="test-title h5 mb-3">
                                                                Compréhension Orale
                                                            </h3>

                                                        </div>
                                                    </div>

                                                    <!-- Carte TCF QUEBEC 2 -->
                                                    <div class="btn col-12 col-md-6 col-lg-6"
                                                        onclick="window.location.href='{{ route('test.expression_orale') }}'">
                                                        <div class="test-card text-center h-100 p-4"
                                                            style="background-color: #224194;">
                                                            <div class="test-icon mb-3">
                                                                <img src="{{ asset('images/orale.png') }}" alt="Logo"
                                                                    style="height: 40px;">
                                                            </div>
                                                            <h3 style="color: white" class="test-title h5 mb-3">Expression
                                                                Orale</h3>

                                                        </div>
                                                    </div>

                                                    <!-- Carte TCF CANADA 3 -->
                                                    <div class="btn col-12 col-md-6 col-lg-6"
                                                        onclick="window.location.href='{{ route('expression_ecrite') }}'">
                                                        <div class="test-card text-center h-100 p-4"
                                                            style="background-color: #249DB8;">
                                                            <div class="test-icon mb-3">
                                                                <img src="{{ asset('images/ecrite.png') }}" alt="Logo"
                                                                    style="height: 40px;">
                                                            </div>
                                                            <h3 style="color: white" class="test-title h5 mb-3"> Expression
                                                                Ecrite
                                                            </h3>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                </section>

                                <!-- Tests disponibles -->
                                <!-- Section Tests Disponibles -->
                                <section class="container mb-1" style="height: 30vh; width: 100vh; overflow-y: scroll;">
                                    <div class="row g-4 justify-content-center">
                                        @foreach ($testTypes as $testType)
                                            <div class="col-12 col-md-6 col-lg-6">
                                                <div class="test-card text-center h-100 p-4">
                                                    <div class="test-icon mb-3">
                                                        <i class="fas fa-certificate fa-3x text-primary"></i>
                                                    </div>
                                                    <h3 class="test-title h5 mb-3">{{ strtoupper($testType->nom) }}</h3>
                                                    <p class="mb-4 text-muted">
                                                        {{ $type->description ?? 'Test de langue officiel pour tous niveaux.' }}
                                                    </p>
                                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                                        data-type="{{ $testType->nom }}" data-id="{{ $testType->id }}"
                                                        data-bs-target="#testModal">
                                                        Commencer
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </section>
                                <!-- Historique des tests -->
                                <section class="mb-5 mt-4" style="width: 100vh;">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h3 class="fw-bold mb-0">Vos derniers tests</h3>
                                        <a href="{{ route('client.history') }}" class="btn btn-sm btn-link">Voir tout</a>
                                    </div>

                                    <div class="list-group">
                                        @foreach ($completedTests as $test)
                                            <div class="list-group-item border-0 mb-3 rounded"
                                                style="box-shadow: 2px 2px 2px 2px gainsboro">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h5 class="fw-bold mb-1">{{ $test['test_type'] }} -
                                                            {{ $test['skill'] }}</h5>
                                                        <small class="text-muted">
                                                            {{ \Carbon\Carbon::parse($test['date'])->format('d/m/Y') }}
                                                        </small>

                                                    </div>
                                                    <span
                                                        class="badge bg-{{ $test['level'] == 'B2' ? 'success' : 'warning' }}">
                                                        Niveau {{ $test['level'] ?? '—' }}
                                                    </span>

                                                </div>

                                                <div class="mt-3">
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <span>Score: {{ $test['score'] }}/{{ $test['max_score'] }}</span>
                                                        <span>{{ $test['correct_answers'] }}/{{ $test['total_questions'] }}
                                                            bonnes
                                                            réponses</span>
                                                    </div>
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: {{ $test['max_score'] > 0 ? ($test['score'] / $test['max_score']) * 100 : 0 }}%">
                                                    </div>

                                                </div>

                                                <div class="d-flex justify-content-end gap-2 mt-3">
                                                    <a href="{{ route($test['details_route'], ['id' => $test['related_id'] ?? $test['id']]) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        Détails
                                                    </a>

                                                    <div class="text-md-end">
                                                        <a href="{{ route($test['refaire_route']) }}" class="btn"
                                                            style="background-color: #224194; color: white;"
                                                            onclick="event.preventDefault(); 
                                                                    if(confirm('Êtes-vous sûr de vouloir recommencer le test ?')) { 
                                                                        document.getElementById('reset-form').submit(); 
                                                                    }">
                                                            Refaire le test
                                                        </a>

                                                        <form id="reset-form"
                                                            action="{{ route($test['refaire_route']) }}" method="POST"
                                                            class="d-none">
                                                            @csrf
                                                        </form>
                                                    </div>




                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                </section>

                            </div>

                            <div class="text-start mt-3">
                                <a href="#" class="btn-show-more" style="color: black">Afficher plus de stratégies
                                    <i class="fas fa-chevron-down"></i></a>
                            </div>
                    </section>

                </div>
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <!-- Profil -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body text-center">
                            <img src="{{ auth()->user()->avatar_url ? asset(auth()->user()->avatar_url) : asset('images/user-person.png') }}" alt="Avatar" class="rounded-circle" style="width: 35px; height: 35px; object-fit: cover;">
                            <h5 class="card-title mb-1">{{ Auth::user()->name }}</h5>

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
                                    @foreach ($testTypes as $testType)
                                        @php
                                            $modalId = 'modal_' . $testType->id;
                                            $key = $testType->nom;
                                            $niveaux = $userLevels[$key] ?? null;
                                        @endphp

                                        <!-- Bouton -->
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#{{ $modalId }}">
                                            {{ strtoupper($key) }}
                                        </button>

                                        <!-- Modal -->
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
                                                            <p class="text-muted">Aucun niveau enregistré pour ce test.</p>
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

            <!-- Modal Choix Test -->
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
                                        <img src="{{ asset('images/ecoute.png') }}" width="40" class="mb-2 mx-auto">
                                        <h6 class="mb-0">Compréhension Orale</h6>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('test.expression_ecrite') }}"
                                        class="card h-100 text-decoration-none text-center p-3 border-0 shadow-sm"
                                        style="background-color: #224194;">
                                        <img src="{{ asset('images/ecrite.png') }}" width="40" class="mb-2 mx-auto">
                                        <h6 class="mb-0">Expression Écrite</h6>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('test.expression_orale') }}"
                                        class="card h-100 text-decoration-none text-center p-3 border-0 shadow-sm"
                                        style="background-color: #249DB8;">
                                        <img src="{{ asset('images/orale.png') }}" width="40" class="mb-2 mx-auto">
                                        <h6 class="mb-0">Expression Orale</h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
