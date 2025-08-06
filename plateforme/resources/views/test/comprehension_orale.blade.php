<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TCF Canada - Comprehension Orale</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/expression_ecrite.css','resources/css/comprehension_ecrite.css'])
    <style>
        .test-container {
            background-color: white;
        }

        .chat-container {
            overflow-y: auto;
            padding: 15px;
            background-color: #F8F9FA;
            border-radius: 8px;
            height: 30vh;
            margin: 0 auto;
            justify-content: center;
            align-items: center;
        }

        #main-content {
            padding: 15px;
            background-color: #F8F9FA;
            border-radius: 20px;
        }

        .message {
            margin-bottom: 15px;
            max-width: 80%;
        }

        .user-message {
            margin: 0 auto;
            background-color: white;
            color: black;
            border-radius: 15px 15px 0 15px;
            padding: 10px 15px;
            display: flex;
            width: 30%;
            align-items: center;
            box-shadow: 1px 1px 1px rgb(193, 192, 192)
        }

        .btn-success {
            background-color: #224194;
            border: none;
            color: white;
        }

        .btn-success:hover {
            background-color: #224194;
            border: none;
            color: white;
        }

        .btn-secondary {
            background-color: #FEF8E7;
            border: none;
            color: black;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin: 5px;
        }

        .bot-message {
            background-color: #FEF8E7;
            border-radius: 15px 15px 15px 0;
            padding: 10px 15px;
            box-shadow: 1px 1px 1px rgb(193, 192, 192);
            margin: 8px;
        }

        #responses {
            border-radius: 15px;
            padding: 10px;
            box-shadow: 2px 2px 2px 2px rgb(193, 192, 192);
            margin: 8px;
            height: 35vh;
        }


        #btn-abonne {
            background-color: #BB1C1E;
            border-radius: 5px;
            color: white;
            padding: 10px;
            font-weight: bold;
            border: none;
            padding-left: 20px;
            padding-right: 20px;
        }

        .status-active {
            background-color: #d4edda;
            color: #155724;
        }

        .status-abandoned {
            background-color: #f8d7da;
            color: #721c24;
        }

        #inpu-group {
            border-radius: 10px;
            padding: 30px;
            box-shadow: 2px 2px 2px 2px gainsboro
        }

        #poster {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .question-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            font-weight: bold;
            box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }

        .option {
            box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.2);
        }

        .option:hover {
            background-color: #224194;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .fade-out {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

    </style>
</head>

<body>
    <div class="container py-2">
        <div class="test-container">
            <div class="p-2">
                <div class="row g-2 justify-content-between">
                    <div class="col-md-2 text-center">
                        <h4 id="timer">60:00</h4>
                    </div>
                    <div class="col-md-8 text-center">
                        <h5>Compréhension Orale - TCF</h5>
                    </div>
                    <div class="col-md-2">
                        <button id="btn-abandonner" class="btn btn-danger w-100" onclick="abandonnerTest()">
                            <i class="fas fa-times-circle me-2"></i> Abandonner
                        </button>
                    </div>
                </div>



                <div class="mt-2" id="main-content">
                    <div class="d-flex flex-wrap justify-content-start gap-2 mb-4 mt-4">
                        @foreach ($questions as $index => $q)
                        <button class="btn btn-sm question-btn {{ $index == 0 ? 'btn-primary' : 'btn-secondary' }}" data-index="{{ $index }}">
                            {{ $index + 1 }}
                        </button>
                        @endforeach
                    </div>

                    <div id="question-block" class="mt-4">
                        <div id="poster" class="chat-container text-center">
                            <img id="question-image" src="" class="img-fluid d-none" style="border-radius: 15px;" />
                            <p id="question-texte" class="fw-bold fs-5"></p>
                        </div>
                    </div>
                </div>

                <div id="responses">
                    <div class="text-center mb-4">
                        <audio id="audio-question" controls class="mt-3 w-50">
                            <source id="audio-source" src="" type="audio/mp3">
                            Votre navigateur ne supporte pas l'audio.
                        </audio>

                    </div>

                    <div class="row gx-2 gy-2 justify-content-center text-center" id="reponses-container">
                        {{-- Réponses injectées dynamiquement --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback audio -->
    <audio id="son-bonne-reponse" src="{{ asset('sounds/success.wav') }}"></audio>
    <audio id="son-mauvaise-reponse" src="{{ asset('sounds/error.wav') }}"></audio>

    @if (!auth()->check())
    <script>
        alert("Tu dois être connecté pour faire ce test.");
        window.location.href = "/connexion";

    </script>
    @endif

    <script>
         function abandonnerTest() {
                if (confirm("Es-tu sûr de vouloir abandonner le test ?")) {
                    enregistrerResultatFinalEtRediriger()
                }
            }

            function enregistrerResultatFinalEtRediriger() {
                fetch('/comprehension_orale/resultat/final', {
                        method: 'POST'
                        , headers: {
                            'Content-Type': 'application/json'
                            , 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log("Résultat enregistré :", data);
                        // Redirection vers la page de résultats après enregistrement
                        window.location.href = '/comprehension_orale/resultat';
                    })
                    .catch(error => {
                        console.error('Erreur enregistrement résultat final :', error);
                    });
            }


        document.addEventListener('DOMContentLoaded', () => {
            let questions = @json($questions);
            let currentQuestion = 0;
            let userId = {{ auth()->id() ?? 1 }};

            let responses = {};
            let questionTimer; // Timer individuel pour chaque question
            let questionTimeLimit = 60; // 2 minutes (en secondes)
            let questionTimeLeft = questionTimeLimit;

            const audioCorrect = new Audio("{{ asset('sounds/success.wav') }}");
            const audioWrong = new Audio("{{ asset('sounds/error.wav') }}");

            const btnIndicators = document.querySelectorAll('.question-btn');
            const timerElement = document.querySelector('h4');
            let totalSeconds = 60 * 60;

            function updateTimer() {
                let minutes = Math.floor(totalSeconds / 60);
                let seconds = totalSeconds % 60;
                timerElement.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

            }

            updateTimer();
            let timerInterval = setInterval(() => {
                if (totalSeconds <= 0) {
                    clearInterval(timerInterval);
                    alert("Temps écoulé !");
                    enregistrerResultatFinalEtRediriger()
                } else {
                    totalSeconds--;
                    updateTimer();
                }
            }, 1000);

           

            function demarrerQuestionTimer(questionId, index) {
                clearInterval(questionTimer); // Réinitialise le timer précédent
                questionTimeLeft = questionTimeLimit;

                questionTimer = setInterval(() => {
                    questionTimeLeft--;

                    if (questionTimeLeft <= 0) {
                        clearInterval(questionTimer);

                        // Marque comme réponse incorrecte (faux)
                        verifierReponse('0', questionId, index); // '0' ou tout autre code pour dire "non répondu"
                    }
                }, 1000);
            }


            function chargerQuestion(index) {
                let q = questions[index];
                currentQuestion = index;

                // Contexte
                if (q.contexte_texte.endsWith('.jpg') || q.contexte_texte.endsWith('.png')) {
                    document.getElementById('question-image').src = '/storage/' + q.contexte_texte;
                    document.getElementById('question-image').classList.remove('d-none');
                    document.getElementById('question-texte').classList.add('d-none');
                } else {
                    document.getElementById('question-texte').innerText = q.contexte_texte;
                    document.getElementById('question-image').classList.add('d-none');
                    document.getElementById('question-texte').classList.remove('d-none');
                }

                // Audio
                document.getElementById('audio-source').src = '/storage/' + q.question_audio;
                document.getElementById('audio-question').load();

                const audioElement = document.getElementById('audio-question');

                // Lecture automatique
                audioElement.play().catch((e) => {
                    console.warn("Lecture bloquée :", e);
                });

                // Quand l'audio se termine : on désactive les contrôles
                audioElement.onended = () => {
                    audioElement.controls = true; // Laisse visible
                    audioElement.setAttribute("disabled", "true"); // Ne marche pas sur <audio> directement
                    audioElement.style.pointerEvents = "none"; // Désactive les clics
                    audioElement.style.opacity = "0.6"; // Donne un effet visuel de "grisé"
                };


                // Réponses
                const reponses = [{
                        label: 'A'
                        , text: q.proposition_1
                        , value: '1'
                    }
                    , {
                        label: 'B'
                        , text: q.proposition_2
                        , value: '2'
                    }
                    , {
                        label: 'C'
                        , text: q.proposition_3
                        , value: '3'
                    }
                    , {
                        label: 'D'
                        , text: q.proposition_4
                        , value: '4'
                    }
                ];

                const container = document.getElementById('reponses-container');
                container.innerHTML = '';

                reponses.forEach(rep => {
                    const col = document.createElement('div');
                    col.className = 'col-md-5';

                    col.innerHTML = `
                        <div class="p-3 rounded option w-100 border" style="cursor: pointer;" data-rep="${rep.value}">
                            <p class="mb-0">
                                <span class="fw-bold fs-4 me-2">${rep.label}</span> ${rep.text}
                            </p>
                        </div>
                    `;


                    col.querySelector('.option').addEventListener('click', () => {
                        verifierReponse(rep.value, q.id, index);
                    });

                    container.appendChild(col);
                });

                // Mettre à jour les indicateurs
                btnIndicators.forEach((btn, i) => {
                    btn.classList.remove('btn-primary', 'btn-success', 'btn-danger', 'btn-secondary');

                    if (i === index) {
                        btn.classList.add('btn-success');
                    } else {
                        btn.classList.add('btn-secondary');
                    }
                });

                // Démarre le timer de 2 min pour la question
                demarrerQuestionTimer(q.id, index);
            }

            function verifierReponse(reponse, questionId, questionIndex) {
                clearInterval(questionTimer); // Stoppe le timer dès qu'on a une réponse

                if (responses[questionIndex] !== undefined) return;

                fetch('/comprehension_orale/repondre', {
                        method: 'POST'
                        , headers: {
                            'Content-Type': 'application/json'
                            , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                        , body: JSON.stringify({
                            reponse: reponse
                            , question_id: questionId
                            , user_id: userId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        responses[questionIndex] = reponse;

                        setTimeout(() => {
                            if (questionIndex + 1 < questions.length) {
                                chargerQuestion(questionIndex + 1);
                            } else {
                                window.location.href = "/comprehension_orale/resultat";
                            }
                        }, 1000);
                    });
            }

            // Navigation manuelle
            btnIndicators.forEach(btn => {
                btn.addEventListener('click', () => {
                    const index = parseInt(btn.dataset.index);
                    chargerQuestion(index);
                });
            });

            // Chargement initial
            chargerQuestion(currentQuestion);
        });

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>


</html>
