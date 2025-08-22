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
                        <h2 class="h5 fw-bold mb-4">Abonnements</h2>
                        <div class="test-grid" style="max-height: 25vh; overflow-y: auto;">
                            @if ($testTypes->isEmpty())
                            <div class="col-12">
                                <div class="alert alert-warning text-center">
                                    <h5 class="mb-3">Aucun abonnement disponible</h5>
                                    <p class="mb-3">Souscrivez à un abonnement pour accéder aux tests.</p>
                                    <a href="{{ route('client.paiement') }}" class="btn btn-warning">
                                        Voir les abonnements
                                    </a>
                                </div>
                            </div>
                            @else
                            <div class="row g-3">
                                @foreach ($testTypes as $testType)
                                <div class="col-md-6">
                                    <div class="test-card h-100 p-3 border rounded shadow-sm">
                                        <div class="d-flex align-items-center mb-3">
                                            <h3 class="h6 mb-0">
                                                {{ strtoupper($testType->abonnement->examen ?? 'Test') }}
                                            </h3>
                                        </div>
                                        <p class="small text-muted mb-3">
                                            {{ $testType->abonnement->description ?? 'Test de langue officiel pour tous niveaux.' }}
                                        </p>
                                        <button class="btn btn-sm btn-primary w-100" data-bs-toggle="modal"
                                            data-bs-target="#testModal" data-test-id="{{ $testType->id }}">
                                            Commencer
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
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
                            @foreach ($completedTests as $test)
                            <div class="test-item card border-0 mb-3 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h5 class="fw-bold mb-1">{{ $test['test_type'] }} - {{ $test['skill'] }}</h5>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($test['date'])->format('d/m/Y') }}
                                            </small>
                                        </div>
                                    </div>

                                    <div class="progress mt-3" style="height: 8px;">
                                        <div class="progress-bar" role="progressbar" 
                                             style="width: {{ $test['max_score'] > 0 ? ($test['score'] / $test['max_score']) * 100 : 0 }}%"
                                             aria-valuenow="{{ $test['score'] }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="{{ $test['max_score'] }}">
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end gap-2 mt-3">
                                        <a href="{{ route($test['details_route'], ['id' => $test['related_id'] ?? $test['id']]) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            Détails
                                        </a>
                                        <form action="{{ route($test['refaire_route']) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir recommencer le test ?')">
                                                Refaire le test
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-3">
            <!-- Profil -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="row align-items-center">
                        <!-- Avatar -->
                        <div class="col-6">
                            <div class="avatar-container">
                                <img src="{{ auth()->user()->avatar_url ? asset(auth()->user()->avatar_url) : asset('images/user-person.png') }}"
                                     alt="Avatar" class="rounded-circle avatar-img img-fluid" width="80" height="80">
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
                            @foreach ($testTypes1 as $testType)
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
                        @foreach([
                            ['type' => 'comprehension_ecrite', 'name' => 'Compréhension Écrite', 'color' => 'yellow', 'icon' => 'lecture.png'],
                            ['type' => 'comprehension_orale', 'name' => 'Compréhension Orale', 'color' => 'red', 'icon' => 'ecoute.png'],
                            ['type' => 'expression_ecrite', 'name' => 'Expression Écrite', 'color' => 'blue', 'icon' => 'ecrite.png'],
                            ['type' => 'expression_orale', 'name' => 'Expression Orale', 'color' => 'teal', 'icon' => 'orale.png']
                        ] as $skill)
                        <div class="col-6">
                            <a href="#" class="skill-card d-block p-3 rounded text-center text-decoration-none bg-{{ $skill['color'] }} start-test-btn"
                               data-test-type="{{ $skill['type'] }}" data-test-name="{{ $skill['name'] }}">
                                <img src="{{ asset('images/' . $skill['icon']) }}" width="40" class="mb-2" alt="{{ $skill['name'] }}">
                                <h6 class="mb-0">{{ $skill['name'] }}</h6>
                            </a>
                        </div>
                        @endforeach
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
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.test-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.test-item {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.test-item:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.bg-yellow { background-color: #F8B70D; color: white; }
.bg-red { background-color: #FF3B30; color: white; }
.bg-blue { background-color: #224194; color: white; }
.bg-teal { background-color: #249DB8; color: white; }

.skill-card {
    transition: all 0.3s ease;
    height: 100%;
}

.skill-card:hover {
    transform: scale(1.03);
    opacity: 0.9;
}

.btn-level {
    width: 130px;
    height: 50px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
}

.test-grid {
    scrollbar-width: thin;
    scrollbar-color: #dee2e6 #f8f9fa;
}

.test-grid::-webkit-scrollbar {
    width: 6px;
}

.test-grid::-webkit-scrollbar-track {
    background: #f8f9fa;
    border-radius: 3px;
}

.test-grid::-webkit-scrollbar-thumb {
    background: #dee2e6;
    border-radius: 3px;
}

.test-grid::-webkit-scrollbar-thumb:hover {
    background: #adb5bd;
}

@media (max-width: 768px) {
    .dashboard-container {
        padding: 15px;
    }
    
    .btn-level {
        width: 110px;
        height: 45px;
        font-size: 0.8rem;
    }
    
    .avatar-img {
        width: 60px;
        height: 60px;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des tests
    document.querySelectorAll('.start-test-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const testType = this.dataset.testType;
            const testName = this.dataset.testName;

            const consignes = {
                'comprehension_ecrite': `Bienvenue au test de Compréhension Écrite.\n\nDurée : 60 minutes\nNombre de questions : 30\n\nInstructions :\n1. Lisez attentivement chaque texte\n2. Répondez aux questions associées\n3. Vous ne pouvez pas revenir en arrière`,
                'comprehension_orale': `Bienvenue au test de Compréhension Orale.\n\nDurée : 45 minutes\nNombre d'extraits audio : 20\n\nInstructions :\n1. Écoutez chaque extrait une seule fois\n2. Prenez des notes si nécessaire\n3. Répondez aux questions`,
                'expression_ecrite': `Bienvenue au test d'Expression Écrite.\n\nDurée : 60 minutes\nNombre de sujets : 2\n\nInstructions :\n1. Structurez clairement vos réponses\n2. Vérifiez votre grammaire et orthographe\n3. Respectez le nombre de mots demandé`,
                'expression_orale': `Bienvenue au test d'Expression Orale.\n\nDurée : 15 minutes\nNombre de sujets : 3\n\nInstructions :\n1. Parlez clairement et distinctement\n2. Structurez vos idées\n3. Utilisez un vocabulaire varié`
            };

            Swal.fire({
                title: `Consignes - ${testName}`,
                html: `<div style="text-align: left; white-space: pre-line;">${consignes[testType]}</div>`,
                icon: 'info',
                confirmButtonText: 'Commencer le test',
                showCancelButton: true,
                cancelButtonText: 'Annuler',
                width: '600px',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    const routes = {
                        'comprehension_ecrite': "{{ route('test.comprehension_ecrite') }}",
                        'comprehension_orale': "{{ route('test.comprehension_orale') }}",
                        'expression_ecrite': "{{ route('test.expression_ecrite') }}",
                        'expression_orale': "{{ route('test.expression_orale') }}"
                    };
                    window.location.href = routes[testType];
                }
            });
        });
    });

    // Popup de bienvenue
    const userName = "{{ Auth::user()->name ?? 'Cher utilisateur' }}";
    if (!localStorage.getItem(`popupShown_${userName}`)) {
        setTimeout(() => {
            Swal.fire({
                title: `Bienvenue ${userName} 🎉`,
                html: `<p>Bienvenue sur notre plateforme ! Vous pouvez suivre vos tests, continuer votre progression, et nous contacter à tout moment.</p>`,
                icon: 'success',
                confirmButtonText: 'Commencer',
                allowOutsideClick: false
            }).then(() => {
                localStorage.setItem(`popupShown_${userName}`, "true");
            });
        }, 1000);
    }
});
</script>
@endsection

