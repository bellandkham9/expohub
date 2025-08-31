@extends('layouts.app')

@if (auth()->check())
        @include('client.partials.navbar-client')
    @else
        @include('client.partials.navbar')
    @endif

@section('content')
<div class="bg-light">


    <div class="container my-4">
        <div class="row g-4 flex-column-reverse flex-lg-row">
            {{-- Section de l'historique --}}
            <div class="col-12 col-lg-9">
                <div class="mb-4">
                    <h2>Historique</h2>
                    <hr class="mt-2" style="height: 2px; background-color: black; border: none;">
                </div>

                <div style="max-height: 70vh; overflow-y: auto;">
                    <div class="list-group">
                        @foreach ($completedTests as $test)
                            <div class="list-group-item border-0 mb-3 rounded shadow-sm">
                                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center">
                                    <div class="mb-2 mb-sm-0">
                                        <h5 class="fw-bold mb-1">{{ $test['test_type'] }} - {{ $test['skill'] }}</h5>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($test['date'])->format('d/m/Y') }}
                                        </small>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row align-items-center gap-2 mt-2 mt-sm-0">
                                        <a href="{{ route($test['details_route'], ['id' => $test['related_id'] ?? $test['id']]) }}"
                                           class="btn btn-sm btn-outline-primary w-100">
                                            Détails
                                        </a>

                                        <div class="" style="width: 500px;">
                                            <a href="{{ route($test['refaire_route']) }}" class="btn btn-primary"
                                                style="background-color: #224194; color: white;"
                                                onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir recommencer le test ?')) { document.getElementById('reset-form-{{ $loop->index }}').submit(); }">
                                                Refaire le test
                                            </a>
                                            <form id="reset-form-{{ $loop->index }}" action="{{ route($test['refaire_route']) }}"
                                                  method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar" role="progressbar"
                                             style="width: {{ $test['max_score'] > 0 ? ($test['score'] / $test['max_score']) * 100 : 0 }}%; background-color: #224194;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

             <div class="col-12 col-lg-3">
                        <!-- Profil -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body text-center">
                                <div class="row align-items-center">
                                    <!-- Avatar -->
                                    <div class="col-6">
                                        <div class="avatar-container">
                                            <img src="{{ auth()->user()->avatar_url ? asset(auth()->user()->avatar_url) : asset('images/user-person.png') }}"
                                                alt="Avatar" class="rounded-circle avatar-img" width="80"
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
                                                $souscription = $souscriptionsPayees[$key] ?? null;
                                            @endphp

                                            <button type="button"
                                                class="btn btn-level {{ $souscription && $souscription->paye ? 'btn-outline-primary' : 'btn-secondary' }} {{ $souscription && $souscription->paye ? '' : 'disabled' }}"
                                                @if ($souscription && $souscription->paye) data-bs-toggle="modal" data-bs-target="#{{ $modalId }}" @endif>
                                                @if (!$souscription || !$souscription->paye)
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

        </div>
    </div>
    @include('start.chatbot')
</div>

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

    /* Styles pour la barre de progression */
    .progress-bar {
        background-color: #224194;
    }

    /* Media queries spécifiques pour la carte de profil, pour reproduire le comportement du dashboard */
    @media (max-width: 767.98px) {
        .card-body .row.align-items-center {
            display: flex;
            flex-wrap: wrap;
        }
        
        .card-body .col-md-6, .card-body .col-md-12 {
            width: auto;
            flex-grow: 1;
        }

        .card-body .col-md-6:first-child {
            max-width: 100px; /* Limite la largeur de l'avatar sur mobile */
        }

        .card-body .col-md-6:last-child {
            flex-grow: 1;
            text-align: left; /* Alignement du nom d'utilisateur */
        }

        .card-body .row.align-items-center .col-12 {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .card-body .row.align-items-center .col-12 h5 {
            margin-top: 0;
            margin-bottom: 0;
            padding-left: 1rem;
        }

        .card-body .row.align-items-center .col-12 .avatar-container {
            margin-bottom: 0;
        }
        
        .avatar-container {
            width: 70px; /* Avatar plus petit sur mobile */
            height: 70px;
        }

        .btn-level {
            width: 100px;
            height: 40px;
            font-size: 0.75rem;
        }
    }
</style>
@endsection