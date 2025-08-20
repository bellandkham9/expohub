 <!-- Header -->
 <nav class="navbar navbar-expand-lg bg-white  sticky-top">
     <div class="container">
         <a class="navbar-brand fw-bold text-primary" href="{{ route('start.home') }}">
             <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 40px;">
         </a>


         <!-- Menu -->
         <div class="collapse navbar-collapse justify-content-center" id="mainNavbar">
             <ul class="navbar-nav gap-3">
                 <li class="nav-item"><a class="nav-link" href="{{ route('client.dashboard') }}">Tableau de bord</a></li>
                 <li class="nav-item"><a class="nav-link" href="{{ route('test.choix_test') }}">Tests</a></li>
                 <li class="nav-item"><a class="nav-link" href="{{ route('client.history') }}">Historique</a></li>
                 <li class="nav-item"><a class="nav-link" href="{{ route('suggestion.suggestion') }}">Stratégie</a></li>
                 <li class="nav-item"><a class="nav-link" target="blank" href="https://www.exponentielimmigration.com/">Exponentiel Immigration</a></li>
             </ul>
         </div>
         <!-- Droite : notif + avatar -->
         <div class="d-flex align-items-center gap-3">
             <i class="btn bi bi-bell" style="font-size: 1.3rem;"></i>

             <div class="dropdown text-end">
                 <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false" ...>
                     <img src="{{ auth()->user()->avatar_url ? asset(auth()->user()->avatar_url) : asset('images/user-person.png') }}" alt="Avatar" class="rounded-circle" style="width: 35px; height: 35px; object-fit: cover;">
                 </a>

                 <ul class="dropdown-menu text-small" ... aria-labelledby="dropdownUser1">
                     <li><a class="dropdown-item" href="{{route('client.mon-compte')}}">Mon compte</a></li>
                     <li>
                         <hr class="dropdown-divider">
                     </li>
                     <li><a class="dropdown-item" href="{{ route('deconnexion') }}">Se déconnecter</a></li>
                 </ul>
             </div>


         </div>
         <!-- Burger button -->
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
         </button>


     </div>
 </nav>
