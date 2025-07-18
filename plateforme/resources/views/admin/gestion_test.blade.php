<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     @vite(['resources/css/admin-gestion-user.css'])
    {{-- <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .main-content {
            padding: 10px;
            position: relative;
            /* Ajoutez cette ligne */

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

        .test-card {
            box-shadow: 1px 1px 1px 1px gainsboro;
            background-color: white;
            border-radius: 30px;
        }
    </style> --}}
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
                        <div class="stat-card position-relative d-flex flex-column align-items-end bg-white rounded-3 p-3 shadow-sm h-100">
                            <span class="position-absolute top-0 start-0 translate-middle badge d-flex align-items-center justify-content-center p-2" style="background-color: #0DF840; width: 45px; height: 45px; border-radius: 8px; margin-left: 40px;">
                                <img src="{{ asset('images/house.png') }}" alt="Logo" style="max-width: 70%; max-height: 70%;">
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
                        <div class="stat-card position-relative d-flex flex-column align-items-end bg-white rounded-3 p-3 shadow-sm h-100">
                            <span class="position-absolute top-0 start-0 translate-middle badge d-flex align-items-center justify-content-center p-2" style="background-color: #BB1C1E; width: 45px; height: 45px; border-radius: 8px; margin-left: 40px;">
                                <img src="{{ asset('images/chart.png') }}" alt="Logo" style="max-width: 70%; max-height: 70%;">
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

                <div class="header-card d-flex justify-content-between align-items-center">
                    <div class="row justify-between" style="width: 100%">
                        <div class="col-md-6">
                            <h2 class="h4 m-4">Liste des Tests</h2>
                        </div>
                        <div class="col-md-6">
                            <div class="row g-3 align-items-center">
                                <!-- Champ de recherche -->
                                <div class="col-md-5">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Rechercher...">
                                </div>

                                <!-- Bouton d'ajout -->
                                <div class="col-md-7">
                                    <button type="button" class="btn btn-primary mx-2 w-80 w-md-auto" data-bs-toggle="modal" data-bs-target="#ajoutTestModal">
                                        Ajouter un test
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="row g-4 justify-content-center m-4">
                    <!-- Carte TCF CANADA 1 -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="test-card text-center h-100 p-4">
                            <h3 class="test-title h5 mb-3">TCF CANADA</h3>
                            <p class="mb-4 text-muted">Une petite description ici pour parler du test!</p>
                            <div class="footer d-flex justify-content-end gap-3">
                                <!-- Button Choisir Discipline -->
                                <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#choisirDisciplineModal">
                                    <i class="fas fa-list" title="Choisir discipline"></i>
                                </button>

                                <!-- Button Modifier -->
                                <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#editModalTCFCanada1">
                                    <i class="fas fa-edit" title="Modifier"></i>
                                </button>

                                <!-- Button Supprimer -->
                                <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#supprimerTestTCFCanada1">
                                    <i class="fas fa-trash-alt text-danger" title="Supprimer"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Carte TCF QUEBEC 1 -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="test-card text-center h-100 p-4">
                            <h3 class="test-title h5 mb-3">TCF QUEBEC</h3>
                            <p class="mb-4 text-muted">Une petite description ici pour parler du test!</p>
                            <div class="footer d-flex justify-content-end gap-3">
                                <!-- Button Choisir Discipline -->
                                <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#choisirDisciplineModal">
                                    <i class="fas fa-list" title="Choisir discipline"></i>
                                </button>

                                <!-- Button Modifier -->
                                <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#editModalTCFCanada1">
                                    <i class="fas fa-edit" title="Modifier"></i>
                                </button>

                                <!-- Button Supprimer -->
                                <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#supprimerTestTCFCanada1">
                                    <i class="fas fa-trash-alt text-danger" title="Supprimer"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Carte TCF CANADA 2 -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="test-card text-center h-100 p-4">
                            <h3 class="test-title h5 mb-3">TCF CANADA</h3>
                            <p class="mb-4 text-muted">Une petite description ici pour parler du test!</p>
                            <div class="footer d-flex justify-content-end gap-3">
                                <!-- Button Choisir Discipline -->
                                <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#choisirDisciplineModal">
                                    <i class="fas fa-list" title="Choisir discipline"></i>
                                </button>

                                <!-- Button Modifier -->
                                <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#editModalTCFCanada1">
                                    <i class="fas fa-edit" title="Modifier"></i>
                                </button>

                                <!-- Button Supprimer -->
                                <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#supprimerTestTCFCanada1">
                                    <i class="fas fa-trash-alt text-danger" title="Supprimer"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Carte TCF QUEBEC 2 -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="test-card text-center h-100 p-4">
                            <h3 class="test-title h5 mb-3">TCF QUEBEC</h3>
                            <p class="mb-4 text-muted">Une petite description ici pour parler du test!</p>
                            <div class="footer d-flex justify-content-end gap-3">
                                <!-- Button Choisir Discipline -->
                                <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#choisirDisciplineModal">
                                    <i class="fas fa-list" title="Choisir discipline"></i>
                                </button>

                                <!-- Button Modifier -->
                                <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#editModalTCFCanada1">
                                    <i class="fas fa-edit" title="Modifier"></i>
                                </button>

                                <!-- Button Supprimer -->
                                <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#supprimerTestTCFCanada1">
                                    <i class="fas fa-trash-alt text-danger" title="Supprimer"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Carte TCF CANADA 3 -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="test-card text-center h-100 p-4">
                            <h3 class="test-title h5 mb-3">TCF CANADA</h3>
                            <p class="mb-4 text-muted">Une petite description ici pour parler du test!</p>
                            <div class="footer d-flex justify-content-end gap-3">
                                <!-- Button Choisir Discipline -->
                                <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#choisirDisciplineModal">
                                    <i class="fas fa-list" title="Choisir discipline"></i>
                                </button>

                                <!-- Button Modifier -->
                                <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#editModalTCFCanada1">
                                    <i class="fas fa-edit" title="Modifier"></i>
                                </button>

                                <!-- Button Supprimer -->
                                <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#supprimerTestTCFCanada1">
                                    <i class="fas fa-trash-alt text-danger" title="Supprimer"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal : Choix discipline -->
                    <div class="modal fade" id="choisirDisciplineModal" tabindex="-1" aria-labelledby="choisirDisciplineLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content p-4 text-center">
                                <div class="modal-header border-0">
                                    <h5 class="modal-title w-100" id="choisirDisciplineLabel">
                                        Choisissez la discipline</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                </div>

                                <div class="row g-4 justify-content-center mr-6">

                                    <!-- Carte TCF QUEBEC 1 -->
                                    <div class="btn col-12 col-md-6 col-lg-6" onclick="window.location.href='{{ route('expression_ecrite') }}'">
                                        <div class="test-card text-center h-100 p-4" style="background-color: #F8B70D;">
                                            <div class="test-icon mb-3 mt-4">
                                                <img src="{{ asset('images/lecture.png') }}" alt="Logo" style="height: 40px;">
                                            </div>
                                            <h3 style="color: white;" class="test-title h5 mb-3">Compréhension Écrite
                                            </h3>
                                        </div>
                                    </div>


                                    <!-- Carte TCF CANADA 2 -->
                                    <div class="btn col-12 col-md-6 col-lg-6" onclick="window.location.href='{{ route('expression_ecrite') }}'">
                                        <div class="test-card text-center h-100 p-4" style="background-color: #FF3B30;">
                                            <div class="test-icon mb-3">
                                                <img src="{{ asset('images/ecoute.png') }}" alt="Logo" style="height: 40px;">
                                            </div>
                                            <h3 style="color: white" class="test-title h5 mb-3"> Compréhension Orale
                                            </h3>

                                        </div>
                                    </div>

                                    <!-- Carte TCF QUEBEC 2 -->
                                    <div class="btn col-12 col-md-6 col-lg-6" onclick="window.location.href='{{ route('expression_ecrite') }}'">
                                        <div class="test-card text-center h-100 p-4" style="background-color: #224194;">
                                            <div class="test-icon mb-3">
                                                <img src="{{ asset('images/orale.png') }}" alt="Logo" style="height: 40px;">
                                            </div>
                                            <h3 style="color: white" class="test-title h5 mb-3">Expression Orale</h3>

                                        </div>
                                    </div>

                                    <!-- Carte TCF CANADA 3 -->
                                    <div class="btn col-12 col-md-6 col-lg-6" onclick="window.location.href='{{ route('expression_ecrite') }}'">
                                        <div class="test-card text-center h-100 p-4" style="background-color: #249DB8;">
                                            <div class="test-icon mb-3">
                                                <img src="{{ asset('images/ecrite.png') }}" alt="Logo" style="height: 40px;">
                                            </div>
                                            <h3 style="color: white" class="test-title h5 mb-3"> Expression Ecrite
                                            </h3>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Modal : Modifier -->
                    <div class="modal fade" id="editModalTCFCanada1" tabindex="-1" aria-labelledby="editModalLabelTCFCanada1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editModalLabelTCFCanada1">Modifier le test</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="testNameTCFCanada1" placeholder="Nom du test" value="TCF CANADA">
                                            <label for="testNameTCFCanada1">Nom du test *</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" id="testDescTCFCanada1" placeholder="Description" style="height: 100px">Une petite description ici pour parler du test!</textarea>
                                            <label for="testDescTCFCanada1">Description</label>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    <button class="btn btn-primary">Enregistrer</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal : Supprimer -->
                    <div class="modal fade" id="supprimerTestTCFCanada1" tabindex="-1" aria-labelledby="supprimerTestLabelTCFCanada1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="supprimerTestLabelTCFCanada1">Supprimer le test
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Voulez-vous vraiment supprimer ce Test ? Cette action est irréversible.
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <button class="btn btn-danger">Supprimer</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal : Ajout Test -->
                    <div class="modal fade" id="ajoutTestModal" tabindex="-1" aria-labelledby="ajoutTestLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content p-4">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ajoutTestLabel">
                                        <i id="disciplineIcon" class="fas fa-plus"></i> Ajouter un test
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="testNameAjout" placeholder="Nom du test">
                                            <label for="testNameAjout">Nom du test *</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" id="testDescAjout" placeholder="Description" style="height: 100px"></textarea>
                                            <label for="testDescAjout">Description</label>
                                        </div>
                                        <input type="hidden" id="disciplineTypeAjout" name="discipline">
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <button class="btn btn-primary">Ajouter</button>
                                </div>
                            </div>
                        </div>
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
