<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TCF Canada - Comprehension Écrite</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/expression_ecrite.css', 'resources/js/comprehension_ecrite.js'])

    <style>
        .question-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            font-weight: bold;
            box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }
        .btn-success{
            background-color: #224194;
            border: none;
            color: white;
        }
        .btn-secondary{
            background-color: #FEF8E7;
            border: none;
            color: black;
        }

        .chat-container {
            overflow-y: auto;
            background-color: #F8F9FA;
            border-radius: 8px;
            padding: 10px;
            height: 30vh;
        }
        .main-content{
            padding: 10px;
            background-color: #F8F9FA;
        }

        .test-container {
            background-color: white;
        }

        .situation-box {
            background-color: #FEF8E7;
            width: 500px;
            height:25vh;
            margin: 0 auto;
            padding: 20px;
            box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }
        #inpu-group{
            padding: 15px;
            border-radius: 15px;
            box-shadow: 3px 3px 3px 3px rgba(23, 22, 22, 0.2);
        }
        .choix-reponse{
            border-radius: 15px;
            box-shadow: 2px 2px 2px 2px rgba(23, 22, 22, 0.2);
        }

    </style>
</head>

<body>
    <div class="container py-2">
        <div class="test-container p-4">
                  <!-- Titre + Timer + Bouton abandon -->
            <div class="row justify-between text-center mb-4">
                <div class="col-md-2">
                    <h4 id="timer">60:00</h4>
                </div>
                <div class="col-md-8">
                    <h3>TCF CANADA - Comprehension écrite</h3>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger w-100" onclick="abandonnerTest()">
                        <i class="fas fa-times-circle me-2"></i> Abandonner
                    </button>
                </div>

                <script>
                    function abandonnerTest() {
                        if (confirm("Es-tu sûr de vouloir abandonner le test ?")) {
                            enregistrerResultatFinalEtRediriger();
                            
                        }
                    }

                </script>

            </div>
            <div class="main-content">
         
              <!-- Marqueurs 1 à 39 -->
                <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
                @foreach($questions as $index => $q)
                <button class="btn btn-sm question-btn {{ $index == 0 ? 'btn-success' : 'btn-secondary' }}" data-index="{{ $index }}">
                    {{ $q->numero }}
                </button>
                @endforeach
            </div>

           

            <!-- Situation -->
            <div class="chat-container mb-4">
                <div class="situation-box rounded text-justify">
                    <p class="mb-0 situation-text">{{ $questions[0]->situation }}</p>
                </div>
            </div>
            </div>

            <!-- Question et propositions -->
            <div id="inpu-group" class="container my-2">
                <div class="text-center mb-2">
                    <h3 class="fw-bold question-text">{{ $questions[0]->question }}</h3>
                </div>

                <div class="row g-4 justify-content-center mt-3" id="reponses">
                    @foreach (['A', 'B', 'C', 'D'] as $key => $lettre)
                    <div class="col-md-5">
                        <button class="btn w-100 p-3  rounded bg-white text-start text-dark choix-reponse" data-reponse="{{ $lettre }}" data-index="0">
                            <span class="fw-bold fs-4 me-2">{{ $lettre }}</span>
                            {{ $questions[0]->propositions[$key] ?? 'Proposition' }}
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="testType" value="{{ $test_type }}">

    <!-- Audio -->
    <audio id="audio-success" src="/sounds/success.wav" preload="auto"></audio>
    <audio id="audio-fail" src="/sounds/error.wav" preload="auto"></audio>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script Laravel vers JS -->

    <script>
        document.addEventListener("keydown", function(e) {
            if ((e.key === "F5") || (e.ctrlKey && e.key === "r")) {
                e.preventDefault();
                alert("⛔ Veuillez terminer le test avant de recharger la page.");
            }
        });
        const questions = @json($questions);
        const csrfToken = "{{ csrf_token() }}";


        function enregistrerResultatFinalEtRediriger() {
    fetch('/comprehension_ecrite/resultat/final', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log("Résultat enregistré :", data);
        // Redirection vers la page de résultats après enregistrement
        window.location.href = '/comprehension_ecrite/resultat';
    })
    .catch(error => {
        console.error('Erreur enregistrement résultat final :', error);
    });
}


    </script>
</body>
</html>

