<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }



        .main-content {
            padding: 10px;
            position: relative;
            /* Ajoutez cette ligne */
            z-index: 1;
            /* Valeur inférieure à celle du sidebar */
            /* ... conservez le reste de vos styles ... */
        }




        .user-table {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table thead th {
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .role-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .admin-badge {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .action-btn {
            padding: 5px 10px;
            font-size: 0.85rem;
        }

        .status-text {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .header-card {
            background-color: none;
            border-radius: 8px;
            /*box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);*/
            padding: 15px;
            margin-bottom: 20px;
        }

        .card-row {
            width: 100%;
            max-width: 100%;
            /* Même largeur que la table */
            gap: 1rem;
        }

        .stat-card {
            background-color: #fff;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            min-width: 260px;
            flex: 0;
            min-width: 240px;
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            flex-shrink: 0;
        }

        .stat-icon.gray {
            background-color: #b0b0b0;
        }

        .stat-icon.green {
            background-color: #00e676;
        }

        .stat-icon.red {
            background-color: #e74c3c;
        }

        .stat-content .label {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .stat-content .count {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .stat-content .footer {
            font-size: 0.8rem;
            color: #aaa;
        }

        #searchInput {
            width: 250px;
        }

        /* Styles pour le sidebar responsive */
        .sidebar {
            background-color: white;
            height: 100vh;
            position: sticky;
            top: 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            z-index: 1050;
            /* Augmentez cette valeur (Bootstrap navbar a 1030) */
            /* ... conservez le reste de vos styles ... */
        }

        /* Cache le sidebar sur mobile par défaut */
        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                bottom: 0;
                z-index: 999;
                transform: translateX(-100%);
                width: 250px;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .mobile-menu-btn {
                display: block !important;
            }
        }

        /* Assure que le contenu principal ne soit pas caché par le sidebar */
        .main-content {
            transition: margin-left 0.3s ease;
        }

        @media (min-width: 992px) {
            .mobile-menu-btn {
                display: none !important;
            }
        }

        .stat-card {
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .badge {
            width: 60px;
            height: 60px;
            font-size: 0.7rem;
            padding: 0.35em 0.65em;

        }
    </style>
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
            <span class="position-absolute top-0 start-0 translate-middle badge d-flex align-items-center justify-content-center p-2"
                  style="background-color: #707070; width: 45px; height: 45px; border-radius: 8px; margin-left: 40px;">
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
            <span class="position-absolute top-0 start-0 translate-middle badge d-flex align-items-center justify-content-center p-2"
                  style="background-color: #0DF840; width: 45px; height: 45px; border-radius: 8px; margin-left: 40px;">
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
            <span class="position-absolute top-0 start-0 translate-middle badge d-flex align-items-center justify-content-center p-2"
                  style="background-color: #BB1C1E; width: 45px; height: 45px; border-radius: 8px; margin-left: 40px;">
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
                                    <input type="text" id="searchInput" class="form-control"
                                        placeholder="Rechercher...">
                                </div>

                                <!-- Bouton d'ajout -->
                                <div class="col-md-7">
                                    <button type="button" class="btn btn-primary mx-2 w-80 w-md-auto"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Ajouter un utilisateur
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="d-flex align-items-center">

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter un test</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="">
                                            <div class="form-floating mb-3">
                                                <input type="email" class="form-control" id="floatingInput"
                                                    placeholder="name@example.com">
                                                <label for="floatingInput">mail de l'utilisateur</label>

                                            </div>
                                            <select class="form-select form-select-sm"
                                                aria-label="Small select example">
                                                <option selected>Selectionner le role</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Annuler</button>
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
                                <!-- Utilisateur fictif répété -->
                                <!-- Répéter manuellement pour l'exemple -->
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td>M. Hervé</td>
                                    <td>herve.ei@example.com</td>
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
