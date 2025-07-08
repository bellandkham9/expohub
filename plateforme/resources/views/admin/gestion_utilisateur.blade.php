<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
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
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .main-content {
            padding: 20px;
        }
        .user-table {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
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
        .dev-badge {
            background-color: #e8f5e9;
            color: #388e3c;
        }
        .designer-badge {
            background-color: #f3e5f5;
            color: #8e24aa;
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
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            padding: 15px;
            margin-bottom: 20px;
        }
        @media (max-width: 992px) {
            .sidebar {
                height: auto;
                position: relative;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-3">
                <h4 class="mb-4">Menu</h4>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a class="nav-link active" href="#"><i class="fas fa-chart-bar me-2"></i> Statistiques</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="#"><i class="fas fa-tasks me-2"></i> Gestion des tests</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-calendar-alt me-2"></i> Gestion des activités</a>
                    </li>
                </ul>

                <hr class="my-4">

                <h5 class="mb-3">Listation en outre</h5>
                <div class="mb-3">
                    <small class="text-muted">Lité</small>
                    <div class="fw-bold">+8 Cette semaine</div>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Utilisateurs</small>
                    <div class="fw-bold">+3 Cette semaine</div>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Total</small>
                    <div class="fw-bold">2,300</div>
                </div>

                <hr class="my-4">

                <button class="btn btn-primary w-100 mt-3">
                    <i class="fas fa-plus me-2"></i> Ajouter un utilisateur
                </button>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <!-- Header Cards -->
                <div class="header-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="h4 mb-0">Liste des utilisateurs</h2>
                        <div>
                            <button class="btn btn-outline-danger me-2">
                                <i class="fas fa-trash-alt me-1"></i> Supprimer
                            </button>
                            <button class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Nouveau
                            </button>
                        </div>
                    </div>
                </div>

                <!-- User Table -->
                <div class="user-table">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th width="40"></th>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; margin-right: 10px;">
                                                <i class="fas fa-user text-muted"></i>
                                            </div>
                                            <span>Moyen ANAMA</span>
                                        </div>
                                    </td>
                                    <td>mysq@kuma.com</td>
                                    <td><span class="role-badge admin-badge">Administrateur</span></td>
                                    <td class="status-text">En ligne le 03 Juillet 2025</td>
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
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; margin-right: 10px;">
                                                <i class="fas fa-user text-muted"></i>
                                            </div>
                                            <span>Liam CARTER</span>
                                        </div>
                                    </td>
                                    <td>liam.carter@example.com</td>
                                    <td><span class="role-badge dev-badge">Développeur</span></td>
                                    <td class="status-text">En ligne le 01 Aout 2025</td>
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
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; margin-right: 10px;">
                                                <i class="fas fa-user text-muted"></i>
                                            </div>
                                            <span>Sofia MARTINEZ</span>
                                        </div>
                                    </td>
                                    <td>sofia.martinez@example.com</td>
                                    <td><span class="role-badge designer-badge">Designer</span></td>
                                    <td class="status-text">En ligne le 15 Juillet 2025</td>
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
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; margin-right: 10px;">
                                                <i class="fas fa-user text-muted"></i>
                                            </div>
                                            <span>Noah SMITH</span>
                                        </div>
                                    </td>
                                    <td>noah.smith@example.com</td>
                                    <td><span class="role-badge admin-badge">Chef de projet</span></td>
                                    <td class="status-text">En ligne le 22 Juillet 2025</td>
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
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; margin-right: 10px;">
                                                <i class="fas fa-user text-muted"></i>
                                            </div>
                                            <span>Emily JOHNSON</span>
                                        </div>
                                    </td>
                                    <td>emily.johnson@example.com</td>
                                    <td><span class="role-badge dev-badge">Analyste</span></td>
                                    <td class="status-text">En ligne le 30 Juin 2025</td>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>