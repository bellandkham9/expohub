<nav class="navbar navbar-expand-lg bg-white sticky-top shadow-sm">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand fw-bold text-primary" href="{{ route('start.home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 40px;">
        </a>

        <!-- Bouton mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu à gauche (près du logo) -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav gap-3 ms-3">
                <li class="nav-item"><a class="nav-link" href="{{ route('client.dashboard') }}">Tableau de bord</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('test.choix_test') }}">Tests</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('client.history') }}">Historique</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('suggestion.suggestion') }}">Stratégie</a></li>
                <li class="nav-item"><a class="nav-link" target="_blank" href="https://www.exponentielimmigration.com/">Exponentiel Immigration</a></li>
            </ul>
        </div>

        <!-- Partie droite -->
        <div class="d-flex align-items-center gap-3 ms-auto">
            @php
                $notifications = \App\Models\NotificationAdmin::whereNull('user_id')
                    ->orWhere('user_id', auth()->id())
                    ->orderBy('created_at', 'desc')
                    ->get();
                $unreadCount = $notifications->where('read', false)->count();
            @endphp

            <!-- Bouton notifications -->
            <button class="btn position-relative" id="btnNotifications">
                <i class="bi bi-bell" style="font-size: 1.5rem;"></i>
                @if($unreadCount > 0)
                    <span id="notifBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $unreadCount }}
                        <span class="visually-hidden">notifications non lues</span>
                    </span>
                @endif
            </button>

            <!-- Dropdown utilisateur -->
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"
                   id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ auth()->user()->avatar_url ? asset(auth()->user()->avatar_url) : asset('images/user-person.png') }}"
                         alt="Avatar"
                         class="rounded-circle"
                         style="width: 35px; height: 35px; object-fit: cover;">
                    <!-- Nom affiché seulement sur desktop -->
                    <span class="fw-bold ms-2 d-none d-lg-inline">{{ auth()->user()->name ?? 'Utilisateur' }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="{{ route('client.mon-compte') }}">Mon compte</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="{{ route('deconnexion') }}">Se déconnecter</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function(){

    const notifications = @json($notifications);
    const btn = document.getElementById('btnNotifications');
    const badge = document.getElementById('notifBadge');

    btn.addEventListener('click', function(){

        if(notifications.length === 0){
            Swal.fire('Aucune notification');
            return;
        }

        // Créer la liste scrollable
        let content = '<div style="max-height: 300px; overflow-y:auto;">';
        notifications.forEach(notif => {
            const readClass = notif.read ? 'text-muted' : 'text-dark';
            content += `
                <div class="notif-item d-flex justify-content-between align-items-start p-2 border-bottom" data-id="${notif.id}" style="position:relative; cursor:pointer;">
                    <div>
                        <strong class="${readClass}">${notif.title}</strong><br>
                        <small class="text-secondary">${notif.created_at}</small><br>
                        <span class="${readClass}">${notif.message}</span>
                    </div>
                    <button class="btn-close  btn-sm" data-id="${notif.id}" style="position:absolute; top:5px; right:5px; color:red;"></button>
                </div>
            `;
        });
        content += '</div>';

        Swal.fire({
            title: 'Notifications',
            html: content,
            showCloseButton: true,
            showConfirmButton: false,
            width: 400,
            didOpen: () => {

                // Marquer comme lu au clic sur la notification
                document.querySelectorAll('.notif-item').forEach(item => {
                    item.addEventListener('click', function(e){
                        if(e.target.classList.contains('btn-close')) return; // Ignorer le bouton supprimer
                        const id = this.dataset.id;
                        fetch(`/admin/notifications/${id}/read`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        }).then(res => res.json())
                          .then(data => {
                              if(data.success){
                                  this.querySelectorAll('strong, span').forEach(el => el.classList.replace('text-dark','text-muted'));
                                  // Mettre à jour badge
                                  if(badge){
                                      let count = parseInt(badge.innerText);
                                      count = count > 0 ? count - 1 : 0;
                                      badge.innerText = count;
                                      if(count===0) badge.remove();
                                  }
                              }
                          });
                    });
                });

                // Supprimer notification
                document.querySelectorAll('.btn-close').forEach(btnClose => {
                    btnClose.addEventListener('click', function(e){
                        e.stopPropagation(); // éviter clic parent
                        const id = this.dataset.id;
                        const item = this.closest('.notif-item');

                        fetch(`/admin/notifications/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if(data.success){
                                item.remove();
                                // mettre à jour le badge
                                if(badge){
                                    let count = parseInt(badge.innerText);
                                    count = count > 0 ? count - 1 : 0;
                                    badge.innerText = count;
                                    if(count===0) badge.remove();
                                }
                            }
                        });

                    });
                });
            
            
            }
        });

    });
});
</script>

<Style>
    


</Style>