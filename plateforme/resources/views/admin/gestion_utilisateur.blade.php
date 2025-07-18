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

                <div class="row g-5 m-3">
                    <!-- Stat Card 1 -->
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="stat-card position-relative d-flex flex-column align-items-end bg-white rounded-3 p-3 shadow-sm h-100">
                            <!-- Badge -->
                            <span class="position-absolute top-0 start-0 translate-middle badge d-flex align-items-center justify-content-center p-2" style="background-color: #707070; width: 45px; height: 45px; border-radius: 8px; margin-left: 40px;">
                                <img src="{{ asset('images/user.png') }}" alt="Logo" style="max-width: 70%; max-height: 70%;">
                            </span>

                            <div class="w-100">
                                <div class="d-flex flex-column align-items-end">
                                    <div>
                                        <div class="text-muted small">Utilisateurs inscrits</div>
                                        <div class="h4 mb-0">281</div>
                                    </div>
                                </div>
                                <hr style="background-color: #495057; height: 2px; width: 100%;">
                                <div class="text-muted small mt-1">
                                    <span style="color: #707070; font-weight: bold;">+55</span> que la semaine passée
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stat Card 2 -->
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="stat-card position-relative d-flex flex-column align-items-end bg-white rounded-3 p-3 shadow-sm h-100">
                            <span class="position-absolute top-0 start-0 translate-middle badge d-flex align-items-center justify-content-center p-2" style="background-color: #0DF840; width: 45px; height: 45px; border-radius: 8px; margin-left: 40px;">
                                <img src="{{ asset('images/house.png') }}" alt="Logo" style="max-width: 70%; max-height: 70%;">
                            </span>

                            <div class="w-100">
                                <div class="d-flex flex-column align-items-end">
                                    <div>
                                        <div class="text-muted small">Utilisateurs actifs</div>
                                        <div class="h4 mb-0">128</div>
                                    </div>
                                </div>
                                <hr style="background-color: #495057; height: 2px; width: 100%;">
                                <div class="text-muted small mt-1">
                                    <span style="color: #0DF840; font-weight: bold;">+10</span> cette semaine
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stat Card 3 -->
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="stat-card position-relative d-flex flex-column align-items-end bg-white rounded-3 p-3 shadow-sm h-100">
                            <span class="position-absolute top-0 start-0 translate-middle badge d-flex align-items-center justify-content-center p-2" style="background-color: #BB1C1E; width: 45px; height: 45px; border-radius: 8px; margin-left: 40px;">
                                <img src="{{ asset('images/chart.png') }}" alt="Logo" style="max-width: 70%; max-height: 70%;">
                            </span>

                            <div class="w-100">
                                <div class="d-flex flex-column align-items-end">
                                    <div>
                                        <div class="text-muted small">Utilisateurs inactifs</div>
                                        <div class="h4 mb-0">2300</div>
                                    </div>
                                </div>
                                <hr style="background-color: #495057; height: 2px; width: 100%;">
                                <div class="text-muted small mt-1">
                                    <span style="color: #BB1C1E; font-weight: bold;">-5</span> par rapport à la semaine passée
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="header-card d-flex justify-content-between align-items-center">
                    <div class="row justify-between" style="width: 100%">
                        <div class="col-md-6">
                            <h2 class="h4 m-4">Liste des utilisateurs</h2>
                        </div>
                        <div class="col-md-6">
                            <div class="row g-3 align-items-center">
                                <!-- Champ de recherche -->
                                <div class="col-md-5">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Rechercher...">
                                </div>

                                <!-- Bouton d'ajout -->
                                <div class="col-md-7">
                                    <button type="button" class="btn btn-primary mx-2 w-80 w-md-auto" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Ajouter un utilisateur
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="d-flex align-items-center">

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter un test</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="">
                                            <div class="form-floating mb-3">
                                                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                                                <label for="floatingInput">mail de l'utilisateur</label>

                                            </div>
                                            <select class="form-select form-select-sm" aria-label="Small select example">
                                                <option selected>Selectionner le role</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <button type="button" class="btn btn-primary">Ajouter un utilisateur</button>
                                    </div>
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
                                    <th class="text-light">Statut</th>
                                    <th class="text-light">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td>M. Hervé</td>
                                    <td>herve.ei@example.com</td>
                                    <td><span class="role-badge admin-badge">Admin</span></td>
                                    <td class="status-text">En ligne le 09 Juillet 2025</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary action-btn me-1" type="button" data-bs-toggle="modal" data-bs-target="#modifier_utilisateur">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="modifier_utilisateur" tabindex="-1" aria-labelledby="modifier_utilisateur" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="modifier_utilisateur">Modifier un utilisateur</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="">
                                                            <div class="form-floating mb-3">
                                                                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                                                                <label for="floatingInput">mail de l'utilisateur</label>

                                                            </div>
                                                            <select class="form-select form-select-sm" aria-label="Small select example">
                                                                <option selected>Selectionner le role</option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                        <button type="button" class="btn btn-primary">Modifier l'utilisateur</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <button class="btn btn-sm btn-outline-danger action-btn" type="button" data-bs-toggle="modal" data-bs-target="#supprimerUser">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="supprimerUser" tabindex="-1" aria-labelledby="supprimerUser" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="supprimerUser">Supprimer un utilisateur</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>
                                                            Voulez-vous vraiment supprimer cet utilisateur ? Cette action est irréversible.
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                        <button type="button" class="btn btn-danger">Supprimer l'utilisateur</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td>M. Fodjo</td>
                                    <td>fodjo.ei@example.com</td>
                                    <td><span class="role-badge admin-badge">Admin</span></td>
                                    <td class="status-text">En ligne le 09 Juillet 2025</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary action-btn me-1">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger action-btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td>Mme Rell</td>
                                    <td>rell.ei@example.com</td>
                                    <td><span class="role-badge admin-badge">Admin</span></td>
                                    <td class="status-text">En ligne le 09 Juillet 2025</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary action-btn me-1">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger action-btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td>Maya AKAMA</td>
                                    <td>maya.akama@example.com</td>
                                    <td><span class="role-badge admin-badge">Admin</span></td>
                                    <td class="status-text">En ligne le 09 Juillet 2025</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary action-btn me-1">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger action-btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td>Karl trafi</td>
                                    <td>karl.trafi@example.com</td>
                                    <td><span class="role-badge admin-badge">Admin</span></td>
                                    <td class="status-text">En ligne le 09 Juillet 2025</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary action-btn me-1">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger action-btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td>Belland K</td>
                                    <td>belland.k@example.com</td>
                                    <td><span class="role-badge admin-badge">Admin</span></td>
                                    <td class="status-text">En ligne le 09 Juillet 2025</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary action-btn me-1">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger action-btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td>Wonder NG</td>
                                    <td>wonder.ng@example.com</td>
                                    <td><span class="role-badge admin-badge">Admin</span></td>
                                    <td class="status-text">En ligne le 09 Juillet 2025</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary action-btn me-1">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger action-btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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

    </script>
    <script>
        // Script pour gérer l'affichage du menu mobile
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.querySelector('.mobile-menu-btn');
            const sidebar = document.querySelector('.sidebar');

            menuBtn.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });

            // Ferme le menu quand on clique à l'extérieur
            document.addEventListener('click', function(event) {
                if (!sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            });
        });

    </script>
</body>

</html>
