 <!-- Header -->
 <nav class="navbar navbar-expand-lg bg-white  sticky-top">
     <div class="container">
         <a class="navbar-brand fw-bold text-primary" href="{{ route('start.home') }}">
             <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 40px;">
         </a>


         <!-- Menu -->
         <div class="collapse navbar-collapse justify-content-center" id="mainNavbar">
             <ul class="navbar-nav gap-3">
                 <li class="nav-item"><a class="nav-link" href="{{ route('client.dashboard') }}">Tableau de bord</a>
                 </li>
                 <li class="nav-item"><a class="nav-link" href="{{ route('test.choix_test') }}">Tests</a></li>
                 <li class="nav-item"><a class="nav-link" href="{{ route('client.history') }}">Historique</a></li>
                 <li class="nav-item"><a class="nav-link" href="{{ route('suggestion.suggestion') }}">Stratégie</a></li>
                 <li class="nav-item"><a class="nav-link" target="blank"
                         href="https://www.exponentielimmigration.com/">Exponentiel Immigration</a></li>
             </ul>
         </div>
         <!-- Droite : notif + avatar -->
         <div class="d-flex align-items-center gap-3">

             @php
                 $notifications = \App\Models\NotificationAdmin::whereNull('user_id')
                     ->orWhere('user_id', auth()->id())
                     ->orderBy('created_at', 'desc')
                     ->get();
             @endphp

             <div class="dropdown">
                @php
                    $unreadCount = $notifications->where('read', false)->count();
                    $iconClass = $unreadCount > 0 ? 'text-success' : 'text-secondary';
                @endphp

                <button class="btn dropdown-toggle position-relative" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-bell {{ $iconClass }}" style="font-size: 1.5rem;"></i>

                    @if($unreadCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $unreadCount }}
                            <span class="visually-hidden">notifications non lues</span>
                        </span>
                    @endif
                </button>



                 <ul class="dropdown-menu">
                     @foreach ($notifications as $notif)
                         <li class="position-relative">
                             <a href="#"
                                 class="dropdown-item notification-link d-flex flex-column py-2 border-bottom"
                                 data-id="{{ $notif->id }}"
                                 data-url="{{ route('admin.notifications.read', $notif) }}"
                                 style="white-space: normal;">
                                 <div class="" style="width: 300px;">
                                    <div style="width: 250px;">
                                     <div class="d-flex justify-content-between align-items-center">
                                         <strong class="{{ $notif->read ? 'text-muted' : 'text-dark' }}">
                                             {{ $notif->title }}
                                         </strong>
                                         <small class="text-secondary">
                                             {{ $notif->created_at->format('d/m H:i') }}
                                         </small>
                                     </div>
                                     <span class="{{ $notif->read ? 'text-muted' : 'text-body' }}">
                                         {{ $notif->message }}
                                     </span>
                                 </div>
                                  <!-- Bouton de suppression -->
                             <button type="button"
                                 class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-1 notif-remove"
                                 data-id="{{ $notif->id }}" style="line-height:1; font-weight:bold;">×</button>
                             </a>

                                 </div>
                            
                         </li>
                     @endforeach
                 </ul>
             </div>


             <div class="dropdown text-end">
                 <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1"
                     data-bs-toggle="dropdown" aria-expanded="false" ...>
                     <img src="{{ auth()->user()->avatar_url ? asset(auth()->user()->avatar_url) : asset('images/user-person.png') }}"
                         alt="Avatar" class="rounded-circle" style="width: 35px; height: 35px; object-fit: cover;">
                 </a>

                 <ul class="dropdown-menu text-small" ... aria-labelledby="dropdownUser1">
                     <li><a class="dropdown-item" href="{{ route('client.mon-compte') }}">Mon compte</a></li>
                     <li>
                         <hr class="dropdown-divider">
                     </li>
                     <li><a class="dropdown-item" href="{{ route('deconnexion') }}">Se déconnecter</a></li>
                 </ul>
             </div>


         </div>
         <!-- Burger button -->
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
             aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
         </button>


     </div>
 </nav>
