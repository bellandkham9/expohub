<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - EHD</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Pour afficher les messages flash
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Succès',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6',
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: '{{ session('error') }}',
            confirmButtonColor: '#d33',
        });
    @endif

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            html: `<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>`,
            confirmButtonColor: '#d33',
        });
    @endif
</script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #224194;
            background-image: url("{{ asset('images/pattern.png') }}");
            background-size: cover;
            background-position: center;
            display: flex;
            background-repeat: no-repeat;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0 auto;
        }

        .login-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .welcome-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .welcome-title {
            color: white;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: -10px;
            /* pour coller un peu à la box */
        }

        .logo {
            font-size: 36px;
            font-weight: bold;
            color: #333;
            margin-bottom: 30px;
        }

        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: white;
            font-weight: 500;
            transition: all 0.3s;
            color: black;
        }

        .social-btn:hover {
            background-color: #f8f9fa;
        }

        .social-btn i {
            margin-right: 10px;
            font-size: 18px;
            color: black;
        }

        .google-btn {
            color: #4285F4;
        }

        .facebook-btn {
            color: #5477be;
        }
        #sendmessage{
            width: 100%;
            background-color: #224194;
            color: white;
        }
    </style>
</head>

<body>
    <div class="welcome-container">
        <h3 class="welcome-title">Bienvenue !</h3>

        <div class="login-container">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
            </div>

            <div class="contact-form">

                <form action="{{route('auth.connexion')}}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <input type="text" class="form-control" id="email" name="email" required placeholder="E-mail">
                    </div>

                    <div class="mb-3">
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Mot de passe">
                    </div>

                    <button id="sendmessage" type="submit" class="btn btn-send">Connexion</button>
                </form>
            </div>
            
        </div>
        <div>
            <p class="">
                <a href="{{ route('social.redirect', 'google') }}" class="d-block btn btn-light  btn-google">
                    <img src="{{ asset('images/google.png') }}" class="m-2" alt="Logo"> Continuer avec Google
                </a>
            </p>
            <p class="">
                <a href="{{ route('social.redirect', 'facebook') }}" class="d-block btn btn-light btn-facebook">
                                    <img src="{{ asset('images/facebook.png') }}" class="m-2" alt="Logo"> Continuer avec Facebook
                </a>
            </p>
            <p class="text-center"> 
                <a class="link-light" href="{{route('auth.inscription')}}"> S'inscrire</a>  
            </p>

            <p><a class="dropdown-item" href="{{ route('deconnexion') }}" style="color: white;">Se déconnecter</a></p>
        </div>
    </div>
</body>


</html>
