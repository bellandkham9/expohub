<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/admin-gestion-user.css'])
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 sidebar p-3">
                @include('admin.partials.side_bar')
            </div>

            <div class="col-md-9 col-lg-10 main-content">
                {{-- Validation de suppression de l'utilisateur --}}
        <div class="main-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

                <div class="row g-5 m-3">
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="stat-card position-relative d-flex flex-column align-items-end bg-white rounded-3 p-3 shadow-sm h-100">
                            <span class="position-absolute top-0 start-0 translate-middle badge d-flex align-items-center justify-content-center p-2" style="background-color: #707070; width: 45px; height: 45px; border-radius: 8px; margin-left: 40px;">
                                <img src="{{ asset('images/user.png') }}" alt="Logo" style="max-width: 70%; max-height: 70%;">
                            </span>

                            <div class="w-100">
                                <div class="d-flex flex-column align-items-end">
                                    <div>
                                        <div class="text-muted small">Utilisateurs inscrits</div>
                                        <div class="h4 mb-0">{{ $totalUsers }}</div>
                                    </div>
                                </div>
                                <hr style="background-color: #495057; height: 2px; width: 100%;">
                                <div class="text-muted small mt-1">
                                    <span style="color: #707070; font-weight: bold;">{{ $usersLastWeek }}</span> que la semaine passée
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="stat-card position-relative d-flex flex-column align-items-end bg-white rounded-3 p-3 shadow-sm h-100">
                            <span class="position-absolute top-0 start-0 translate-middle badge d-flex align-items-center justify-content-center p-2" style="background-color: #0DF840; width: 45px; height: 45px; border-radius: 8px; margin-left: 40px;">
                                <img src="{{ asset('images/house.png') }}" alt="Logo" style="max-width: 70%; max-height: 70%;">
                            </span>

                            <div class="w-100">
                                <div class="d-flex flex-column align-items-end">
                                    <div>
                                        <div class="text-muted small">Utilisateurs actifs</div>
                                        <div class="h4 mb-0">{{ $nombreUtilisateursActifs }}</div>
                                    </div>
                                </div>
                                <hr style="background-color: #495057; height: 2px; width: 100%;">
                                <div class="text-muted small mt-1">
                                    <span style="color: #0DF840; font-weight: bold;">{{ $nombreUtilisateursActifsCetteSemaine }}</span> cette semaine
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="stat-card position-relative d-flex flex-column align-items-end bg-white rounded-3 p-3 shadow-sm h-100">
                            <span class="position-absolute top-0 start-0 translate-middle badge d-flex align-items-center justify-content-center p-2" style="background-color: #BB1C1E; width: 45px; height: 45px; border-radius: 8px; margin-left: 40px;">
                                <img src="{{ asset('images/chart.png') }}" alt="Logo" style="max-width: 70%; max-height: 70%;">
                            </span>

                            <div class="w-100">
                                <div class="d-flex flex-column align-items-end">
                                    <div>
                                        <div class="text-muted small">Utilisateurs inactifs</div>
                                        <div class="h4 mb-0">{{$nombreUtilisateursInactifs}}</div>
                                    </div>
                                </div>
                                <hr style="background-color: #495057; height: 2px; width: 100%;">
                                <div class="text-muted small mt-1">
                                    <span style="color: #BB1C1E; font-weight: bold;">{{$nombreUtilisateursInactifsSemainepassé}}</span> par rapport à la semaine passée
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8 col-md-8 col-lg-8">
                        
                <div class="header-card d-flex justify-content-between align-items-center">
                    <div class="row justify-between" style="width: 100%">
                        <div class="col-md-6">
                            <h2 class="h4 m-4">Liste des utilisateurs</h2>
                        </div>
                        <div class="col-md-6">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-5">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Rechercher...">
                                </div>

                                <div class="col-md-7">
                                    <button type="button" class="btn btn-primary mx-2 w-80 w-md-auto" data-bs-toggle="modal" data-bs-target="#addUser">
                                        Ajouter un utilisateur
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="user-table">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="userTable">
                            <thead>
                                <tr class="table-dark">
                                    <th><input type="checkbox" class="form-check-input"></th>
                                    <th class="text-light">Utilisateur</th>
                                    <th class="text-light">Adresse email</th>
                                    <th class="text-light">Rôle</th>
                                    <th class="text-light">Statut</th>Abonnement
                                    <th class="text-light">Abonnement</th>
                                    <th class="text-light">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td><span class="role-badge admin-badge">{{ $user->role }}</span></td>
                                    <td class="status-text">
                                        @if($user->isOnline())
                                            En ligne
                                        @else
                                            Hors ligne
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#abonnementModal"
                                            data-user-id="{{ $user->id }}">
                                            Abonnement
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary action-btn me-1" type="button" data-bs-toggle="modal" data-bs-target="#modifierUserModal" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" data-user-email="{{ $user->email }}" data-user-role="{{ $user->role }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                        
                                        <button class="btn btn-sm btn-outline-danger action-btn" type="button" data-bs-toggle="modal" data-bs-target="#supprimerUserModal" data-user-id="{{ $user->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                    </div>
                    <div class="col-4 col-md-4 col-lg-4">
                        <form action="{{ route('notifications.send') }}" method="POST">
                            @csrf
                            <input type="text" name="title" placeholder="Titre" required>
                            <textarea name="message" placeholder="Message" required></textarea>
                            <select name="user_id">
                                <option value="">Tous les utilisateurs</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit">Envoyer</button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addUserLabel">Ajouter un utilisateur</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" action="{{ route('admin.utilisateur.creer') }}" method="POST">
                    @csrf

                     @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="userName" name="name" placeholder="Nom de l'utilisateur" required>
                        <label for="userName">Nom de l'utilisateur</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="userEmail" name="email" placeholder="name@example.com" required>
                        <label for="userEmail">Email de l'utilisateur</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="userPassword" name="password" placeholder="Mot de passe" required>
                        <label for="userPassword">Mot de passe</label>
                    </div>
                    <select class="form-select form-select-sm" name="role" aria-label="Sélectionner le rôle" required>
                        <option value="user" selected>Utilisateur</option>
                        <option value="admin">Admin</option>
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="addUserForm" class="btn btn-primary">Ajouter un utilisateur</button>
            </div>
        </div>
    </div>
</div>

   
    {{-- Modiier les utilisateurs --}}
<div class="modal fade" id="modifierUserModal" tabindex="-1" aria-labelledby="modifierUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modifierUserModalLabel">Modifier un utilisateur</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" id="editUserId">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="editUserName" name="name" placeholder="Nom">
                        <label for="editUserName">Nom</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="editUserEmail" name="email" placeholder="name@example.com">
                        <label for="editUserEmail">Email de l'utilisateur</label>
                    </div>
                    <select class="form-select form-select-sm" name="role" id="editUserRole" aria-label="Sélectionner le rôle">
                        <option value="">Sélectionner le rôle</option>
                        <option value="admin">Admin</option>
                        <option value="user">Utilisateur</option>
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="editUserForm" class="btn btn-primary">Sauvegarder les modifications</button>
            </div>
        </div>
    </div>
</div>

    {{-- Supprimer les utilisateurs --}}
        <div class="modal fade" id="supprimerUserModal" tabindex="-1" aria-labelledby="supprimerUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="supprimerUserModalLabel">Supprimer un utilisateur</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Voulez-vous vraiment supprimer cet utilisateur ? Cette action est irréversible.</p>
                        <form id="deleteUserForm" action="" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="user_id" id="deleteUserId">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" form="deleteUserForm" class="btn btn-danger">Supprimer l'utilisateur</button>
                    </div>
                </div>
            </div>
        </div>

        


            <!-- Modal modification de l'abonnement -->
            <div class="modal fade" id="abonnementModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('users.abonnement') }}">
                    @csrf
                    <input type="hidden" name="user_id" id="modal_user_id">

                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Attribuer un abonnement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <select name="abonnement_id" class="form-select">
                            @foreach($abonnements as $abonnement)
                                <option value="{{ $abonnement->id }}">
                                    {{ $abonnement->examen }} ({{ $abonnement->duree }} jours)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Attribuer</button>
                    </div>
                    </div>
                </form>
            </div>
            </div>
        
            




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const value = this.value.toLowerCase();
            const rows = document.querySelectorAll('#userTable tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(value) ? '' : 'none';
            });
        });

        // Script pour gérer l'affichage du menu mobile
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.querySelector('.mobile-menu-btn');
            const sidebar = document.querySelector('.sidebar');

            if (menuBtn && sidebar) {
                menuBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });

                document.addEventListener('click', function(event) {
                    if (!sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
                        sidebar.classList.remove('show');
                    }
                });
            }
        });
        
