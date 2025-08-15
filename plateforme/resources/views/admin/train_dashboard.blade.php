<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/admin-gestion-user.css'])

    <style>
        .text-gradient {
            background: linear-gradient(45deg, #4e54c8, #8f94fb);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .generation-card {
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
        }

        .generation-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            padding: 1.25rem 1.5rem;
        }

        .stat-card {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            color: white;
            margin-left: 1rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .stat-card i {
            margin-right: 0.5rem;
        }

        .bg-light-primary {
            background-color: rgba(13, 110, 253, 0.1);
        }

        .bg-light-success {
            background-color: rgba(25, 135, 84, 0.1);
        }

        .bg-light-info {
            background-color: rgba(13, 202, 240, 0.1);
        }

        .bg-light-warning {
            background-color: rgba(255, 193, 7, 0.1);
        }

        .recent-item {
            transition: transform 0.2s;
        }

        .recent-item:hover {
            transform: translateX(5px);
        }

        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
        }

        .nav-tabs .nav-link.active {
            color: #4e54c8;
            border-bottom: 3px solid #4e54c8;
            background: transparent;
        }

        .generate-btn {
            position: relative;
            overflow: hidden;
        }

        .generate-btn::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(to bottom right,
                    rgba(255, 255, 255, 0.3),
                    rgba(255, 255, 255, 0));
            transform: rotate(30deg);
            transition: all 0.3s;
        }

        .generate-btn:hover::after {
            left: 100%;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .generation-card:hover .card-header i {
            animation: pulse 1.5s infinite;
        }

    </style>

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 sidebar p-3">
                @include('admin.partials.side_bar')
            </div>

            <div class="col-md-9 col-lg-10 main-content">

                <div class="container-fluid px-4">
                    <!-- Dashboard Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="dashboard-stats mt-4">
                            <div class="stat-card bg-primary">
                                <i class="fas fa-book-open"></i>
                                <span>{{ $stats['total_questions'] }} Questions</span>
                            </div>
                            <div class="stat-card bg-success">
                                <i class="fas fa-microphone-alt"></i>
                                <span>{{ $stats['oral_questions'] }} Orale</span>
                            </div>
                            <div class="stat-card bg-info">
                                <i class="fas fa-pen-fancy"></i>
                                <span>{{ $stats['ecrite_tasks'] }} Écrite</span>
                            </div>
                        </div>
                    </div>

                    <!-- Generation Cards -->
                    <div class="row g-4">


                        <!-- Compréhension Écrite -->
                        <div class="col-lg-6">
                            <div class="card generation-card h-100 border-start border-5 border-primary">
                                <div class="card-header bg-light-primary d-flex align-items-center">
                                    <i class="fas fa-book-reader text-primary me-3 fs-3"></i>
                                    <h3 class="mb-0">Compréhension Écrite</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('train.ce.generate') }}" class="generation-form">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-question-circle me-2"></i>Nombre de questions
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                                <input type="number" name="nb_questions" class="form-control" value="5" min="1" max="20" required>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary w-100 generate-btn" id="btnGenerateEcrite">
                                            <i class="fas fa-magic me-2"></i>Générer des questions
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Compréhension Orale -->
                        <div class="col-lg-6">
                            <div class="card generation-card h-100 border-start border-5 border-success">
                                <div class="card-header bg-light-success d-flex align-items-center">
                                    <i class="fas fa-microphone-alt text-success me-3 fs-3"></i>
                                    <h3 class="mb-0">Compréhension Orale</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('train.co.generate') }}" class="generation-form">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-question-circle me-2"></i>Nombre de questions
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                                <input type="number" name="nb_questions" class="form-control" value="1" min="1" max="5" required>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-success w-100 generate-btn" id="btnGenerateOrale">
                                            <i class="fas fa-wave-square me-2"></i>Générer des audios
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Expression Écrite -->
                        <div class="col-lg-6">
                            <div class="card generation-card h-100 border-start border-5 border-info">
                                <div class="card-header bg-light-info d-flex align-items-center">
                                    <i class="fas fa-pen-fancy text-info me-3 fs-3"></i>
                                    <h3 class="mb-0">Expression Écrite</h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('train.ee.generate') }}" method="POST" class="generation-form">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-tasks me-2"></i>Nombre de tâches
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                                <input type="number" name="nb_taches" class="form-control" value="1" min="1" max="10" required>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-info w-100 generate-btn" id="btnGenerateEcrit">
                                            <i class="fas fa-keyboard me-2"></i>Générer des tâches
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Expression Orale -->
                        <div class="col-lg-6">
                            <div class="card generation-card h-100 border-start border-5 border-warning">
                                <div class="card-header bg-light-warning d-flex align-items-center">
                                    <i class="fas fa-comment-dots text-warning me-3 fs-3"></i>
                                    <h3 class="mb-0">Expression Orale</h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('train.eo.generate') }}" method="POST" class="generation-form">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-tasks me-2"></i>Nombre de tâches
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                                <input type="number" name="nb_taches" class="form-control" value="1" min="1" max="10" required>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-warning w-100 generate-btn" id="btnGenerateOral">
                                            <i class="fas fa-microphone me-2"></i>Générer des tâches
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Content Section -->
                    <div class="card mt-4 shadow-sm">
                        <div class="card-header bg-light d-flex align-items-center">
                            <i class="fas fa-history text-muted me-3 fs-4"></i>
                            <h3 class="mb-0">Contenu Récemment Généré</h3>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="recentContentTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="ecrite-tab" data-bs-toggle="tab" data-bs-target="#ecrite" type="button" role="tab">
                                        <i class="fas fa-book-reader me-2"></i>Écrite
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="orale-tab" data-bs-toggle="tab" data-bs-target="#orale" type="button" role="tab">
                                        <i class="fas fa-microphone-alt me-2"></i>Orale
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="expression-ecrite-tab" data-bs-toggle="tab" data-bs-target="#expression-ecrite" type="button" role="tab">
                                        <i class="fas fa-pen-fancy me-2"></i>Expression Écrite
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="expression-orale-tab" data-bs-toggle="tab" data-bs-target="#expression-orale" type="button" role="tab">
                                        <i class="fas fa-comment-dots me-2"></i>Expression Orale
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content p-3 border border-top-0 rounded-bottom" id="recentContentTabContent">
                                <div class="tab-pane fade show active" id="ecrite" role="tabpanel">
                                    @foreach($recent_ecrite as $q)
                                    <div class="recent-item mb-3 p-3 bg-light rounded">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="fw-bold">{{ $q->question }}</h6>
                                            <span class="bg-primary" style="padding: 10px; color: white; border-radius: 15px; box-shadow: 2px 2px 2px 2px gainsboro;">{{ $q->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-muted small mb-0">{{ $q->situation }}</p>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="tab-pane fade" id="orale" role="tabpanel">
                                    @foreach($recent_orale as $q)
                                    <div class="recent-item mb-3 p-3 bg-light rounded">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="fw-bold">{{ Str::limit(strip_tags($q->question_audio ?? ''), 50, '...') }}</h6>
                                            <span class="bg-success" style="padding: 10px; color: white; border-radius: 15px; box-shadow: 2px 2px 2px 2px gainsboro;">{{ $q->created_at->diffForHumans() }}</span>
                                          
                                        </div>
                                        <audio controls src="{{ asset('storage/' . $q->question_audio) }}" class="w-100 mt-2"></audio>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="tab-pane fade" id="expression-ecrite" role="tabpanel">
                                    @foreach($recent_expression_ecrite as $t)
                                    <div class="recent-item mb-3 p-3 bg-light rounded">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="fw-bold">Tâche #{{ $t->numero_tache }}</h6>
                                             <span class="bg-info" style="padding: 10px; color: white; border-radius: 15px; box-shadow: 2px 2px 2px 2px gainsboro;">{{ $t->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="mb-1"><strong>Contexte:</strong> {{ Str::limit($t->contexte_texte, 70) }}</p>
                                        <p class="mb-0"><strong>Consigne:</strong> {{ Str::limit($t->consigne, 70) }}</p>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="tab-pane fade" id="expression-orale" role="tabpanel">
                                    @foreach($recent_expression_orale as $t)
                                    <div class="recent-item mb-3 p-3 bg-light rounded">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="fw-bold">Tâche #{{ $t->numero }}</h6>
                                            <span class="bg-info" style="padding: 10px; color: white; border-radius: 15px; box-shadow: 2px 2px 2px 2px gainsboro;">{{ $t->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="mb-1"><strong>Type:</strong> {{ $t->type }}</p>
                                        <p class="mb-1"><strong>Contexte:</strong> {{ Str::limit($t->contexte, 50) }}</p>
                                        @if($t->consigne_audio)
                                        <audio controls src="{{ asset('storage/' . $t->consigne_audio) }}" class="w-100 mt-1"></audio>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>



    <script>
        // Handle success/error messages with beautiful SweetAlert dialogs
        document.addEventListener("DOMContentLoaded", function() {
            // Compréhension Écrite success
            @if(session('success') && session('generated_section') === 'comprehension_ecrite')

            Swal.fire({
                icon: 'success'
                , title: 'Questions générées avec succès!'
                , html: `{!! session('success') !!}`
                , showConfirmButton: true
                , confirmButtonText: "<i class='fas fa-list-ol me-2'></i>Voir les questions"
                , showCancelButton: true
                , cancelButtonText: "<i class='fas fa-times me-2'></i>Fermer"
                , background: '#f8f9fa'
                , backdrop: `
            rgba(0,123,255,0.4)
            url("/images/confetti.gif")
            center top
            no-repeat
        `
                , customClass: {
                    confirmButton: 'btn btn-primary px-4 py-2'
                    , cancelButton: 'btn btn-outline-secondary px-4 py-2'
                }
                , buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    let questions = {
                        !!json_encode(session('generated_questions') ? ? []) !!
                    };
                    if (questions.length > 0) {
                        let htmlContent = '<div class="text-start" style="max-height: 400px; overflow-y: auto;">';
                        questions.forEach((q, i) => {
                            htmlContent += `
                        <div class="mb-3 p-3 bg-light-primary rounded">
                            <h6 class="fw-bold"><i class="fas fa-question-circle text-primary me-2"></i>Question ${i+1}</h6>
                            <p class="mb-1">${q.question}</p>
                            <p class="text-muted small mb-0">${q.situation || ''}</p>
                        </div>
                    `;
                        });
                        htmlContent += '</div>';

                        Swal.fire({
                            title: '<i class="fas fa-book-reader text-primary me-2"></i>Questions Générées'
                            , html: htmlContent
                            , width: 800
                            , background: '#f8f9fa'
                            , customClass: {
                                popup: 'rounded-3'
                            }
                        });
                    }
                }
            });
            @elseif(session('error') && session('generated_section') === 'comprehension_ecrite')
            showErrorAlert('{!! session('
                error ') !!}');
            @endif

            // Compréhension Orale success
            @if(session('success') && session('generated_section') === 'comprehension_orale')
            Swal.fire({
                icon: 'success'
                , title: 'Audios générés avec succès!'
                , html: `{!! session('success') !!}`
                , showConfirmButton: true
                , confirmButtonText: "<i class='fas fa-headphones me-2'></i>Écouter"
                , showCancelButton: true
                , cancelButtonText: "<i class='fas fa-times me-2'></i>Fermer"
                , background: '#f8f9fa'
                , backdrop: `
            rgba(40,167,69,0.4)
            url("/images/audio-wave.gif")
            center top
            no-repeat
        `
                , customClass: {
                    confirmButton: 'btn btn-success px-4 py-2'
                    , cancelButton: 'btn btn-outline-secondary px-4 py-2'
                }
                , buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    let audios = {
                        !!json_encode(session('generated_audios') ? ? []) !!
                    };
                    if (audios.length > 0) {
                        let htmlContent = '<div class="text-start" style="max-height: 400px; overflow-y: auto;">';
                        audios.forEach((a, i) => {
                            htmlContent += `
                        <div class="mb-3 p-3 bg-light-success rounded">
                            <h6 class="fw-bold"><i class="fas fa-volume-up text-success me-2"></i>Audio ${i+1}</h6>
                            <p class="mb-2">${a.contexte_texte || ''}</p>
                            <audio controls src="${a.question_audio}" class="w-100"></audio>
                        </div>
                    `;
                        });
                        htmlContent += '</div>';

                        Swal.fire({
                            title: '<i class="fas fa-microphone-alt text-success me-2"></i>Audios Générés'
                            , html: htmlContent
                            , width: 800
                            , background: '#f8f9fa'
                            , customClass: {
                                popup: 'rounded-3'
                            }
                        });
                    }
                }
            });
            @elseif(session('error') && session('generated_section') === 'comprehension_orale')
            showErrorAlert('{!! session('
                error ') !!}');
            @endif

            // Expression Écrite success
            @if(session('success') && session('generated_section') === 'expression_ecrite')
            Swal.fire({
                icon: 'success'
                , title: 'Tâches générées avec succès!'
                , html: `{!! session('success') !!}`
                , showConfirmButton: true
                , confirmButtonText: "<i class='fas fa-eye me-2'></i>Voir les tâches"
                , showCancelButton: true
                , cancelButtonText: "<i class='fas fa-times me-2'></i>Fermer"
                , background: '#f8f9fa'
                , backdrop: `
            rgba(23,162,184,0.4)
            url("/images/writing.gif")
            center top
            no-repeat
        `
                , customClass: {
                    confirmButton: 'btn btn-info px-4 py-2'
                    , cancelButton: 'btn btn-outline-secondary px-4 py-2'
                }
                , buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    let taches = {
                        !!json_encode(session('generated_taches') ? ? []) !!
                    };
                    if (taches.length > 0) {
                        let htmlContent = '<div class="text-start" style="max-height: 400px; overflow-y: auto;">';
                        taches.forEach((t, i) => {
                            htmlContent += `
                        <div class="mb-3 p-3 bg-light-info rounded">
                            <h6 class="fw-bold"><i class="fas fa-pen-fancy text-info me-2"></i>Tâche ${i+1}</h6>
                            <p class="mb-1"><strong>Numéro:</strong> ${t.numero_tache}</p>
                            <p class="mb-1"><strong>Contexte:</strong> ${t.contexte_texte}</p>
                            <p class="mb-0"><strong>Consigne:</strong> ${t.consigne}</p>
                        </div>
                    `;
                        });
                        htmlContent += '</div>';

                        Swal.fire({
                            title: '<i class="fas fa-keyboard text-info me-2"></i>Tâches Générées'
                            , html: htmlContent
                            , width: 800
                            , background: '#f8f9fa'
                            , customClass: {
                                popup: 'rounded-3'
                            }
                        });
                    }
                }
            });
            @elseif(session('error') && session('generated_section') === 'expression_ecrite')
            showErrorAlert('{!! session('
                error ') !!}');
            @endif

            // Expression Orale success
            @if(session('success') && session('generated_section') === 'expression_orale')

            Swal.fire({
                icon: 'success'
                , title: 'Tâches générées avec succès!'
                , html: `{!! session('success') !!}`
                , showConfirmButton: true
                , confirmButtonText: "<i class='fas fa-play-circle me-2'></i>Écouter"
                , showCancelButton: true
                , cancelButtonText: "<i class='fas fa-times me-2'></i>Fermer"
                , background: '#f8f9fa'
                , backdrop: `
            rgba(255,193,7,0.4)
            url("/images/speaking.gif")
            center top
            no-repeat
        `
                , customClass: {
                    confirmButton: 'btn btn-warning px-4 py-2'
                    , cancelButton: 'btn btn-outline-secondary px-4 py-2'
                }
                , buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    let taches = {
                        !!json_encode(session('generated_taches_orales') ? ? []) !!
                    };
                    if (taches.length > 0) {
                        let htmlContent = '<div class="text-start" style="max-height: 400px; overflow-y: auto;">';
                        taches.forEach((t, i) => {
                            htmlContent += `
                        <div class="mb-3 p-3 bg-light-warning rounded">
                            <h6 class="fw-bold"><i class="fas fa-comment-dots text-warning me-2"></i>Tâche ${i+1}</h6>
                            <p class="mb-1"><strong>Type:</strong> ${t.type}</p>
                            <p class="mb-1"><strong>Contexte:</strong> ${t.contexte}</p>
                            <p class="mb-2"><strong>Consigne:</strong> ${t.consigne}</p>
                            ${t.consigne_audio 
    ? `<audio controls src="/storage/${t.consigne_audio}" class="w-100"></audio>` 
    : '<p class="text-muted">Aucun audio généré</p>'
}

                        </div>
                    `;
                        });
                        htmlContent += '</div>';

                        Swal.fire({
                            title: '<i class="fas fa-microphone text-warning me-2"></i>Tâches Générées'
                            , html: htmlContent
                            , width: 800
                            , background: '#f8f9fa'
                            , customClass: {
                                popup: 'rounded-3'
                            }
                        });
                    }
                }
            });
            @elseif(session('error') && session('generated_section') === 'expression_orale')
            showErrorAlert('{!! session('
                error ') !!}');
            @endif

            // Fonction générique pour ajouter le loader et soumettre le formulaire
            document.querySelectorAll('.generate-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault(); // bloque le submit normal
                    const icon = this.querySelector('i');
                    const originalText = this.innerHTML;
                    const form = this.closest('form');

                    // Animation loader
                    this.disabled = true;
                    if (icon) icon.className = 'fas fa-spinner fa-spin me-2';
                    this.innerHTML = this.innerHTML.replace(/Générer.*/, 'Génération en cours...');

                    // Submit du formulaire
                    form.submit();

                    // Revert après 5 secondes (au cas où)
                    setTimeout(() => {
                        this.disabled = false;
                        if (icon) icon.className = originalText.match(/fa-[^\s]+/)[0] + ' me-2';
                        this.innerHTML = originalText;
                    }, 5000);
                });
            });
        });

        function showErrorAlert(message) {
            Swal.fire({
                icon: 'error'
                , title: 'Oups, quelque chose a mal tourné!'
                , html: message
                , confirmButtonText: "<i class='fas fa-redo me-2'></i>Réessayer"
                , showCancelButton: true
                , cancelButtonText: "<i class='fas fa-times me-2'></i>Fermer"
                , background: '#f8f9fa'
                , backdrop: `
            rgba(220,53,69,0.4)
            url("/images/error.gif")
            center top
            no-repeat
        `
                , customClass: {
                    confirmButton: 'btn btn-danger px-4 py-2'
                    , cancelButton: 'btn btn-outline-secondary px-4 py-2'
                }
                , buttonsStyling: false
            });
        }

    </script>

    <script>
        // Script pour gérer l'affichage du menu mobile
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.querySelector('.mobile-menu-btn');
            const sidebar = document.querySelector('.sidebar');

            menuBtn.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });

            // Ferme le menu quand on clique à l'extérieur
            document.addEventListener('click', function(event) {
                if (!sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            });
        });

    </script>

    <!-- Font Awesome -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>
