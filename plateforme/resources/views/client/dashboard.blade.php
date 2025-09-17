@extends('layouts.app')
        @include(auth()->check() ? 'client.partials.navbar-client' : 'client.partials.navbar')

@section('content')
    <div class="container-fluid dashboard-container">
        <!-- Navigation -->

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
                            <div class="row g-3" style="height: 30vh; overflow-y: scroll;">
                                <div class="row g-3">
                                    @if ($souscriptionActive->isEmpty())
                                        <div class="col-12">
                                            <div class="alert alert-warning text-center">
                                                <h5 class="mb-3">Aucun abonnement disponible pour votre compte</h5>
                                                <p class="mb-3">Vous devez souscrire à un abonnement pour accéder aux
                                                    tests.</p>
                                                <a href="{{ route('client.paiement') }}" class="btn btn-warning">Voir les
                                                    abonnements</a>
                                            </div>
                                        </div>
                                    @else
                                        @foreach ($souscriptionActive as $testType)
                                            <div class="col-md-6">
                                                <div class="test-card h-90  border rounded shadow-sm">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <h3 class="h6 mb-0">
                                                            {{ strtoupper($testType->abonnement->examen ?? 'Test') }}</h3>
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
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </section>

                <!-- Test History -->
                <section class="mb-4">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h2 class="h5 fw-bold mb-0">Vos derniers tests</h2>
                                <a href="{{ route('client.history') }}" class="btn btn-sm btn-outline-secondary">
                                    Voir tout <i class="fas fa-chevron-right ms-1"></i>
                                </a>
                            </div>

                            <div class="test-history">
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
                    </div>
                </section>
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
                                                $key = $testType->examen;
                                                $niveaux = $userLevels[$key] ?? null;
                                                $skills = [
                                                    'Compréhension Écrite' => 'comprehension_ecrite',
                                                    'Compréhension Orale' => 'comprehension_orale',
                                                    'Expression Écrite' => 'expression_ecrite',
                                                    'Expression Orale' => 'expression_orale',
                                                ];
                                            @endphp
                                            <button type="button" class="btn btn-level {{ $testType->paye ? 'btn-outline-primary' : 'btn-secondary' }} {{ $testType->paye ? '' : 'disabled' }}"
                                                    @if($testType->paye) data-bs-toggle="modal" data-bs-target="#{{ $modalId }}" @endif>
                                                @if(!$testType->paye)
                                                <i class="fas fa-lock me-1"></i>
                                                @endif
                                                {{ strtoupper($key) }}
                                            </button>
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
        <div class="modal fade" id="testModal" tabindex="-1" aria-labelledby="testModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="testModalLabel">Choisissez une compétence</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-6 col-md-6">
                                <a href="#" class="skill-card d-block p-3 rounded text-center text-decoration-none bg-warning start-test-btn"
                                   data-test-type="comprehension_ecrite" data-test-name="Compréhension Écrite">
                                    <img src="{{ asset('images/lecture.png') }}" width="40" class="mb-2" alt="Lecture" loading="lazy">
                                    <h6 class="mb-0">Compréhension Écrite</h6>
                                </a>
                            </div>
                            <div class="col-6 col-md-6">
                                <a href="#" class="skill-card d-block p-3 rounded text-center text-decoration-none bg-danger text-white start-test-btn"
                                   data-test-type="comprehension_orale" data-test-name="Compréhension Orale">
                                    <img src="{{ asset('images/ecoute.png') }}" width="40" class="mb-2" alt="Écoute" loading="lazy">
                                    <h6 class="mb-0">Compréhension Orale</h6>
                                </a>
                            </div>
                            <div class="col-6 col-md-6">
                                <a href="#" class="skill-card d-block p-3 rounded text-center text-decoration-none bg-primary text-white start-test-btn"
                                   data-test-type="expression_ecrite" data-test-name="Expression Écrite">
                                    <img src="{{ asset('images/ecrite.png') }}" width="40" class="mb-2" alt="Écriture" loading="lazy">
                                    <h6 class="mb-0">Expression Écrite</h6>
                                </a>
                            </div>
                            <div class="col-6 col-md-6">
                                <a href="#" class="skill-card d-block p-3 rounded text-center text-decoration-none bg-info text-white start-test-btn"
                                   data-test-type="expression_orale" data-test-name="Expression Orale">
                                    <img src="{{ asset('images/orale.png') }}" width="40" class="mb-2" alt="Orale" loading="lazy">
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
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .test-item {
            transition: all 0.2s;
        }

        .test-item:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .bg-yellow {
            background-color: #F8B70D;
            color: white;
        }

        .bg-red {
            background-color: #FF3B30;
            color: white;
        }

        .bg-blue {
            background-color: #224194;
            color: white;
        }

        .bg-teal {
            background-color: #249DB8;
            color: white;
        }

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
                                const speech = new SpeechSynthesisUtterance(consignes[
                                    testType]);
                                speech.lang = 'fr-FR';
                                window.speechSynthesis.speak(speech);
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirection vers le test correspondant
                            switch (testType) {
                                case 'comprehension_ecrite':
                                    window.location.href =
                                        "{{ route('test.comprehension_ecrite') }}";
                                    break;
                                case 'comprehension_orale':
                                    window.location.href =
                                        "{{ route('test.comprehension_orale') }}";
                                    break;
                                case 'expression_ecrite':
                                    window.location.href =
                                        "{{ route('test.expression_ecrite') }}";
                                    break;
                                case 'expression_orale':
                                    window.location.href =
                                        "{{ route('test.expression_orale') }}";
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


    {{-- script concernant la notification user-person --}}

    <script>
        document.addEventListener('click', function(e) {
            const link = e.target.closest('.notification-link');
            if (!link) return;

            e.preventDefault();

            const url = link.dataset.url;
            const li = link.closest('li');

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: '{}' // corps vide
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) throw new Error('Erreur serveur');

                    // Effet disparition
                    if (li) {
                        li.style.transition = 'opacity .25s ease';
                        li.style.opacity = '0';
                        setTimeout(() => li.remove(), 250);
                    }

                    // Mise à jour compteur
                    const badge = document.getElementById('notifCount');
                    if (badge) {
                        let n = parseInt(badge.textContent || '0', 10);
                        n = Math.max(0, n - 1);
                        badge.textContent = n;
                        if (n === 0) badge.classList.add('d-none');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Impossible de marquer la notification comme lue.');
                });
        });
    </script>
    <script>
        document.addEventListener('click', function(e) {
            // Suppression
            const removeBtn = e.target.closest('.notif-remove');
            if (removeBtn) {
                e.stopPropagation(); // empêche le clic sur le lien parent
                const notifId = removeBtn.dataset.id;
                const li = removeBtn.closest('li');

                fetch(`/admin/notifications/${notifId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success && li) {
                            li.style.transition = 'opacity .25s ease';
                            li.style.opacity = '0';
                            setTimeout(() => li.remove(), 250);

                            // Mise à jour du compteur
                            const badge = document.getElementById('notifCount');
                            if (badge) {
                                let n = parseInt(badge.textContent || '0', 10);
                                n = Math.max(0, n - 1);
                                badge.textContent = n;
                                if (n === 0) badge.classList.add('d-none');
                            }
                        }
                    })
                    .catch(err => console.error("Impossible de supprimer la notification", err));
            }
        });




         // Gestion des tests
                document.querySelectorAll('.start-test-btn').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const testType = this.dataset.testType;
                        const testName = this.dataset.testName;

                        const consignes = {
                            comprehension_ecrite: `Bienvenue au test de Compréhension Écrite.\n\nDurée : 60 minutes\nNombre de questions : 30\n\nInstructions :\n1. Lisez attentivement chaque texte\n2. Répondez aux questions associées\n3. Vous ne pouvez pas revenir en arrière`,
                            comprehension_orale: `Bienvenue au test de Compréhension Orale.\n\nDurée : 45 minutes\nNombre d'extraits audio : 20\n\nInstructions :\n1. Écoutez chaque extrait une seule fois\n2. Prenez des notes si nécessaire\n3. Répondez aux questions`,
                            expression_ecrite: `Bienvenue au test d'Expression Écrite.\n\nDurée : 60 minutes\nNombre de sujets : 2\n\nInstructions :\n1. Structurez clairement vos réponses\n2. Vérifiez votre grammaire et orthographe\n3. Respectez le nombre de mots demandé`,
                            expression_orale: `Bienvenue au test d'Expression Orale.\n\nDurée : 15 minutes\nNombre de sujets : 3\n\nInstructions :\n1. Parlez clairement et distinctement\n2. Structurez vos idées\n3. Utilisez un vocabulaire varié`
                        };

                        Swal.fire({
                            title: `Consignes - ${testName}`,
                            html: `<div style="text-align:left; white-space: pre-line;">${consignes[testType]}</div>`,
                            icon: 'info',
                            confirmButtonText: 'Commencer le test',
                            showCancelButton: true,
                            cancelButtonText: 'Annuler',
                            allowOutsideClick: false,
                            width: '600px'
                        }).then(result => {
                            if (result.isConfirmed) {
                                const routes = {
                                    comprehension_ecrite: "{{ route('test.comprehension_ecrite') }}",
                                    comprehension_orale: "{{ route('test.comprehension_orale') }}",
                                    expression_ecrite: "{{ route('test.expression_ecrite') }}",
                                    expression_orale: "{{ route('test.expression_orale') }}"
                                };
                                window.location.href = routes[testType];
                            }
                        });
                    });
                });
    </script>


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
