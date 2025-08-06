@extends('layouts.app')

@section('content')
<div class="">

   @include('client.partials.navbar-client')
   
    <!-- Hero Banner -->
    <div class="container my-4">
        <section id="">
            <div class="row justify-between align-items-start g-4">
                <div class="col-lg-9">
                    <div class="container m-6">
                        <h2>Historique</h2>
                        <hr style="height: 2px; background-color: black; border: none;" class="">
                    </div>
                    <div class="" style="max-height: 70vh; overflow-y: auto;">
                        
                         <div class="list-group">
                            @foreach ($completedTests as $test)
                                <div class="list-group-item border-0 mb-3 rounded" style="box-shadow: 2px 2px 2px 2px gainsboro">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h5 class="fw-bold mb-1">{{ $test['test_type'] }} - {{ $test['skill'] }}</h5>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($test['date'])->format('d/m/Y') }}
                                            </small>

                                        </div>
                                        <span class="badge bg-{{ $test['level'] == 'B2' ? 'success' : 'warning' }}">
                                            Niveau {{ $test['level'] ?? '—' }}
                                        </span>

                                    </div>

                                    <div class="mt-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Score: {{ $test['score'] }}/{{ $test['max_score'] }}</span>
                                            <span>{{ $test['correct_answers'] }}/{{ $test['total_questions'] }} bonnes
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
                                                                action="{{ route($test['refaire_route']) }}"
                                                                method="POST" class="d-none">
                                                                @csrf
                                                            </form>
                                                        </div>


                                      

                                    </div>

                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <!-- Profil -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body text-center">
                            <img src="{{ asset('images/avatar.png') }}" alt="Profil" class="rounded-circle mb-3"
                                width="80">
                            <h5 class="card-title mb-1">{{ Auth::user()->name }}</h5>
                            <p class="text-muted small">Étudiant en français</p>

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
