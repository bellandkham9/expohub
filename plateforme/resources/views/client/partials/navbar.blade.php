 <!-- Header -->
    <nav class="navbar navbar-expand-lg bg-white  sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 40px;">
            </a>


            <!-- Menu -->
            <div class="collapse navbar-collapse justify-content-center" id="mainNavbar">
                <ul class="navbar-nav gap-3">
                    <li class="nav-item"><a class="nav-link" href="{{ route('start.home') }}">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('client.dashboard') }}">Stratégie</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('client.dashboard') }}">Plans d'abonnements</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('client.dashboard') }}">Nous contacter</a></li>
                </ul>
            </div>
            <!-- Buttons -->
            <div class="d-flex gap-2">
                <a id="btn-commencer" class="btn" href="#">Commencez maintenant</a>
                <a id="btn-connecter" class="btn btn-outline-primary" href="#">Se Connecter</a>
            </div>
            <!-- Burger button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


        </div>
    </nav>



    