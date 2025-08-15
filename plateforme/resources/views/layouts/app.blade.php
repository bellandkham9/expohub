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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />


    <title>ExpoHub</title>
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
        .card-body:hover{
            background-color: white;
            color: black;
        }
        .card:hover{
 background-color: white;
            color: black;
        }
    </style>

    @vite(['resources/sass/app.scss', 'resources/css/custom.css', 'resources/css/suggestion.css',  'resources/css/choix_test.css', 'resources/css/dashboard-client.css', 'resources/js/app.js'])
</head>

<body class="bg-dark">
    <div id="app" class="" style="background-color: white">
        <main class="">
            @yield('content')
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
                    @if(!auth()->check())
                        <div class="d-flex gap-2 mb-3">
                            <a class="btn" href="{{route('auth.inscription')}}" style="background-color: #D9D9D9; border-radius: 30px; color: black;">S'inscrire</a>
                            <a class="btn" href="{{route('auth.connexion')}}" style="background-color: #D9D9D9; border-radius: 30px; color: black;">Se connecter</a>
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
            <hr style="height: 3px; background-color: white; border: 2px solid white;" class="">
            <div class="container text-center mt-3">
                <small class="d-block">&copy; 2025 ExpoHub Academy | tout les droits réservés</small>

            </div>
        </footer>
    </div>
 

    <!-- Toast Notification -->
<div id="toast" style="
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
">
    ✅ infotmation envoyé avec succès
</div>

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

@if(session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            showToast("{{ session('success') }}");
        });
    </script>
@endif

@if(session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            showToast("{{ session('error') }}", "#dc3545");
        });
    </script>
@endif

   <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Bundle (inclut Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YW8hRhP56V8VuSK9Eo0BtJXG5Dspu3j1gzDdt8ZMpPoQ9B/JW1yQlGb0n0e5l9lx" crossorigin="anonymous"></script>


</body>

</html>
