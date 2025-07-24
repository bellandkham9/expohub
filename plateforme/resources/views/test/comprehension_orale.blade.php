<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TCF Canada - Expression Écrite</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/expression_ecrite.css')
    <style>
        .test-container {
            background-color: white;
        }

        .chat-container {
            overflow-y: auto;
            padding: 15px;
            background-color: #F8F9FA;
            border-radius: 8px;
            height: 35vh;
            margin: 0 auto;
            justify-content: center;
            align-items: center;
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
            border-radius: 50%;
            font-weight: bold;
        }
    </style>
</head>

<body>
<div class="container py-2">
    <div class="test-container">
        <div class="p-4">
            <div class="d-flex flex-wrap justify-content-start gap-2 mb-4">
                @foreach($questions as $index => $q)
                <button class="btn btn-sm question-btn {{ $index == 0 ? 'btn-success' : 'btn-secondary' }}" data-index="{{ $index }}">
                    {{ $index }}
                </button>
                @endforeach
            </div>

            <div class="row g-2 justify-content-between">
                <div class="col-md-4 text-center"><h4 id="timer">60:00</h4></div>
                <div class="col-md-5 text-center"><h5>Compréhension Orale - TCF</h5></div>
                <div class="col-md-3">
                    <button class="btn btn-danger w-100" onclick="abandonnerTest()">
                        <i class="fas fa-times-circle me-2"></i> Abandonner
                    </button>
                </div>

                <script>
                    function abandonnerTest() {
                        if (confirm("Es-tu sûr de vouloir abandonner le test ?")) {
                            window.location.href = "/comprehension_orale/resultat";
                        }
                    }

                </script>
            </div>

            <div id="question-block" class="mt-4">
                {{-- Le contenu dynamique sera inséré ici --}}
                <div id="poster" class="chat-container text-center">
                    <img id="question-image" src="" class="img-fluid d-none" style="border-radius: 15px;" />
                    <p id="question-texte" class="fw-bold fs-5"></p>
                </div>

                <div class="text-center mb-4">
                    <audio id="audio-question" controls class="mt-3 w-50">
                        <source id="audio-source" src="" type="audio/mp3">
                        Votre navigateur ne supporte pas l'audio.
                    </audio>
                </div>

                <div class="row g-4 justify-content-center" id="reponses-container">
                    {{-- Réponses injectées dynamiquement --}}
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Audio feedback -->
<audio id="son-bonne-reponse" src="{{ asset('sounds/success.wav') }}"></audio>
<audio id="son-mauvaise-reponse" src="{{ asset('sounds/error.wav') }}"></audio>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        let questions = @json($questions);
        let currentQuestion = 0;
        let userId = {{ auth()->id() ?? 1 }};
        let responses = {};

        const audioCorrect = new Audio("{{ asset('sounds/success.wav') }}");
        const audioWrong = new Audio("{{ asset('sounds/error.wav') }}");

        const btnIndicators = document.querySelectorAll('.question-btn');
        const timerElement = document.querySelector('h4');
        let totalSeconds = 1 * 60;

        function updateTimer() {
            let minutes = Math.floor(totalSeconds / 60);
            let seconds = totalSeconds % 60;
            timerElement.textContent = `${String(minutes).padStart(2, '0')} : ${String(seconds).padStart(2, '0')}`;
            if (totalSeconds > 0) {
                totalSeconds--;
                setTimeout(updateTimer, 1000);
            } else {
                alert("Temps écoulé !");
                window.location.href = "/comprehension_orale/resultat";
            }
        }

        updateTimer();

        // Charger une question
        function chargerQuestion(index) {
            let q = questions[index];

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

            // Réponses
            const reponses = [
                { label: 'A', text: q.proposition_1, value: '1' },
                { label: 'B', text: q.proposition_2, value: '2' },
                { label: 'C', text: q.proposition_3, value: '3' },
                { label: 'D', text: q.proposition_4, value: '4' },
            ];

            const container = document.getElementById('reponses-container');
            container.innerHTML = '';

            reponses.forEach(rep => {
                const col = document.createElement('div');
                col.className = 'col-md-5 btn';
                col.innerHTML = `
                    <div class="p-3 shadow-lg rounded bg-white text-center h-100 option" data-rep="${rep.value}">
                        <p class="mb-0">
                            <span class="fw-bold fs-4 me-2">${rep.label}</span> ${rep.text}
                        </p>
                    </div>
                `;
                col.querySelector('.option').addEventListener('click', () => verifierReponse(rep.value, q.id, index));
                container.appendChild(col);
            });

            document.getElementById('question-numero').innerText = index + 1;

            // Mettre à jour les indicateurs
            btnIndicators.forEach(btn => btn.classList.remove('btn-success'));
            if (btnIndicators[index]) {
                btnIndicators[index].classList.add('btn-success');
            }
        }

        function verifierReponse(reponse, questionId, questionIndex) {
            if (responses[questionIndex] !== undefined) return; // déjà répondu

            fetch('/comprehension_orale/repondre', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    reponse: reponse,
                    question_id: questionId,
                    user_id: userId
                })
            }).then(res => res.json())
            .then(data => {
                responses[questionIndex] = reponse;

                if (data.correct) {
                    audioCorrect.play();
                    btnIndicators[questionIndex].classList.remove('btn-secondary');
                    btnIndicators[questionIndex].classList.add('btn-success');
                } else {
                    audioWrong.play();
                    btnIndicators[questionIndex].classList.remove('btn-secondary');
                    btnIndicators[questionIndex].classList.add('btn-danger');
                }

                setTimeout(() => {
                    currentQuestion++;
                    if (currentQuestion < questions.length) {
                        chargerQuestion(currentQuestion);
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
                currentQuestion = index;
                chargerQuestion(currentQuestion);
            });
        });

        // Bouton abandonner
        document.getElementById('btn-abonne')?.addEventListener('click', () => {
            if (confirm("Voulez-vous vraiment abandonner le test ?")) {
                location.reload();
            }
        });

        // Chargement initial
        chargerQuestion(currentQuestion);
    });
</script>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
