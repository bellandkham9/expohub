@extends('layouts.app')

@section('content')
    <div class="m-4">

        @include('client.partials.navbar-client')
        <!-- Hero Banner -->
        <div class="container my-4">
            <section id="">
                <div class="row justify-between align-items-start g-4">
                    <div class="col-lg-9">
                        <!-- Section Tests Disponibles -->
                        <section class="container mb-5">
                            <div class="mt-3">
                                <div class="" style="max-height: 70vh; overflow-y: auto;">
                                    <ul class="">
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
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <strong>Niveau :</strong> {{ $niveau }}
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
                                                                action="{{ route('comprehension_ecrite.reinitialiser') }}"
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

                        <section class="container mb-5" style="padding-right: 45px; padding-left: 45px;">

                            <div class="text-start">
                                <a href="#" class="btn-show-more" style="color: black">Toutes les réponses <i
                                        class="fas fa-chevron-down"></i></a>
                            </div>

                            @foreach ($reponses as $reponse)
                                <div class="row g-4 justify-content-center align-items-center mt-1 mb-3">

                                    {{-- Colonne gauche : la situation --}}
                                    <div class="col-12 col-md-10 col-lg-6" style="height: 20vh">
                                        <div class="result-card astuce p-4 h-100 text-justify rounded shadow-sm">
                                            @if (Str::endsWith($reponse->situation, ['.jpg', '.jpeg', '.png', '.gif', '.webp']))
                                                <img src="{{ asset('storage/' . $reponse->situation) }}" alt="situation"
                                                    class="img-fluid rounded"
                                                    style="max-height: 100%; object-fit: contain;">
                                            @else
                                                <p class="text-justify">{{ $reponse->situation }}</p>
                                            @endif
                                        </div>
                                    </div>


                                    {{-- Colonne droite : la question et réponses --}}
                                    <div class="col-12 col-md-12 col-lg-6" style="height: 20vh">
                                        <div class="p-2  text-justify rounded">
                                            <div class="row justify-between align-items-center mb-2">
                                                <div class="col-10">
                                                    <p class="fw-bold">Question
                                                        {{ $reponse->numero ?? $reponse->question_id }}:</p>

                                                    @if (\Illuminate\Support\Str::endsWith($reponse->question, '.mp3'))
                                                        <audio controls class="mt-2 w-100">
                                                            <source
                                                                src="{{ asset('storage/audio_questions/' . $reponse->question) }}"
                                                                type="audio/mpeg">
                                                            Votre navigateur ne supporte pas l'élément audio.
                                                        </audio>
                                                    @else
                                                        <p>{{ $reponse->question }}</p>
                                                    @endif
                                                </div>
                                            </div>

                                            <p>
                                                <span style="color: {{ $reponse->is_correct ? '#0DF840' : '#FF3B30' }};"
                                                    class="fw-bold ">Votre réponse :</span>
                                                {{ $reponse->reponse_utilisateur }}
                                                <span> </span>
                                                <span style="color: {{ $reponse->is_correct ? '#0DF840' : '#0DF840' }}"
                                                    class="fw-bold"> Bonne réponse :</span> {{ $reponse->bonne_reponse }}
                                            </p>

                                        </div>
                                    </div>

                                </div>
                            @endforeach

                        </section>


                    </div>
                    <!-- Sidebar Profil -->
                     <div class="col-lg-3">
                    <!-- Profil -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body text-center">
                            <img src="{{ asset('images/avatar.png') }}" alt="Profil" class="rounded-circle mb-3"
                                width="80">
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
                                                        <h5 class="modal-title" id="{{ $modalId }}Label">Niveaux pour
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
            </section>
        </div>
    </div>
@endsection
