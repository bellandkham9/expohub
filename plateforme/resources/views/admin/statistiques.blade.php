<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
     @vite(['resources/css/admin-stats.css','resources/js/admin-stats.js'])
    
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
</body>

</html>
