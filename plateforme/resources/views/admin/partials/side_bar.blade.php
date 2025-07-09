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
    <img src="{{ asset('images/beautiful-woman.png') }}" width="50" class="rounded-circle me-2" alt="User" />
    <div class="d-flex justify-content-center align-items-center">
      <div class="fw-bold">Maya AKAMA</div>
      <div class="text-muted small btn"><i class="fas fa-chevron-down"></i></div>
    </div>
  </div>

  <ul class="nav flex-column">
    <li class="nav-item mb-2">
      <a href="{{ route('gestion_utilisateurs') }}"
         class="nav-link d-flex justify-content-between align-items-center w-100 
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
      <a href="{{ route('statistiques') }}"
         class="nav-link d-flex justify-content-between align-items-center w-100 
         {{ request()->routeIs('statistiques') ? 'bg-primary text-white rounded px-3 py-2' : 'text-dark px-3 py-2' }}">
        <span>
          </i> Statistiques
        </span>
        @if (request()->routeIs('statistiques'))
          <i class="fas fa-arrow-right"></i>
        @endif
      </a>
    </li>

    <li class="nav-item mb-2">
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
    </li>


    <li class="nav-item mb-2">
      <a href="{{ route('gestion_activites') }}"
         class="nav-link d-flex justify-content-between align-items-center w-100 
         {{ request()->routeIs('gestion_activites') ? 'bg-primary text-white rounded px-3 py-2' : 'text-dark px-3 py-2' }}">
        <span>
          Gestion des activités
        </span>
        @if (request()->routeIs('gestion_activites'))
          <i class="fas fa-arrow-right"></i>
        @endif
      </a>
    </li>
  </ul>


