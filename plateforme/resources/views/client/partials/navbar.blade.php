<!-- Header -->
<nav class="navbar navbar-expand-lg bg-white sticky-top shadow-sm">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand fw-bold text-primary" href="{{ route('start.home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 40px;">
        </a>

        <!-- Burger button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
            aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse justify-content-center" id="mainNavbar">
            <ul class="navbar-nav gap-3 me-auto ms-auto text-center">
                <li class="nav-item"><a class="nav-link" href="{{ route('start.home') }}">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('suggestion.suggestion') }}">Stratégie</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('client.paiement') }}">Plans d'abonnements</a></li>
                <li class="nav-item"><a class="nav-link" target="_blank" href="https://www.exponentielimmigration.com/">Exponentiel Immigration</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('client.contact') }}">Nous contacter</a></li>
            </ul>

            <!-- Buttons (intégrés dans le menu mobile aussi) -->
            <div class="d-flex flex-lg-row flex-column gap-2 text-center">
                <a id="btn-commencer" class="btn btn-primary" href="{{ route('auth.inscription') }}">
                    Commencez maintenant
                </a>
                <a id="btn-connecter" class="btn btn-outline-primary" href="{{ route('auth.connexion') }}">
                    Se Connecter
                </a>
            </div>
        </div>
    </div>
</nav>
