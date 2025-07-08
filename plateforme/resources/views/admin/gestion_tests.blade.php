<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Statistiques | ExpoHub</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fb;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            background-color: #fff;
            height: 100vh;
            position: sticky;
            top: 0;
            padding: 1rem;
            box-shadow: 2px 0 6px rgba(0, 0, 0, 0.05);
        }

        .sidebar .nav-link {
            color: #333;
            font-weight: 500;
            border-radius: 8px;
            padding: 10px 12px;
        }

        .sidebar .nav-link.active {
            background-color: #2f54eb;
            color: #fff;
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

        .chart-placeholder {
            background-color: white;
            border-radius: 1rem;
            height: 300px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
        }

        .print-btn {
            background-color: #2f54eb;
            color: #fff;
            border-radius: 0.5rem;
            padding: 0.6rem 1.2rem;
            font-weight: 500;
        }

        @media (max-width: 992px) {
            .sidebar {
                position: relative;
                height: auto;
            }
        }

        /*========= TEST CARDS*/
        .test-card {
            background-color: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            width: 300px;
            min-height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .test-content {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            width: 100%;
        }

        .test-content .label {
            font-size: 1.2rem;
            margin-bottom: 10px;
            text-align: center;
        }

        .test-content .description {
            font-size: 0.95rem;
            text-align: center;
            color: #444;
            margin-bottom: 15px;
        }

        .test-content .footer i {
            cursor: pointer;
            font-size: 1rem;
            color: #666;
        }

        .test-content .footer i:hover {
            color: #000;
        }

    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 col-md-3 sidebar">
                <h5 class="mb-4 text-primary fw-bold">EXPO HUB</h5>

                <div class="d-flex align-items-center mb-4">
                    <img src="https://via.placeholder.com/40" class="rounded-circle me-2" alt="User" />
                    <div>
                        <div class="fw-bold">Maya AKAMA</div>
                        <div class="text-muted small"><i class="fas fa-chevron-down"></i></div>
                    </div>
                </div>

                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="#"><i class="fas fa-users me-2"></i> Gestion des Utilisateurs</a>
                    </li>
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
            </div>

            <!-- Main content -->
            <div class="col-lg-10 col-md-9 p-4">
                <!-- Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-auto">
                        <div class="stat-card">
                            <div class="stat-icon gray"><i class="fas fa-user"></i></div>
                            <div class="stat-content">
                                <div class="label">Utilisateurs inscrits</div>
                                <div class="count">281</div>
                                <div class="footer">Temps</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="stat-card">
                            <div class="stat-icon green"><i class="fas fa-store"></i></div>
                            <div class="stat-content">
                                <div class="label">Utilisateurs actifs</div>
                                <div class="count">128</div>
                                <div class="footer">Temps</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="stat-card">
                            <div class="stat-icon red"><i class="fas fa-chart-bar"></i></div>
                            <div class="stat-content">
                                <div class="label">Utilisateurs inactifs</div>
                                <div class="count">2,300</div>
                                <div class="footer">Temps</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="stat-card">
                            <div class="stat-icon gray"><i class="fas fa-user"></i></div>
                            <div class="stat-content">
                                <div class="label">Test effectué</div>
                                <div class="count">281</div>
                                <div class="footer">Temps</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="stat-card">
                            <div class="stat-icon green"><i class="fas fa-store"></i></div>
                            <div class="stat-content">
                                <div class="label">Taux de réussite</div>
                                <div class="count">181</div>
                                <div class="footer">Temps</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="stat-card">
                            <div class="stat-icon red"><i class="fas fa-chart-bar"></i></div>
                            <div class="stat-content">
                                <div class="label">Abandonnés</div>
                                <div class="count">100</div>
                                <div class="footer">Temps</div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row g-3 mb-4">

                    <div class="col-auto">
                        <div class="test-card">
                            <div class="test-content">
                                <div class="label fw-bold">TCF CANADA</div>
                                <div class="description">Une petite description ici pour parler du testt</div>
                                <div class="footer d-flex justify-content-end gap-2">
                                    <i class="fas fa-edit"></i>
                                    <i class="fas fa-trash-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-auto">
                        <div class="test-card">
                            <div class="test-content">
                                <div class="label fw-bold">TCF QUEBEC</div>
                                <div class="description">Une petite description ici pour parler du testt</div>
                                <div class="footer d-flex justify-content-end gap-2">
                                    <i class="fas fa-edit"></i>
                                    <i class="fas fa-trash-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-auto">
                        <div class="test-card">
                            <div class="test-content">
                                <div class="label fw-bold">TEF</div>
                                <div class="description">Une description pour expliquer le déroulement du test en France</div>
                                <div class="footer d-flex justify-content-end gap-2">
                                    <i class="fas fa-edit"></i>
                                    <i class="fas fa-trash-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-auto">
                        <div class="test-card">
                            <div class="test-content">
                                <div class="label fw-bold">DELF</div>
                                <div class="description">Détails concernant les modalités du test en Belgique</div>
                                <div class="footer d-flex justify-content-end gap-2">
                                    <i class="fas fa-edit"></i>
                                    <i class="fas fa-trash-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-auto">
                        <div class="test-card">
                            <div class="test-content">
                                <div class="label fw-bold">DALF</div>
                                <div class="description">Détails concernant les modalités du test en Belgique</div>
                                <div class="footer d-flex justify-content-end gap-2">
                                    <i class="fas fa-edit"></i>
                                    <i class="fas fa-trash-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
