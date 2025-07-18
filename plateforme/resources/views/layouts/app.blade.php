<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


    <title>Document</title>
    <style>
        .shadowed {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        html,
        body {
            background-color: white;
        }

        .testimonial-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 1rem;
        }

        #hero {
            hero-contact background-image: url("{{ asset('images/student.png') }}");
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

    @vite(['resources/sass/app.scss', 'resources/css/custom.css', 'resources/css/suggestion.css', 'resources/css/choix_test.css', 'resources/css/dashboard-client.css', 'resources/js/app.sjs'])
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
                        <li><a href="#" class="text-white text-decoration-none">Accueil</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Stratégie</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Abonnements</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Contact</a></li>
                    </ul>

                    <div class="">
                        <p class="mt-2 fw-bold">Suivez nous sur : <a href=""><i class="bi bi-facebook m-2"></i></a> <a href=""><i class="bi bi-linkedin m-2"></i></a> <a href=""><i class="bi bi-instagram m-2"></i></a></p>
                    </div>


                </div>
                <div class="d-flex flex-column align-items-end text-end">
                    <div class="d-flex gap-2 mb-3">
                        <a class="btn" href="#" style="background-color: #D9D9D9; border-radius: 30px; color: black;">S'inscrire</a>
                        <a class="btn" href="#" style="background-color: #D9D9D9; border-radius: 30px; color: black;">Se connecter</a>
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
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>
