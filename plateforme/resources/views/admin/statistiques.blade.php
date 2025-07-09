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

        .card-row {
            width: 100%;
            max-width: 100%;
            /* Même largeur que la table */
            gap: 1rem;
            justify-content: space-between;
            align-content: start;
        }


    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('admin.partials.side_bar')
            <!-- Main content -->
            <div class="col-lg-10 col-md-9 p-4">
                <!-- Cards -->
                <div class="row g-3 mb-4 card-row">
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

                <!-- Chart Section -->
                <div class="chart-placeholder mb-4">
                    <h6 class="fw-bold mb-2">Statistics</h6>
                    <p class="text-muted small mb-3">May 2022</p>
                    <!-- Replace below with actual chart -->
                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                        (Graphique ici)
                    </div>
                </div>

                <!-- Print Button -->
                <div class="text-end">
                    <button class="print-btn">
                        <i class="fas fa-print me-2"></i> Imprimer un PDF
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