// Gérer la modale de modification
    document.addEventListener('DOMContentLoaded', function() {
        const modifierModal = document.getElementById('modifierUserModal');
        if (modifierModal) {
            modifierModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                const userId = button.getAttribute('data-user-id');
                const userName = button.getAttribute('data-user-name');
                const userEmail = button.getAttribute('data-user-email');
                const userRole = button.getAttribute('data-user-role');

                const form = modifierModal.querySelector('#editUserForm');
                const nameInput = modifierModal.querySelector('#editUserName');
                const emailInput = modifierModal.querySelector('#editUserEmail');
                const roleSelect = modifierModal.querySelector('#editUserRole');

                // Mise à jour de l'action du formulaire pour cibler la bonne route
                form.action = `/admin/utilisateurs/${userId}`;
                
                // Pré-remplissage des champs avec les données récupérées
                nameInput.value = userName;
                emailInput.value = userEmail;
                roleSelect.value = userRole; // Le script remplit le select
            });
        }
    });

        //Script pour déclecnché le modal de l'abonnement
        document.addEventListener('DOMContentLoaded', function () {
        var abonnementModal = document.getElementById('abonnementModal');
        abonnementModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; 
            var userId = button.getAttribute('data-user-id');
            document.getElementById('modal_user_id').value = userId;
        });
    });



        // // Gérer la modale de suppression
        // document.addEventListener('DOMContentLoaded', function() {
        //     const supprimerModal = document.getElementById('supprimerUserModal');
        //     supprimerModal.addEventListener('show.bs.modal', event => {
        //         const button = event.relatedTarget;
        //         const userId = button.getAttribute('data-user-id');
        //         const form = supprimerModal.querySelector('#deleteUserForm');
        //         const userIdInput = supprimerModal.querySelector('#deleteUserId');
                
        //         form.action = `/admin/users/${userId}`; // Mettez à jour avec votre route
        //         userIdInput.value = userId;
        //     });
        // });



    document.addEventListener('DOMContentLoaded', function() {
    // ... votre autre code JavaScript ...

    // Gérer la modale de suppression
    const supprimerModal = document.getElementById('supprimerUserModal');
    if (supprimerModal) {
        supprimerModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');
            const form = supprimerModal.querySelector('#deleteUserForm');
            const userIdInput = supprimerModal.querySelector('#deleteUserId');

            // Mise à jour de l'action du formulaire avec la route correcte
            form.action = `/admin/utilisateurs/${userId}`;
            userIdInput.value = userId;
        });
    }
});


    </script>
</body>

</html>



