@extends('layouts.app')

@section('content')
    <div class="m-4">

        @include('client.partials.navbar-client')

        <!-- Hero Banner -->
        <div class="container my-4">
            <section>
                <div class="row justify-between align-items-start g-4">

                    <div class="col-lg-9">
                        <!-- Section Hero -->
                        <section class="hero-section mb-4">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-10 text-start">
                                        <h2>Préparez-vous efficacement aux tests officiels de français</h2>
                                        <p>Choisissez l’un des tests disponibles ci-dessous pour évaluer vos compétences
                                            linguistiques dans un cadre officiel. Chaque test est adapté aux exigences des
                                            examens comme le TCF, TEF, DELF et DALF.</p>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Section Tests Disponibles -->
                        <section class="container mb-5">
                            <div class="row g-4 justify-content-center">
                                {{-- Assurez-vous que la variable passée depuis le contrôleur est bien $abonnementsPourAffichage --}}
                                @foreach ($testTypes as $testType)
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="test-card text-center h-100 p-4">

                                            <h3 class="test-title h5 mb-3">{{ strtoupper($testType->examen) }}</h3>
                                            <p class="mb-4 text-muted">
                                                {{-- Assurez-vous que $testType->description existe, sinon vous utilisez $testType->description ?? '...' --}}
                                                {{ $testType->description ?? 'Test de langue officiel pour tous niveaux.' }}
                                            </p>

                                            {{-- Le bouton "Commencer" avec la logique payé/non-payé --}}
                                            <button
                                                class="btn {{ $testType->paye ? 'btn-primary' : 'btn-secondary' }} 
                                                    {{ $testType->paye ? '' : 'disabled' }}"
                                                @if ($testType->paye) data-bs-toggle="modal"
                                                    data-type="{{ $testType->nom }}" {{-- Assurez-vous que $testType->nom existe --}}
                                                    data-id="{{ $testType->id }}"
                                                    data-bs-target="#testModal" @endif>
                                                @if (!$testType->paye)
                                                    {{-- Icône de cadenas si l'abonnement n'est pas payé --}}
                                                    <i class="fas fa-lock me-2"></i>
                                                @endif
                                                Commencer
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </section>
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

                   <div class="col-lg-3">
            <!-- Profil -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="row align-items-center">
                        <!-- Avatar -->
                        <div class="col-6">
                            <div class="avatar-container">
                                <img src="{{ auth()->user()->avatar_url ? asset(auth()->user()->avatar_url) : asset('images/user-person.png') }}"
                                     alt="Avatar" class="rounded-circle avatar-img " width="80" height="80">
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

                            <button type="button" class="btn btn-level {{ $testType->paye ? 'btn-outline-primary' : 'btn-secondary' }} {{ $testType->paye ? '' : 'disabled' }}"
                                    @if($testType->paye) data-bs-toggle="modal" data-bs-target="#{{ $modalId }}" @endif>
                                @if(!$testType->paye)
                                <i class="fas fa-lock me-1"></i>
                                @endif
                                {{ strtoupper($key) }}
                            </button>

                            <!-- Modal -->
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

    <style>
        .btn-primary{
            border-radius: 20px;
            background-color: #224194;
            color: white;
        }
        .btn-secondary{
            border-radius: 20px;
            color: white;
        }
    </style>
@endsection
