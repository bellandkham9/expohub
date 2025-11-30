@extends('layouts.app')

@section('meta_title', 'Tests TCF Canada en ligne - ExpoHub Academy')
@section('meta_description',
    'Entraînez-vous efficacement pour le TCF Canada grâce à nos tests interactifs de
    compréhension et d’expression.')
@section('meta_keywords',
    'tcf canada, test de français, compréhension, expression, plateforme apprentissage, tef, delf,
    dalf')


@section('content')
    <div class="container-fluid dashboard-container">
        @include(auth()->check() ? 'client.partials.navbar-client' : 'client.partials.navbar')

        <div class="row g-4">
            <div class="col-lg-9">
                <section class="hero-section mb-4">
                    <div class="bg-light p-4 rounded-3 text-start">
                        <h1 class="fw-bold mb-3">Tableau de bord</h1>

                    </div>
                </section>

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
                                                            {{ strtoupper($testType->abonnement->examen ?? 'Test') }} <span
                                                                style="color: #F8B70D; font-size: 12px;">({{ strtoupper($testType->abonnement->nom_du_plan) }})</span>
                                                        </h3>
                                                    </div>
                                                    <p class="small text-muted mb-3">
                                                        {{ $testType->abonnement->description ?? 'Test de langue officiel pour tous niveaux.' }}
                                                    </p>
                                                    <button
                                                        style="background-color: #224194; color: white; border-radius: 15px;"
                                                        class="btn btn-sm btn-primary w-100" data-bs-toggle="modal"
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
                                            <div
                                                class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center">
                                                <div class="mb-2 mb-sm-0">
                                                    <h6 class="fw-bold mb-1">{{ $test['test_type'] }} - {{ $test['skill'] }}
                                                    </h6>
                                                    <small class="text-muted">
                                                        {{ \Carbon\Carbon::parse($test['date'])->format('d/m/Y') }}
                                                    </small>
                                                </div>
                                                <div
                                                    class="d-flex flex-column flex-sm-row align-items-center gap-2 mt-2 mt-sm-0">
                                                    <a href="{{ route($test['details_route'], ['id' => $test['related_id'] ?? $test['id']]) }}"
                                                        class="btn btn-sm btn-outline-primary w-100">
                                                        Détails
                                                    </a>

                                                    <div class="">
                                                        <a href="{{ route($test['refaire_route']) }}"
                                                            class="btn btn-primary"
                                                            style="background-color: #224194; color: white; border-radius: 15px;"
                                                            onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir recommencer le test ?')) { document.getElementById('reset-form-{{ $loop->index }}').submit(); }">
                                                            Refaire
                                                        </a>
                                                        <form id="reset-form-{{ $loop->index }}"
                                                            action="{{ route($test['refaire_route']) }}" method="POST"
                                                            class="d-none">
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
                                                                    'B1', 'A2', 'A1', 'A0' => 'warning',
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
                                <a href="#"
                                    class="skill-card d-block p-3 rounded text-center text-decoration-none bg-warning start-test-btn"
                                    data-test-type="comprehension_ecrite" data-test-name="Compréhension Écrite">
                                    <img src="{{ asset('images/lecture.png') }}" width="40" class="mb-2"
                                        alt="Lecture" loading="lazy">
                                    <h6 class="mb-0">Compréhension Écrite</h6>
                                </a>
                            </div>
                            <div class="col-6 col-md-6">
                                <a href="#"
                                    class="skill-card d-block p-3 rounded text-center text-decoration-none bg-danger text-white start-test-btn"
                                    data-test-type="comprehension_orale" data-test-name="Compréhension Orale">
                                    <img src="{{ asset('images/ecoute.png') }}" width="40" class="mb-2"
                                        alt="Écoute" loading="lazy">
                                    <h6 class="mb-0">Compréhension Orale</h6>
                                </a>
                            </div>
                            <div class="col-6 col-md-6">
                                <a href="#"
                                    class="skill-card d-block p-3 rounded text-center text-decoration-none bg-primary text-white start-test-btn"
                                    data-test-type="expression_ecrite" data-test-name="Expression Écrite">
                                    <img src="{{ asset('images/ecrite.png') }}" width="40" class="mb-2"
                                        alt="Écriture" loading="lazy">
                                    <h6 class="mb-0">Expression Écrite</h6>
                                </a>
                            </div>
                            <div class="col-6 col-md-6">
                                <a href="#"
                                    class="skill-card d-block p-3 rounded text-center text-decoration-none bg-info text-white start-test-btn"
                                    data-test-type="expression_orale" data-test-name="Expression Orale">
                                    <img src="{{ asset('images/orale.png') }}" width="40" class="mb-2"
                                        alt="Orale" loading="lazy">
                                    <h6 class="mb-0">Expression Orale</h6>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <button class="btn btn-warning rounded-circle" id="btnMessage"
        style="position: fixed; bottom: 20px; right: 20px; z-index: 999;">
        <i class="fas fa-comments"></i>
    </button>

    <div class="modal fade" id="messageModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Envoyer un message à l’équipe</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <textarea name="contenu" class="form-control" rows="4" placeholder="Votre message..." required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('btnMessage').addEventListener('click', function() {
            var modal = new bootstrap.Modal(document.getElementById('messageModal'));
            modal.show();
        });
    </script>


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

        .btn-level {
            width: 120px;
            height: 45px;
            border-radius: 8px;
            font-size: 0.85rem;
        }

        @media (max-width: 991.98px) {
            .col-lg-3 .card-body .row {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .col-lg-3 .card-body .row .col-6 {
                width: 100%;
                text-align: center;
            }

            .col-lg-3 .card-body .row .col-6:first-child {
                margin-bottom: 1rem;
            }
        }
    </style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ------------------------------------------
    // NOUVELLE LOGIQUE AUDIO (MP3 au lieu de TTS)
    // ------------------------------------------
    const audioPaths = {
        // ASSUREZ-VOUS QUE CES CHEMINS SONT VALIDES DANS VOTRE PROJET LARAVEL (e.g. dans /public/audios/)
        comprehension_ecrite: '{{ asset('sounds/compréhensionEcriteDashbord.mp3') }}',
        comprehension_orale: '{{ asset('sounds/compréhensionOralDashbord.mp3') }}',
        expression_ecrite: '{{ asset('sounds/expressionEcriteDashboard.mp3') }}',
        expression_orale: '{{ asset('sounds/expressionOralDashboard.mp3') }}'
    };
    
    let currentAudioElement = null;

    const stopAudio = () => {
        if (currentAudioElement) {
            currentAudioElement.pause();
            currentAudioElement.currentTime = 0;
            currentAudioElement.remove(); // Suppression de l'élément du DOM
            currentAudioElement = null;
        }
    };

    // Stoppe l'audio en cas de navigation ou fermeture
    window.addEventListener('beforeunload', stopAudio);
    // ------------------------------------------


    /* ======================================================
      1️⃣ Popup d’accueil personnalisé
    ====================================================== */
    const userName = @json(Auth::user()->name ?? 'Cher utilisateur');

    const testsDisponibles = [
        { nom: "Compréhension Écrite", route: "{{ route('test.comprehension_ecrite') }}" },
        { nom: "Compréhension Orale", route: "{{ route('test.comprehension_orale') }}" },
        { nom: "Expression Écrite", route: "{{ route('test.expression_ecrite') }}" },
        { nom: "Expression Orale", route: "{{ route('test.expression_orale') }}" }
    ];

    const testPropose = testsDisponibles[Math.floor(Math.random() * testsDisponibles.length)];

    if (!localStorage.getItem(`popupShown_${userName}`)) {
        Swal.fire({
            title: `Bienvenue ${userName} 🎉`,
            html: `
                <p>Bonjour ${userName}, bienvenue sur notre plateforme !</p>
                <p>Vous pouvez suivre vos tests, continuer votre progression et nous contacter à tout moment.</p>
                <p>Nous vous proposons aujourd'hui de continuer avec le test : <b>${testPropose.nom}</b>.</p>
                <button id="btnCommencerTest" class="btn btn-primary mt-2">
                    Commencer ${testPropose.nom}
                </button>
            `,
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                document.getElementById("btnCommencerTest").addEventListener("click", () => {
                    Swal.close();
                    localStorage.setItem(`popupShown_${userName}`, "true");
                    window.location.href = testPropose.route;
                });
            }
        });
    }

    /* ======================================================
      2️⃣ Gestion des consignes par test (Audio MP3 + redirection)
    ====================================================== */
    const consignes = {
        comprehension_ecrite: `Bienvenue au test de Compréhension Écrite.\n\nDurée : 60 minutes\nNombre de questions : 39\n\nInstructions :\n1. Lisez attentivement chaque texte\n2. Répondez aux questions associées\n3. Vous ne pouvez pas revenir en arrière`,
        comprehension_orale: `Bienvenue au test de Compréhension Orale.\n\nDurée : 40 minutes\nNombre de questions : 39\n\nInstructions :\n1. Écoutez chaque extrait une seule fois\n2. Prenez des notes si nécessaire\n3. Répondez aux questions`,
        expression_ecrite: `Bienvenue au test d'Expression Écrite.\n\nDurée : 60 minutes\nNombre de taches : 3\n\nInstructions :\n1. Structurez clairement vos réponses\n2. Vérifiez votre grammaire et orthographe\n3. Respectez le nombre de mots demandé.`,
        expression_orale: `Bienvenue au test d'Expression Orale.\n\nDurée : 60 minutes\nNombre de taches : 3\n\nInstructions :\n1. Parlez clairement et distinctement\n2. Structurez vos idées\n3. Utilisez un vocabulaire varié`
    };

    document.querySelectorAll('.start-test-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();

            const testType = this.dataset.testType;
            const testName = this.dataset.testName;
            const consigneText = consignes[testType];
            const audioUrl = audioPaths[testType]; // Chemin du fichier MP3

            if (!consigneText || !audioUrl) return;

            // 1. Stoppe l'audio précédent (si un autre modal était ouvert)
            stopAudio(); 
            
            Swal.fire({
                title: `Consignes - ${testName}`,
                // 2. Ajout de l'élément <audio> dans le HTML du modal et masquage (style="display: none;")
                html: `
                    <div style="text-align:left; white-space:pre-line; margin-bottom: 20px;">${consigneText}</div>
                    <audio id="consignes-audio-player" src="${audioUrl}" style="display: none;"></audio>
                `,
                icon: 'info',
                confirmButtonText: 'Commencer le test',
                showCancelButton: true,
                cancelButtonText: 'Annuler',
                allowOutsideClick: false,
                width: '600px',
                
                didOpen: () => {
                    // 3. Récupère l'élément audio créé et tente de lancer la lecture
                    currentAudioElement = document.getElementById('consignes-audio-player');
                    if (currentAudioElement) {
                         currentAudioElement.play().catch(error => {
                            // Gestion des navigateurs qui bloquent l'autoplay
                            console.warn("La lecture automatique de l'audio a été bloquée. L'utilisateur doit interagir manuellement. ", error);
                        });
                    }
                },
                willClose: stopAudio // 4. Stoppe et supprime l'audio à la fermeture du modal
            }).then(result => {
                stopAudio();
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

    /* ======================================================
      3️⃣ et 4️⃣ Fonctions de gestion des notifications (inchangées)
    ====================================================== */
    // ... (Votre code pour la gestion des notifications reste ici)

    document.addEventListener('click', function (e) {
        const link = e.target.closest('.notification-link');
        if (!link) return;

        e.preventDefault();

        const url = link.dataset.url;
        const li = link.closest('li');

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: '{}'
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) throw new Error('Erreur serveur');

            if (li) {
                li.style.transition = 'opacity .25s ease';
                li.style.opacity = '0';
                setTimeout(() => li.remove(), 250);
            }

            const badge = document.getElementById('notifCount');
            if (badge) {
                let n = parseInt(badge.textContent || '0', 10);
                n = Math.max(0, n - 1);
                badge.textContent = n;
                if (n === 0) badge.classList.add('d-none');
            }
        })
        .catch(err => console.error('Erreur notification:', err));
    });

    document.addEventListener('click', function (e) {
        const removeBtn = e.target.closest('.notif-remove');
        if (!removeBtn) return;

        e.stopPropagation();
        const notifId = removeBtn.dataset.id;
        const li = removeBtn.closest('li');

        fetch(`/user/notifications/${notifId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && li) {
                li.style.transition = 'opacity .25s ease';
                li.style.opacity = '0';
                setTimeout(() => li.remove(), 250);

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
    });
    
    /* ======================================================
      5️⃣ Informations sur les niveaux (inchangées)
    ====================================================== */
    window.showNiveauxInfo = function () {
       Swal.fire({
        title: 'Information sur les niveaux',
        html: `
            <div style="text-align:left;">
                <b>A1 (1-5 points)</b> : Niveau élémentaire débutant, compréhension très limitée, capacité à utiliser des phrases simples.<br><br>
                <b>A2 (1-15 points)</b> : Niveau élémentaire avancé, peut comprendre et utiliser des phrases fréquentes sur des sujets familiers.<br><br>
                <b>B1 (1-20 points)</b> : Niveau de base, utilisateur indépendant débutant, capable de communiquer dans des situations courantes.<br><br>
                <b>B2 (1-25 points)</b> : Niveau intermédiaire, peut discuter de sujets variés et comprendre des textes plus complexes.<br><br>
                <b>C1 (1-33 points)</b> : Niveau avancé, utilisateur expérimenté autonome, bonne compréhension des textes et dialogues complexes, capacité d'expression détaillée.<br><br>
                <b>C2 (1-39 points)</b> : Niveau très avancé, maîtrise proche du bilinguisme, capable de comprendre et produire des textes et discours très complexes.
            </div>
        `,
        icon: 'info',
        confirmButtonText: 'OK',
        confirmButtonColor: '#3085d6',
    });
    };


    /* ======================================================
      6️⃣ Boutons désactivés (inchangés)
    ====================================================== */
    document.querySelectorAll(".btn-level.disabled").forEach(btn => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Accès restreint',
                text: 'Vous devez avoir un abonnement actif pour accéder à cette section et voir vos niveaux détaillés.',
                icon: 'warning',
                showConfirmButton: true,
                confirmButtonText: "Voir les abonnements",
                showCancelButton: true,
                cancelButtonText: "Fermer",
                customClass: {
                    confirmButton: 'btn btn-warning px-4 py-2',
                    cancelButton: 'btn btn-outline-secondary px-4 py-2'
                },
                buttonsStyling: false
            }).then(result => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('client.paiement') }}";
                }
            });
        });
    });

});
</script>
@endsection