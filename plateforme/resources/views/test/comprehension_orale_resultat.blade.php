<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat - Compréhension Orale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>
    @vite('resources/css/expression_ecrite.css')
    <style>
        .result-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .question-result {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            background-color: #f8f9fa;
        }

        .correct {
            color: green;
            font-weight: bold;
        }

        .incorrect {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="result-container text-center">
            <h2 class="mb-4">🎧 Résultat - Compréhension Orale</h2>

            <h4>Score : {{ $score }} / {{ $total }}</h4>
            <h5 class="text-{{ $pourcentage >= 50 ? 'success' : 'danger' }}">Taux de réussite : {{ $pourcentage }}%</h5>

            <canvas id="progressChart" height="100"></canvas>

            <div class="mt-4">
                <a href="{{ route('test.comprehension_orale') }}" class="btn btn-primary me-3">
                    Recommencer le test
                </a>
                <a href="#reponses" class="btn btn-outline-secondary">
                    Voir mes réponses
                </a>
            </div>
        </div>

        <div class="mt-5" id="reponses">
            <h4 class="mb-3">📋 Détail des réponses</h4>
     @foreach($reponses as $rep)
    <div class="question-result border p-3 mb-3 rounded shadow-sm {{ $rep->is_correct ? 'border-success' : 'border-danger' }}">
        <p><strong>Contexte :</strong></p>

        @if(Str::endsWith($rep->contexte_texte, ['.jpg', '.png', '.jpeg']))
            <img src="{{ asset('storage/' . $rep->contexte_texte) }}" alt="image" class="img-fluid mb-2" style="max-height: 200px;">
        @else
            <p>{{ $rep->contexte_texte }}</p>
        @endif

        <audio controls class="mb-2">
            <source src="{{ asset('storage/' . $rep->question_audio) }}" type="audio/mpeg">
        </audio>

        <p><strong>Votre réponse :</strong>
            <span class="{{ $rep->is_correct ? 'text-success fw-bold' : 'text-danger fw-bold' }}">
                {{ ['A', 'B', 'C', 'D'][$rep->reponse_utilisateur - 1] ?? '?' }}
                - {{ $rep->{'proposition_' . $rep->reponse_utilisateur} }}
            </span>
        </p>

        <p><strong>Bonne réponse :</strong>
            <span class="text-success fw-bold">
                {{ ['A', 'B', 'C', 'D'][$rep->bonne_reponse - 1] ?? '?' }}
                - {{ $rep->{'proposition_' . $rep->bonne_reponse} }}
            </span>
        </p>
    </div>
@endforeach

<div class="text-center mt-4">
    <h3>Votre score : {{ $score }} / {{ $total }} ({{ $pourcentage }}%)</h3>
</div>


        </div>
    </div>

    <audio id="success-sound" src="{{ asset('sounds/success.mp3') }}"></audio>
    <audio id="fail-sound" src="{{ asset('sounds/fail.mp3') }}"></audio>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const successSound = document.getElementById('success-sound');
            const failSound = document.getElementById('fail-sound');

            @if($pourcentage >= 50)
                confetti();
                successSound.play();
            @else
                failSound.play();
            @endif

            const ctx = document.getElementById('progressChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($historique->pluck('created_at')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d/m/y'))->toArray()) !!},
                    datasets: [{
                        label: 'Score (%)',
                        data: {!! json_encode($historique->map(fn($h) => $h->total > 0 ? round(($h->score / $h->total) * 100) : 0)->toArray()) !!},
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0, 123, 255, 0.2)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        y: {
                            suggestedMin: 0,
                            suggestedMax: 100,
                            title: {
                                display: true,
                                text: '% de réussite'
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>
