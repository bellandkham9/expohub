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
                            <div class="row g-3 p-4" style="height: 25vh; overflow-y: scroll;">
                                <div class="row g-3">
                                    @if ($testTypes->isEmpty())
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
                                        @foreach ($testTypes as $testType)
                                            <div class="col-md-6">
                                                <div class="test-card h-100 p-3 border rounded shadow-sm">
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
                                    <div class="list-group-item border-0 mb-3 rounded"
                                        style="box-shadow: 1px 1px 1px 1px gainsboro; padding: 10px;">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h5 class="fw-bold mb-1">{{ $test['test_type'] }} - {{ $test['skill'] }}
                                                </h5>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($test['date'])->format('d/m/Y') }}
                                                </small>

                                            </div>

                                        </div>

                                        <div class="mt-3">

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

                                                <form id="reset-form" action="{{ route($test['refaire_route']) }}"
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
                </section>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-3">
                <!-- Profil -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body text-center">
                        <div class="row align-items-center">
                            <!-- Avatar -->
                            <div class="col-6 col-sm-5 col-md-5 col-lg-5  mb-2 mb-md-0">
                                <div class="avatar-container text-center text-md-start">
                                    <img src="{{ auth()->user()->avatar_url ? asset(auth()->user()->avatar_url) : asset('images/user-person.png') }}"
                                        alt="Avatar" class="rounded-circle avatar-img img-fluid" width="150"
                                        height="150">
                                </div>
                            </div>

                            <!-- Nom utilisateur -->
                            <div class="col-6 col-sm-7 col-md-7 col-lg-7">
                                <h5 class="card-title mb-0 text-center text-md-start">
                                    {{ Auth::user()->name }}
                                </h5>
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
                            <h6 class="text-start fw-bold mb-3">Vos niveaux par test</h6>

                            <div class="d-flex flex-wrap gap-2">
                                {{-- Assurez-vous que la variable passée depuis le contrôleur est bien $abonnementsPourAffichage --}}
                                @foreach ($testTypes1 as $testType)
                                    @php
                                        $modalId = 'modal_' . $testType->id;
                                        $key = $testType->examen; // Assumant que 'examen' est la propriété à afficher
                                        // N'oubliez pas que $userLevels n'est pas passé dans le contrôleur modifié.
                                        // Si vous avez besoin de $userLevels, assurez-vous de le passer depuis le contrôleur.
                                        $niveaux = $userLevels[$key] ?? null;
                                    @endphp

                                    {{-- Le bouton principal --}}
                                    <button style="width: 130px; height: 50px; border-radius: 8px;" type="button"
                                        class="btn {{ $testType->paye ? 'btn-outline-primary' : 'btn-secondary' }}
                                                {{ $testType->paye ? '' : 'disabled' }}"
                                        @if ($testType->paye) data-bs-toggle="modal" data-bs-target="#{{ $modalId }}" @endif>
                                        @if (!$testType->paye)
                                            {{-- Icône de cadenas pour les abonnements non payés --}}
                                            <i class="fas fa-lock me-2"></i>
                                        @endif
                                        {{ strtoupper($key) }}
                                    </button>


                                    {{-- Le Modal (s'affiche seulement si l'abonnement est payé et le bouton cliquable) --}}
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
                                                        <p class="text-muted">Aucun niveau enregistré pour ce test.
                                                        </p>
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
                                <a href="#"
                                    class="skill-card d-block p-3 rounded text-center text-decoration-none bg-yellow start-test-btn"
                                    data-test-type="comprehension_ecrite" data-test-name="Compréhension Écrite">
                                    <img src="{{ asset('images/lecture.png') }}" width="40" class="mb-2">
                                    <h6 class="mb-0">Compréhension Écrite</h6>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="#"
                                    class="skill-card d-block p-3 rounded text-center text-decoration-none bg-red start-test-btn"
                                    data-test-type="comprehension_orale" data-test-name="Compréhension Orale">
                                    <img src="{{ asset('images/ecoute.png') }}" width="40" class="mb-2">
                                    <h6 class="mb-0">Compréhension Orale</h6>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="#"
                                    class="skill-card d-block p-3 rounded text-center text-decoration-none bg-blue start-test-btn"
                                    data-test-type="expression_ecrite" data-test-name="Expression Écrite">
                                    <img src="{{ asset('images/ecrite.png') }}" width="40" class="mb-2">
                                    <h6 class="mb-0">Expression Écrite</h6>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="#"
                                    class="skill-card d-block p-3 rounded text-center text-decoration-none bg-teal start-test-btn"
                                    data-test-type="expression_orale" data-test-name="Expression Orale">
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
    </script>


@endsection
