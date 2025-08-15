@extends('layouts.app')

@section('content')
<div class="container-fluid dashboard-container">
    <!-- Navigation -->
    @include(auth()->check() ? 'client.partials.navbar-client' : 'client.partials.navbar')

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Hero Section -->
            <section class="hero-section mb-4">
                <div class="bg-light p-4 rounded-3 text-start">
                    <h1 class="fw-bold mb-3">Tableau de bord linguistique</h1>
                    
                </div>
            </section>

            <!-- Available Tests -->
            <section class="mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h2 class="h5 fw-bold mb-4">Tests disponibles</h2>
                        <div class="row g-3 p-4" style="height: 25vh; overflow-y: scroll;">
                            @foreach ($testTypes as $testType)
                            <div class="col-md-6">
                                <div class="test-card h-100 p-3 border rounded">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="test-icon me-3">
                                            <i class="fas fa-certificate fa-2x text-primary"></i>
                                        </div>
                                        <h3 class="h6 mb-0">{{ strtoupper($testType->nom) }}</h3>
                                    </div>
                                    <p class="small text-muted mb-3">
                                        {{ $testType->description ?? 'Test de langue officiel pour tous niveaux.' }}
                                    </p>
                                    <button class="btn btn-sm btn-primary w-100" 
                                            data-bs-toggle="modal"
                                            data-bs-target="#testModal"
                                            data-test-id="{{ $testType->id }}">
                                        Commencer
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <!-- Test History -->
            <section class="mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="h5 fw-bold mb-0">Vos derniers tests</h2>
                            <a href="{{ route('client.history') }}" class="btn btn-sm btn-outline-secondary">
                                Voir tout <i class="fas fa-chevron-right ms-1"></i>
                            </a>
                        </div>

                        <div class="test-history">
                            @forelse ($completedTests as $test)
                            <div class="test-item p-3 mb-3 border rounded">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h3 class="h6 fw-bold mb-1">{{ $test['test_type'] }} - {{ $test['skill'] }}</h3>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($test['date'])->translatedFormat('d M Y') }}
                                        </small>
                                    </div>
                                    <span class="badge bg-{{ $test['level'] == 'B2' ? 'success' : 'warning' }}">
                                        Niveau {{ $test['level'] ?? '—' }}
                                    </span>
                                </div>

                                <div class="progress-container mb-2">
                                    <div class="d-flex justify-content-between small mb-1">
                                        <span>Score: {{ $test['score'] }}/{{ $test['max_score'] }}</span>
                                        <span>{{ $test['correct_answers'] }}/{{ $test['total_questions'] }} bonnes réponses</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar" 
                                             role="progressbar" 
                                             style="width: {{ $test['max_score'] > 0 ? ($test['score'] / $test['max_score']) * 100 : 0 }}%"
                                             aria-valuenow="{{ $test['score'] }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="{{ $test['max_score'] }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route($test['details_route'], ['id' => $test['related_id'] ?? $test['id']]) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        Détails
                                    </a>
                                    <form action="{{ route($test['refaire_route']) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-sm btn-primary"
                                                onclick="return confirm('Êtes-vous sûr de vouloir recommencer ce test ?')">
                                            Refaire
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <p class="text-muted">Aucun test complété récemment</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-3">
            <!-- Profile Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="avatar-container mb-3">
                        <img src="{{ auth()->user()->avatar_url ? asset(auth()->user()->avatar_url) : asset('images/user-person.png') }}" 
                             alt="Avatar" 
                             class="rounded-circle avatar-img">
                    </div>
                    <h3 class="h5 mb-1">{{ Auth::user()->name }}</h3>
                    <p class="text-muted small mb-4">{{ Auth::user()->email }}</p>

                    <div class="skill-levels">
                        <h4 class="h6 fw-bold text-start mb-3">Vos niveaux par test</h4>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($testTypes as $testType)
                            @php
                                $modalId = 'modal_' . $testType->id;
                                $key = $testType->nom;
                                $niveaux = $userLevels[$key] ?? null;
                            @endphp

                            <button type="button" 
                                    class="btn btn-sm btn-outline-primary" 
                                    data-bs-toggle="modal"
                                    data-bs-target="#{{ $modalId }}">
                                {{ strtoupper($key) }}
                            </button>

                            <!-- Level Modal -->
                            <div class="modal fade" id="{{ $modalId }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Niveaux pour {{ strtoupper($key) }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if ($niveaux)
                                            <div class="row g-2">
                                                @foreach (['Compréhension Écrite', 'Compréhension Orale', 'Expression Écrite', 'Expression Orale'] as $skill)
                                                @php
                                                    $skillKey = strtolower(str_replace(' ', '_', $skill));
                                                    $level = $niveaux[$skillKey] ?? 'Non défini';
                                                    $color = match ($level) {
                                                        'C2', 'C1', 'B2' => 'success',
                                                        'B1', 'A2', 'A1' => 'warning',
                                                        default => 'secondary',
                                                    };
                                                @endphp
                                                <div class="col-6">
                                                    <div class="p-2 bg-light rounded">
                                                        <small class="d-block text-muted">{{ $skill }}</small>
                                                        <strong class="text-{{ $color }}">{{ $level }}</strong>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            @else
                                            <p class="text-muted">Aucun niveau enregistré pour ce test.</p>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
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

    <!-- Test Modal -->
    <div class="modal fade" id="testModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Choisissez une compétence</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="#" class="skill-card d-block p-3 rounded text-center text-decoration-none bg-yellow start-test-btn"
                               data-test-type="comprehension_ecrite"
                               data-test-name="Compréhension Écrite">
                                <img src="{{ asset('images/lecture.png') }}" width="40" class="mb-2">
                                <h6 class="mb-0">Compréhension Écrite</h6>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="#" class="skill-card d-block p-3 rounded text-center text-decoration-none bg-red start-test-btn"
                               data-test-type="comprehension_orale"
                               data-test-name="Compréhension Orale">
                                <img src="{{ asset('images/ecoute.png') }}" width="40" class="mb-2">
                                <h6 class="mb-0">Compréhension Orale</h6>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="#" class="skill-card d-block p-3 rounded text-center text-decoration-none bg-blue start-test-btn"
                               data-test-type="expression_ecrite"
                               data-test-name="Expression Écrite">
                                <img src="{{ asset('images/ecrite.png') }}" width="40" class="mb-2">
                                <h6 class="mb-0">Expression Écrite</h6>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="#" class="skill-card d-block p-3 rounded text-center text-decoration-none bg-teal start-test-btn"
                               data-test-type="expression_orale"
                               data-test-name="Expression Orale">
                                <img src="{{ asset('images/orale.png') }}" width="40" class="mb-2">
                                <h6 class="mb-0">Expression Orale</h6>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .dashboard-container {
        padding: 20px;
        max-width: 1400px;
        margin: 0 auto;
    }
    
    .avatar-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
    }
    
    .test-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .test-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .test-item {
        transition: all 0.2s;
    }
    
    .test-item:hover {
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .bg-yellow { background-color: #F8B70D; color: white; }
    .bg-red { background-color: #FF3B30; color: white; }
    .bg-blue { background-color: #224194; color: white; }
    .bg-teal { background-color: #249DB8; color: white; }
    
    .skill-card {
        transition: transform 0.2s;
        height: 100%;
    }
    
    .skill-card:hover {
        transform: scale(1.03);
        opacity: 0.9;
    }
    
    .consignes-popup {
        max-width: 600px;
        font-size: 1.1em;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des clics sur les boutons de test
    document.querySelectorAll('.start-test-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const testType = this.dataset.testType;
            const testName = this.dataset.testName;
            
            // Consignes personnalisées par type de test
            const consignes = {
                'comprehension_ecrite': `Bienvenue au test de Compréhension Écrite.

                        Durée : 60 minutes
                        Nombre de questions : 30

                        Instructions :
                        1. Lisez attentivement chaque texte
                        2. Répondez aux questions associées
                        3. Vous ne pouvez pas revenir en arrière`,
                                        
                                        'comprehension_orale': `Bienvenue au test de Compréhension Orale.

                        Durée : 45 minutes
                        Nombre d'extraits audio : 20

                        Instructions :
                        1. Écoutez chaque extrait une seule fois
                        2. Prenez des notes si nécessaire
                        3. Répondez aux questions`,
                                        
                                        'expression_ecrite': `Bienvenue au test d'Expression Écrite.

                        Durée : 60 minutes
                        Nombre de sujets : 2

                        Instructions :
                        1. Structurez clairement vos réponses
                        2. Vérifiez votre grammaire et orthographe
                        3. Respectez le nombre de mots demandé`,
                                        
                                        'expression_orale': `Bienvenue au test d'Expression Orale.

                        Durée : 15 minutes
                        Nombre de sujets : 3

                        Instructions :
                        1. Parlez clairement et distinctement
                        2. Structurez vos idées
                        3. Utilisez un vocabulaire varié`
            };

            Swal.fire({
                title: `Consignes - ${testName}`,
                html: `<div style="text-align: left; white-space: pre-line;">${consignes[testType]}</div>`,
                icon: 'info',
                confirmButtonText: 'Commencer le test',
                showCancelButton: true,
                cancelButtonText: 'Annuler',
                customClass: {
                    popup: 'consignes-popup'
                },
                allowOutsideClick: false,
                willOpen: () => {
                    // Option: lire les consignes à haute voix
                    if ('speechSynthesis' in window) {
                        const speech = new SpeechSynthesisUtterance(consignes[testType]);
                        speech.lang = 'fr-FR';
                        window.speechSynthesis.speak(speech);
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirection vers le test correspondant
                    switch(testType) {
                        case 'comprehension_ecrite':
                            window.location.href = "{{ route('test.comprehension_ecrite') }}";
                            break;
                        case 'comprehension_orale':
                            window.location.href = "{{ route('test.comprehension_orale') }}";
                            break;
                        case 'expression_ecrite':
                            window.location.href = "{{ route('test.expression_ecrite') }}";
                            break;
                        case 'expression_orale':
                            window.location.href = "{{ route('test.expression_orale') }}";
                            break;
                    }
                }
            });
        });
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gérer la modal des tests
        const testModal = document.getElementById('testModal');
        if (testModal) {
            testModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const testId = button.getAttribute('data-test-id');
                // Vous pouvez utiliser testId pour personnaliser la modal si nécessaire
            });
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let userName = @json(Auth::user()->name ?? 'Cher utilisateur');
    let testPropose = "Compréhension Écrite"; // Exemple, à remplacer par ta valeur dynamique

    // Vérifie si le popup a déjà été affiché pour cet utilisateur
    if (!localStorage.getItem(`popupShown_${userName}`)) {
        let message = `Bonjour ${userName}, bienvenue sur notre plateforme ! 
Vous pouvez suivre vos tests, continuer votre progression, et nous contacter à tout moment.
Nous vous proposons aujourd'hui de continuer avec le test : ${testPropose}.`;

        Swal.fire({
            title: `Bienvenue ${userName} 🎉`,
            html: `
                <p>${message.replace(/\n/g, "<br>")}</p>
                <button id="btnCommencerTest" class="btn btn-primary mt-2">
                    Commencer ${testPropose}
                </button>
            `,
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                document.getElementById("btnCommencerTest").addEventListener("click", () => {
                    Swal.close();
                    // Marque comme affiché
                    localStorage.setItem(`popupShown_${userName}`, "true");
                });
            }
        });
    }
});
</script>

@endsection