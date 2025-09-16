<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ExpoHub</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Vite (Laravel) -->
    @vite([
        'resources/sass/app.scss',
        'resources/css/custom.css',
        'resources/css/suggestion.css',
        'resources/css/choix_test.css',
        'resources/css/dashboard-client.css',
        'resources/js/app.js'
    ])

    <style>
        html, body {
            background-color: white;
            font-family: "Inter", sans-serif;
        }

        .shadowed { box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); }

        .testimonial-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 1rem;
        }

        #hero, #hero-contact {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: start;
            padding: 30px;
            border-radius: 30px;
        }

        #hero {
            background-image: url("{{ asset('images/student.png') }}");
        }

        #hero-contact {
            background-image: url("{{ asset('images/hero-contact.png') }}");
        }

        /* Sidebar */
        .sidebar .nav-link.active {
            background-color: #f0f8ff;
            border-radius: 0.5rem;
        }

        /* Cards */
     

        .card:hover, .card-body:hover {
            background-color: white;
            color: black;
        }

        /* Bouton principal */
        .btn-primary {
            border-radius: 20px;
            background-color: #224194;
            color: white;
        }

        /* Toast */
        #toast {
            visibility: hidden;
            min-width: 250px;
            background-color: #28a745;
            color: #fff;
            text-align: center;
            border-radius: 4px;
            padding: 15px;
            position: fixed;
            z-index: 9999;
            right: 30px;
            bottom: 30px;
            font-size: 16px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: visibility 0s, opacity 0.5s linear;
            opacity: 0;
        }
    </style>
</head>

<body>
<div id="app" style="background-color: white">
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="container-fluid p-4 text-light" style="background-color: #222;">
    <div class="container">
        <div class="row align-items-start">
            <!-- Liens -->
            <div class="col-12 col-md-6 mb-3">
                <p class="fw-bold">Allez à</p>
                <ul class="list-unstyled d-flex flex-wrap gap-3">
                    <li><a href="{{ route('start.home') }}" class="text-white text-decoration-none">Accueil</a></li>
                    <li><a href="{{ route('suggestion.suggestion') }}" class="text-white text-decoration-none">Stratégie</a></li>
                    <li><a href="{{ route('client.paiement') }}" class="text-white text-decoration-none">Abonnements</a></li>
                    <li><a href="https://www.exponentielimmigration.com/" target="_blank" class="text-white text-decoration-none">Exponentiel Immigration</a></li>
                    <li><a href="{{ route('client.contact') }}" class="text-white text-decoration-none">Contact</a></li>
                </ul>
                <p class="mt-3 fw-bold">
                    Suivez-nous sur :
                    <a href="https://www.facebook.com/immigrationforus?mibextid=ZbWKwL" class="text-white"><i class="bi bi-facebook m-2"></i></a>
                    <a href="https://youtube.com/@exponentielimmigration?si=TpZ2KjA7mdJYpay2" class="text-white"><i class="bi bi-youtube m-2"></i></a>
                </p>
            </div>

            <!-- Connexion / CGU -->
            <div class="col-12 col-md-6 text-md-end mb-3">
                @if (!auth()->check())
                    <div class="d-flex flex-wrap justify-content-md-end gap-2 mb-3">
                        <a class="btn btn-light px-3" href="{{ route('auth.inscription') }}" style="border-radius: 30px; color: black;">S'inscrire</a>
                        <a class="btn btn-light px-3" href="{{ route('auth.connexion') }}" style="border-radius: 30px; color: black;">Se connecter</a>
                    </div>
                @endif
                <div>
                    <small>
                        <a href="#" class="text-decoration-none text-light me-2">Conditions d'utilisation</a>
                        <a href="#" class="text-decoration-none text-light">Politique de confidentialité</a>
                    </small>
                </div>
            </div>
        </div>

        <hr class="my-3" style="height: 2px; background-color: white; border: none;">

        <div class="text-center">
            <small class="d-block">&copy; 2025 ExpoHub Academy | Tous droits réservés</small>
        </div>
    </div>
</footer>

</div>

<!-- Toast Notification -->
<div id="toast">✅ Information envoyée avec succès</div>

<script>
    function showToast(message, color = '#28a745') {
        const toast = document.getElementById("toast");
        toast.textContent = message;
        toast.style.backgroundColor = color;
        toast.style.visibility = "visible";
        toast.style.opacity = "1";
        setTimeout(() => {
            toast.style.opacity = "0";
            toast.style.visibility = "hidden";
        }, 3000);
    }
</script>

@if (session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", () => showToast("{{ session('success') }}"));
    </script>
@endif

@if (session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", () => showToast("{{ session('error') }}", "#dc3545"));
    </script>
@endif

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


     
</body>
</html>