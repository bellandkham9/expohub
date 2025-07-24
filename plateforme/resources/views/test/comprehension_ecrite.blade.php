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
            border-radius: 50%;
            font-weight: bold;
        }

        .chat-container {
            overflow-y: auto;
            background-color: #F8F9FA;
            border-radius: 8px;
            padding: 15px;
            height: 30vh;
        }

        .test-container {
            background-color: white;
        }

        .situation-box {
            background-color: #FEF8E7;
            width: 500px;
            height: auto;
            margin: 0 auto;
            padding: 20px;
            box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }

    </style>
</head>

<body>
    <div class="container py-2">
        <div class="test-container p-4">
            <!-- Marqueurs 1 à 39 -->
            <div class="d-flex flex-wrap justify-content-start gap-2 mb-4">
                @foreach($questions as $index => $q)
                <button class="btn btn-sm question-btn {{ $index == 0 ? 'btn-success' : 'btn-secondary' }}" data-index="{{ $index }}">
                    {{ $q->numero }}
                </button>
                @endforeach
            </div>

            <!-- Titre + Timer + Bouton abandon -->
            <div class="row text-center mb-4">
                <div class="col-md-4">
                    <h4 id="timer">60:00</h4>
                </div>
                <div class="col-md-5">
                    <h3>TCF CANADA - Comprehension écrite</h3>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-danger w-100" onclick="abandonnerTest()">
                        <i class="fas fa-times-circle me-2"></i> Abandonner
                    </button>
                </div>

                <script>
                    function abandonnerTest() {
                        if (confirm("Es-tu sûr de vouloir abandonner le test ?")) {
                            window.location.href = "/comprehension_ecrite/resultat";
                        }
                    }

                </script>

            </div>

            <!-- Situation -->
            <div class="chat-container mb-4">
                <div class="situation-box rounded text-center">
                    <p class="mb-0 situation-text">{{ $questions[0]->situation }}</p>
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
                        <button class="btn w-100 p-3 shadow-lg rounded bg-white text-start text-dark choix-reponse" data-reponse="{{ $lettre }}" data-index="0">
                            <span class="fw-bold fs-4 me-2">{{ $lettre }}</span>
                            {{ $questions[0]->propositions[$key] ?? 'Proposition' }}
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

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

    </script>
</body>
</html>






{{--
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
</head>

<body>
    <div class="container py-5">
        <div class="test-container">
            <!-- Chat Interface -->
            <div class="p-4">
                <div class="row g-2 gap-x-4 gap-y-4 justify-between">
                    <div class="col-md-4  d-flex justify-content-center my-3">
                        <h4>60 : 00</h4>
                    </div>
                    <div class="col-md-4  d-flex justify-content-center my-3">
                        <h3>TCF CANADA, Expression orale</h3>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center my-3">
                        <button id="btn-abonne" class="btn btn-outline-danger px-4 py-2" type="button">
                            <i class="fas fa-times-circle me-2"></i> Abandonné
                        </button>
                    </div>
                </div>
                <div class="chat-container mb-3" id="chatWindow">
                    <!-- Sample Chat Messages -->
                    <div class="p-3 shadow-lg rounded text-center" style="width: 500px; height: 350px; margin-top: 15px; background-color: #FEF8E7; margin: 0 auto;">
                        <p class="mb-0" style="align-items: baseline">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer interdum quam eu sem
                            lobortis, et dignissim nunc rhoncus. Curabitur finibus, dolor nec vestibulum consectetur,
                            arcu diam vestibulum nisl, sit amet imperdiet magna nulla sed magna. Donec fermentum aliquam
                            ligula in lobortis. Morbi aliquam, massa in vestibulum eleifend, nibh l
                        </p>
                    </div>
                </div>

                <div id="inpu-group" class="container  my-5">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ?</h3>
                    </div>

                    <div class="row g-4 justify-content-center mt-3" id="reponses">
    @foreach (['A', 'B', 'C', 'D'] as $key => $lettre)
        <div class="col-md-5">
            <button class="btn w-100 p-3 shadow-lg rounded bg-white text-start text-dark choix-reponse"
                    data-reponse="{{ $lettre }}">
<span class="fw-bold fs-4 me-2">{{ $lettre }}</span>
{{ $question['propositions'][$key] ?? 'Proposition' }}
</button>
</div>
@endforeach
</div>
</div>

</div>
</div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>


</body>

</html>
--}}
