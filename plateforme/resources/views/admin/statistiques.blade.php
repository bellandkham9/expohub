<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        #btn-print {
            background-color: #224194;
            padding: 10px;
            color: white;
            border: none;
            box-shadow: 1px 1px 1px gainsboro;
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

        .test-card {
            box-shadow: 1px 1px 1px 1px gainsboro;
            background-color: white;
            border-radius: 30px;
        }

        .statistics-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin: 0 auto;
            width: 95%;
         
        }

        .statistics-header {
            padding: 20px 25px;
            border-bottom: 1px solid #eaeaea;
        }

        .statistics-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .statistics-subtitle {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .statistics-header {
            padding: 20px 25px;
            border-bottom: 1px solid #eaeaea;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .statistics-title-group {
            display: flex;
            flex-direction: column;
        }

        .statistics-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .statistics-subtitle {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .chart-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sort-label {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .sort-select {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 7px 15px;
            background-color: white;
            color: #495057;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .chart-container {
            padding: 25px;
            position: relative;
        }

        .chart-canvas-container {
            height: 300px;
            position: relative;
            padding: 20px 40px 40px 40px;
        }

        .y-axis-labels {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px 0 40px 0;
            width: 40px;
            text-align: right;
            padding-right: 10px;
            color: #6c757d;
            font-size: 0.85rem;
        }

        .x-axis-labels {
            position: absolute;
            bottom: 0;
            left: 40px;
            right: 0;
            display: flex;
            justify-content: space-between;
            padding: 0 20px 5px 20px;
            color: #6c757d;
            font-size: 0.85rem;
        }

        .grid-line {
            position: absolute;
            left: 40px;
            right: 0;
            height: 1px;
            background-color: #eaeaea;
        }

        .legend {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 25px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .legend-color {
            width: 14px;
            height: 14px;
            border-radius: 50%;
        }

        .legend-label {
            font-size: 0.9rem;
            color: #495057;
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
                        <div
                            class="stat-card position-relative d-flex flex-column align-items-end bg-white rounded-3 p-3 shadow-sm h-100">
                            <!-- Badge -->
                            <span
                                class="position-absolute top-0 start-0 translate-middle badge d-flex align-items-center justify-content-center p-2"
                                style="background-color: #707070; width: 45px; height: 45px; border-radius: 8px; margin-left: 40px;">
                                <img src="{{ asset('images/user.png') }}" alt="Logo"
                                    style="max-width: 70%; max-height: 70%;">
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
                        <div
                            class="stat-card position-relative d-flex flex-column align-items-end bg-white rounded-3 p-3 shadow-sm h-100">
                            <span
                                class="position-absolute top-0 start-0 translate-middle badge d-flex align-items-center justify-content-center p-2"
                                style="background-color: #0DF840; width: 45px; height: 45px; border-radius: 8px; margin-left: 40px;">
                                <img src="{{ asset('images/house.png') }}" alt="Logo"
                                    style="max-width: 70%; max-height: 70%;">
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
                        <div
                            class="stat-card position-relative d-flex flex-column align-items-end bg-white rounded-3 p-3 shadow-sm h-100">
                            <span
                                class="position-absolute top-0 start-0 translate-middle badge d-flex align-items-center justify-content-center p-2"
                                style="background-color: #BB1C1E; width: 45px; height: 45px; border-radius: 8px; margin-left: 40px;">
                                <img src="{{ asset('images/chart.png') }}" alt="Logo"
                                    style="max-width: 70%; max-height: 70%;">
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
                                    <span style="color: #BB1C1E; font-weight: bold;">-5</span> par rapport à la semaine
                                    passée
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-5 m-3">
                    <!-- Stat Card 1 -->
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div
                            class="stat-card position-relative d-flex flex-column align-items-end bg-white rounded-3 p-3 shadow-sm h-100">
                            <!-- Badge -->
                            <span
                                class="position-absolute top-0 start-0 translate-middle badge d-flex align-items-center justify-content-center p-2"
                                style="background-color: #707070; width: 45px; height: 45px; border-radius: 8px; margin-left: 40px;">
                                <img src="{{ asset('images/user.png') }}" alt="Logo"
                                    style="max-width: 70%; max-height: 70%;">
                            </span>

                            <div class="w-100">
                                <div class="d-flex flex-column align-items-end">
                                    <div>
                                        <div class="text-muted small">Tests effectué</div>
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
                        <div
                            class="stat-card position-relative d-flex flex-column align-items-end bg-white rounded-3 p-3 shadow-sm h-100">
                            <span
                                class="position-absolute top-0 start-0 translate-middle badge d-flex align-items-center justify-content-center p-2"
                                style="background-color: #0DF840; width: 45px; height: 45px; border-radius: 8px; margin-left: 40px;">
                                <img src="{{ asset('images/house.png') }}" alt="Logo"
                                    style="max-width: 70%; max-height: 70%;">
                            </span>

                            <div class="w-100">
                                <div class="d-flex flex-column align-items-end">
                                    <div>
                                        <div class="text-muted small">Taux de réussite</div>
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
                        <div
                            class="stat-card position-relative d-flex flex-column align-items-end bg-white rounded-3 p-3 shadow-sm h-100">
                            <span
                                class="position-absolute top-0 start-0 translate-middle badge d-flex align-items-center justify-content-center p-2"
                                style="background-color: #BB1C1E; width: 45px; height: 45px; border-radius: 8px; margin-left: 40px;">
                                <img src="{{ asset('images/chart.png') }}" alt="Logo"
                                    style="max-width: 70%; max-height: 70%;">
                            </span>

                            <div class="w-100">
                                <div class="d-flex flex-column align-items-end">
                                    <div>
                                        <div class="text-muted small">Abandonné</div>
                                        <div class="h4 mb-0">2300</div>
                                    </div>
                                </div>
                                <hr style="background-color: #495057; height: 2px; width: 100%;">
                                <div class="text-muted small mt-1">
                                    <span style="color: #BB1C1E; font-weight: bold;">-5</span> par rapport à la semaine
                                    passée
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <!-- Carte TCF CANADA 1 -->
                    <div class="col-12 col-md-12 col-lg-12">
                          <div class="statistics-container">
                                <div class="statistics-header">
                                    <div class="statistics-title-group">
                                        <div class="statistics-title">Statistics</div>
                                        <div class="statistics-subtitle">May 2022</div>
                                    </div>

                                    <div class="chart-controls">
                                        <span class="sort-label">Sort by:</span>
                                        <select class="sort-select">
                                            <option>Monthly</option>
                                            <option>Weekly</option>
                                            <option>Yearly</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="chart-container">
                                    <div class="chart-canvas-container">
                                        <!-- Y-axis labels -->
                                        <div class="y-axis-labels">
                                            <span>2500</span>
                                            <span>2000</span>
                                            <span>1500</span>
                                            <span>1000</span>
                                            <span>500</span>
                                            <span>0</span>
                                        </div>

                                        <!-- Grid lines -->
                                        <div class="grid-line" style="top: 0%;"></div>
                                        <div class="grid-line" style="top: 20%;"></div>
                                        <div class="grid-line" style="top: 40%;"></div>
                                        <div class="grid-line" style="top: 60%;"></div>
                                        <div class="grid-line" style="top: 80%;"></div>
                                        <div class="grid-line" style="top: 100%;"></div>

                                        <!-- Chart canvas -->
                                        <canvas id="statisticsChart"></canvas>

                                        <!-- X-axis labels -->
                                        <div class="x-axis-labels">
                                            <span>Jan</span>
                                            <span>Feb</span>
                                            <span>Mar</span>
                                            <span>Apr</span>
                                            <span>May</span>
                                            <span>Jun</span>
                                            <span>Jul</span>
                                            <span>Aug</span>
                                            <span>Sep</span>
                                            <span>Oct</span>
                                            <span>Nov</span>
                                            <span>Dec</span>
                                        </div>
                                    </div>

                                    <!-- Legend -->
                                    <div class="legend">
                                        <div class="legend-item">
                                            <div class="legend-color" style="background-color: #4e73df;"></div>
                                            <span class="legend-label">2022</span>
                                        </div>
                                        <div class="legend-item">
                                            <div class="legend-color" style="background-color: #1cc88a;"></div>
                                            <span class="legend-label">2021</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    </div>
                    <!-- Print Button -->

                    <div class="text-end m-4">
                        <button id="btn-print" class="print-btn">
                            <i class="fas fa-print me-2"></i> Imprimer un PDF
                        </button>
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

    <script>
        // Configuration du graphique
        const ctx = document.getElementById('statisticsChart').getContext('2d');

        // Données du graphique
        const data = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: '2022',
                data: [1200, 1900, 1700, 2200, 2500, 2100, 1800, 1500, 2000, 2300, 2400, 1500],
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                pointBackgroundColor: '#4e73df',
                pointBorderColor: '#fff',
                pointRadius: 5,
                pointHoverRadius: 7,
                tension: 0.4,
                fill: false,
                borderWidth: 3,
            }, {
                label: '2021',
                data: [1000, 1600, 1400, 1800, 2000, 1700, 1500, 1300, 1600, 1900, 2100, 1600],
                borderColor: '#1cc88a',
                backgroundColor: 'rgba(28, 200, 138, 0.1)',
                pointBackgroundColor: '#1cc88a',
                pointBorderColor: '#fff',
                pointRadius: 5,
                pointHoverRadius: 7,
                tension: 0.4,
                fill: false,
                borderWidth: 3,
            }]
        };

        // Options du graphique
        const options = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    display: false,
                    grid: {
                        display: false
                    }
                },
                y: {
                    display: false,
                    min: 0,
                    max: 2500,
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#333',
                    bodyColor: '#333',
                    borderColor: '#ddd',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: true,
                    boxPadding: 5,
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.parsed.y}`;
                        }
                    }
                }
            }
        };

        // Création du graphique
        const statisticsChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: options
        });

        // Gestion du changement de tri
        document.querySelector('.sort-select').addEventListener('change', function() {
            // Animation de changement
            statisticsChart.data.datasets.forEach(dataset => {
                dataset.data = dataset.data.map(() => Math.floor(Math.random() * 2500));
            });
            statisticsChart.update();
        });
    </script>
</body>

</html>
