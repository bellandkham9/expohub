<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT6VZ6zP8E6ztpj6M/t94wr7" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">


    <title>Document</title>
    <style>
        .shadowed {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        html,
        body {
            background-color: white;
            font-family: "Inter", sans-serif;
        }

        .testimonial-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 1rem;
        }

        #hero {
            background-image: url("{{ asset('images/student.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 600px;
            /* ajuste la hauteur selon ton besoin */
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: start;
            padding: 30px;
            border-radius: 30px;
        }

        #hero-contact {
            background-image: url("{{ asset('images/hero-contact.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 600px;
            /* ajuste la hauteur selon ton besoin */
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: start;
            padding: 30px;
            border-radius: 30px;
        }

        /*========>     STYLE SIDEBAR*/
        .sidebar .nav-link.active {
            background-color: #f0f8ff;
            border-radius: 0.5rem;
        }

    </style>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="bg-dark">
    <div id="app" class="" style="background-color: white">
        <main class="">
           <div class="container my-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold">Résultats du test - Comprehension Écrite</h2>
        <h4>Score : {{ $score }} / {{ $total }}</h4>

        @if($score > 0)
            @if($score / $total >= 0.7)
                <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
                <script> window.onload = () => confetti(); </script>
                <div class="alert alert-success">🎉 Félicitations ! Bon résultat !</div>
            @else
                <div class="alert alert-warning">📝 Continue à t'entraîner !</div>
            @endif
        @endif
    </div>

    <div  class="card shadow">
        <div  class="card-body">
            {{-- Graphique de progression --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Progression de vos scores</h5>
                    <canvas id="progressChart" height="120"></canvas>
                </div>
            </div>

            {{-- Tableau de réponses --}}
            <table id="myCard" class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Question</th>
                        <th>Bonne réponse</th>
                        <th>Votre réponse</th>
                        <th>Résultat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reponses as $rep)
                        <tr>
                            <td>{{ $rep->numero }}</td>
                            <td>{{ $rep->question }}</td>
                            <td><strong>{{ $rep->bonne_reponse }}</strong></td>
                            <td>{{ $rep->reponse_utilisateur }}</td>
                            <td>
                                @if($rep->is_correct)
                                    <span class="badge bg-success">Correct</span>
                                @else
                                    <span class="badge bg-danger">Faux</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Boutons d'action --}}
            <div class="text-center mt-4">
                <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary btn-lg">
                    📚 Revenir à l’accueil
                </a>
            </div>
        </div>
    </div>
</div>
        </main>
        <!-- Footer -->
        <footer class="container mb-4  p-4 text-light">
            <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div>
                    <p class="mb-1 fw-bold">Allez à</p>
                    <ul class="list-unstyled d-flex gap-3">
                        <li><a href="{{ route('start.home') }}" class="text-white text-decoration-none">Accueil</a></li>
                        <li><a href="{{ route('suggestion.suggestion') }}" class="text-white text-decoration-none">Stratégie</a></li>
                        <li><a href="{{ route('client.paiement') }}" class="text-white text-decoration-none">Abonnements</a></li>
                        <li><a href="{{ route('client.contact') }}" class="text-white text-decoration-none">Contact</a></li>
                    </ul>

                    <div class="">
                        <p class="mt-2 fw-bold">Suivez nous sur : <a href=""><i class="bi bi-facebook m-2"></i></a> <a href=""><i class="bi bi-linkedin m-2"></i></a> <a href=""><i class="bi bi-instagram m-2"></i></a></p>
                    </div>


                </div>
                <div class="d-flex flex-column align-items-end text-end">
                    <div class="d-flex gap-2 mb-3">
                        <a class="btn" href="{{route('auth.inscription')}}" style="background-color: #D9D9D9; border-radius: 30px; color: black;">S'inscrire</a>
                        <a class="btn" href="{{route('auth.connexion')}}" style="background-color: #D9D9D9; border-radius: 30px; color: black;">Se connecter</a>
                    </div>
                    <div>
                        <small>
                            <a href="#" class="text-decoration-none text-light me-2">Conditions d'utilisation</a>
                            <a href="#" class="text-decoration-none text-light">Politique de confidentialité</a>
                        </small>
                    </div>
                </div>

            </div>
            <hr style="height: 3px; background-color: white; border: 2px solid white;" class="">
            <div class="container text-center mt-3">
                <small class="d-block">&copy; 2025 ExpoHub Academy | tout les droits réservés</small>

            </div>
        </footer>
    </div>
 

{{-- ChartJS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    window.addEventListener('DOMContentLoaded', function () {
        const historique = {!! json_encode($historique->map(fn($h) => [
            'date' => $h->created_at instanceof \Illuminate\Support\Carbon ? $h->created_at->format('d/m/y') : $h->created_at,
            'score' => $h->score,
            'total' => $h->total,
        ])->toArray()) !!};

        if (historique.length > 0 && historique.some(item => item.total > 0)) {
            const labels = historique.map(item => item.date);
            const data = historique.map(item =>
                item.total > 0 ? Math.round((item.score / item.total) * 100) : 0
            );

            const ctx = document.getElementById('progressChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Score',
                        data: data,
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0, 123, 255, 0.2)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#007bff'
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
        } else {
            console.warn("Aucun historique de score valide pour afficher le graphique.");
        }
    });
</script>


</body>

</html>



