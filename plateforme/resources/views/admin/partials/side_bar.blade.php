 <!-- Bouton Menu pour mobile -->
 <button class="btn btn-primary d-lg-none mobile-menu-btn" style="position: absolute; right: -50px; top: 10px; z-index: 1000;">
     <i class="fas fa-bars"></i>
 </button>

 <div class="d-flex justify-content-center align-items-center gap-3">
     <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 50px;" />
     <h5 class="mb-0 text-primary fw-bold">EXPO HUB</h5>
 </div>

 <hr style="background-color: black; height: 2px;">


<div class="d-flex align-items-center mb-4">
    <!-- Avatar + Menu déroulant -->
    <a href="#" 
       class="d-block link-dark text-decoration-none dropdown-toggle" 
       id="dropdownUser1" 
       data-bs-toggle="dropdown" 
       aria-expanded="false">
        <img src="{{ auth()->user()->avatar_url ? asset(auth()->user()->avatar_url) : asset('images/user-person.png') }}" 
             alt="Avatar" 
             class="rounded-circle" 
             style="width: 35px; height: 35px; object-fit: cover;">
    </a>

    <!-- Nom et flèche -->
    <div class="d-flex justify-content-center align-items-center ms-2">
        <div class="fw-bold">{{ auth()->user()->name ?? 'Utilisateur' }}</div>
    </div>

    <!-- Menu dropdown -->
    <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
        <li>
            <a class="dropdown-item" href="{{ route('client.mon-compte') }}">Mon compte</a>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('deconnexion') }}">Se déconnecter</a>
        </li>
    </ul>
</div>


 <ul class="nav flex-column">
     <li class="nav-item mb-2">
         <a href="{{ route('gestion_utilisateurs') }}" class="nav-link d-flex justify-content-between align-items-center w-100 
         {{ request()->routeIs('gestion_utilisateurs') ? 'bg-primary text-white rounded px-3 py-2' : 'text-dark px-3 py-2' }}">
             <span>
                 Gestion des Utilisateurs
             </span>
             @if (request()->routeIs('gestion_utilisateurs'))
             <i class="fas fa-arrow-right"></i>
             @endif
         </a>
     </li>

     <li class="nav-item mb-2">
         <a href="{{ route('statistiques') }}" class="nav-link d-flex justify-content-between align-items-center w-100 
         {{ request()->routeIs('statistiques') ? 'bg-primary text-white rounded px-3 py-2' : 'text-dark px-3 py-2' }}">
             <span>
                 </i> Statistiques
             </span>
             @if (request()->routeIs('statistiques'))
             <i class="fas fa-arrow-right"></i>
             @endif
         </a>
     </li>

     {{-- <li class="nav-item mb-2">
      <a href="{{ route('gestion_tests') }}"
     class="nav-link d-flex justify-content-between align-items-center w-100
     {{ request()->routeIs('gestion_tests') ? 'bg-primary text-white rounded px-3 py-2' : 'text-dark px-3 py-2' }}">
     <span>
         Gestion des tests
     </span>
     @if (request()->routeIs('gestion_tests'))
     <i class="fas fa-arrow-right"></i>
     @endif
     </a>
     </li> --}}


     <li class="nav-item mb-2">
         <a href="{{ route('gestion_test') }}" class="nav-link d-flex justify-content-between align-items-center w-100 
         {{ request()->routeIs('gestion_test') ? 'bg-primary text-white rounded px-3 py-2' : 'text-dark px-3 py-2' }}">
             <span>
                 Gestion des tests
             </span>
             @if (request()->routeIs('gestion_test'))
             <i class="fas fa-arrow-right"></i>
             @endif
         </a>
     </li>
 </ul>
