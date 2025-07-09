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

        .sidebar {
            background-color: white;
            height: 100vh;
            position: sticky;
            top: 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .main-content {
            padding: 20px;
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

        @media (max-width: 992px) {
            .sidebar {
                height: auto;
                position: relative;
            }
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

    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            @include('admin.partials.side_bar')

            <div class="col-md-9 col-lg-10 main-content">
                <!-- Stat Cards -->
                <div class="row g-3 mb-4">
                    <div class="card-row d-flex justify-content-between flex-wrap mb-4">
                        <div class="stat-card">
                            <div class="stat-icon gray"><i class="fas fa-user"></i></div>
                            <div class="stat-content">
                                <div class="label">Utilisateurs inscrits</div>
                                <div class="count">281</div>
                                <div class="footer">Temps</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon green"><i class="fas fa-store"></i></div>
                            <div class="stat-content">
                                <div class="label">Utilisateurs actifs</div>
                                <div class="count">128</div>
                                <div class="footer">Temps</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon red"><i class="fas fa-chart-bar"></i></div>
                            <div class="stat-content">
                                <div class="label">Utilisateurs inactifs</div>
                                <div class="count">2,300</div>
                                <div class="footer">Temps</div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="header-card d-flex justify-content-between align-items-center">
                    <h2 class="h4 mb-0">Liste des utilisateurs</h2>
                    <div class="d-flex align-items-center">
                        <input type="text" id="searchInput" class="form-control me-3" placeholder="Rechercher...">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fas fa-plus me-1"></i> Ajouter un utilisateur
                        </button>
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
                                    <th class="text-light">Nom</th>
                                    <th class="text-light">Email</th>
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
</body>
</html>
