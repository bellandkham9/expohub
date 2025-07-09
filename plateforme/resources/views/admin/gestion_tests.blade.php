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


        .btn-add-test {
            white-space: nowrap;
            padding-left: 1.2rem;
            padding-right: 1.2rem;
            min-width: 190px;
        }

        .modal-title i {
            margin-right: 0.5rem;
        }

        /* ========= TEST CARDS ========== */


        @media (max-width: 992px) {
            .sidebar {
                position: relative;
                height: auto;
            }

            .card-row {
                justify-content: center;
            }
        }

        .test-card {
            background-color: #fff;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 1rem;
            transition: all 0.2s ease;
            height: 100%;
        }

        .test-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        }

        .test-content .footer i {
            cursor: pointer;
            font-size: 1.1rem;
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
            @include('admin.partials.side_bar')

            <!-- Main content -->
            <div class="col-lg-10 col-md-9 p-4">
                <!-- Stat Cards -->
                <div class="row g-3 mb-4">
                    <div class="card-row d-flex justify-content-between flex-wrap mb-4">
                        <div class="stat-card">
                            <div class="stat-icon gray"><i class="fas fa-user"></i></div>
                            <div class="stat-content">
                                <div class="label">Test effectuer</div>
                                <div class="count">281</div>
                                <div class="footer">Temps</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon green"><i class="fas fa-store"></i></div>
                            <div class="stat-content">
                                <div class="label">Taux de réussite</div>
                                <div class="count">128</div>
                                <div class="footer">Temps</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon red"><i class="fas fa-chart-bar"></i></div>
                            <div class="stat-content">
                                <div class="label">Abandonnés</div>
                                <div class="count">2,300</div>
                                <div class="footer">Temps</div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Tests Cards -->
                <div class="col">
                    <div class="header-card d-flex justify-content-between align-items-center">
                        <h2 class="h4 mb-0">Liste des tests</h2>
                        <div class="d-flex align-items-center">
                            <input type="text" id="searchInput" class="form-control me-3" placeholder="Rechercher...">
                            <button type="button" class="btn btn-primary btn-add-test" data-bs-toggle="modal" data-bs-target="#choisirDisciplineModal">
                                <i class="fas fa-plus me-1"></i> Ajouter un Test
                            </button>

                            <!-- Modal : Choix discipline -->
                            <div class="modal fade" id="choisirDisciplineModal" tabindex="-1" aria-labelledby="choisirDisciplineLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content p-4 text-center">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title w-100" id="choisirDisciplineLabel">Choisissez la discipline</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                        </div>
                                        <div class="row g-3 px-3 py-2">
                                            <div class="col-6">
                                                <div class="card choose-discipline shadow-sm p-3 text-center bg-warning text-white" data-bs-toggle="modal" data-bs-target="#ajoutTestModal" data-bs-dismiss="modal" data-discipline="Compréhension Écrite" data-icon="fa-user-graduate" style="cursor: pointer;">
                                                    <i class="fas fa-user-graduate fa-2x mb-2"></i>
                                                    <div>Compréhension Écrite</div>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="card choose-discipline shadow-sm p-3 text-center bg-danger text-white" data-bs-toggle="modal" data-bs-target="#ajoutTestModal" data-bs-dismiss="modal" data-discipline="Compréhension Orale" data-icon="fa-headphones-alt" style="cursor: pointer;">
                                                    <i class="fas fa-headphones-alt fa-2x mb-2"></i>
                                                    <div>Compréhension Orale</div>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="card choose-discipline shadow-sm p-3 text-center bg-primary text-white" data-bs-toggle="modal" data-bs-target="#ajoutTestModal" data-bs-dismiss="modal" data-discipline="Expression Orale" data-icon="fa-microphone" style="cursor: pointer;">
                                                    <i class="fas fa-microphone fa-2x mb-2"></i>
                                                    <div>Expression Orale</div>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="card choose-discipline shadow-sm p-3 text-center bg-info text-white" data-bs-toggle="modal" data-bs-target="#ajoutTestModal" data-bs-dismiss="modal" data-discipline="Expression Écrite" data-icon="fa-pen-nib" style="cursor: pointer;">
                                                    <i class="fas fa-pen-nib fa-2x mb-2"></i>
                                                    <div>Expression Écrite</div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Modal : Ajout test -->
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
                                                    <input type="text" class="form-control" id="testName" placeholder="Nom du test">
                                                    <label for="testName">Nom du test *</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <textarea class="form-control" id="testDesc" placeholder="Description" style="height: 100px"></textarea>
                                                    <label for="testDesc">Description</label>
                                                </div>
                                                <input type="hidden" id="disciplineType" name="discipline">
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

                <!-- Liste des cartes de tests -->
                <div class="row gy-4 mt-3">
                    <div class="col-md-6 col-lg-4">
                        <div class="test-card">
                            <div class="test-content">
                                <div class="label fw-bold text-primary text-center">TCF CANADA</div>
                                <div class="description text-center">Une petite description ici pour parler du test</div>
                                <div class="footer d-flex justify-content-end gap-3">
                                    <!-- Button Modifier -->
                                    <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <i class="fas fa-edit" title="Modifier"></i>
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control" id="testName" placeholder="Nom du test">
                                                            <label for="testName">Nom du test *</label>
                                                        </div>
                                                        <div class="form-floating mb-3">
                                                            <textarea class="form-control" id="testDesc" placeholder="Description" style="height: 100px"></textarea>
                                                            <label for="testDesc">Description</label>
                                                        </div>
                                                        <input type="hidden" id="disciplineType" name="discipline">
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                    <!-- Button Supprimer -->
                                    <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#supprimerTest">
                                        <i class="fas fa-trash-alt text-danger" title="Supprimer"></i>
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="supprimerTest" tabindex="-1" aria-labelledby="supprimerTest" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="supprimerTest">Supprimer un test</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>
                                                        Voulez-vous vraiment supprimer ce Test ? Cette action est irréversible.
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <button type="button" class="btn btn-danger">Supprimer le Test</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="test-card">
                            <div class="test-content">
                                <div class="label fw-bold text-primary text-center">TCF QUÉBEC</div>
                                <div class="description text-center">Une petite description ici pour parler du test</div>
                                <div class="footer d-flex justify-content-end gap-3">
                                    <i class="fas fa-edit" title="Modifier"></i>
                                    <i class="fas fa-trash-alt text-danger" title="Supprimer"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="test-card">
                            <div class="test-content">
                                <div class="label fw-bold text-primary text-center">TEF</div>
                                <div class="description text-center">Une description pour expliquer le déroulement du test en France</div>
                                <div class="footer d-flex justify-content-end gap-3">
                                    <i class="fas fa-edit" title="Modifier"></i>
                                    <i class="fas fa-trash-alt text-danger" title="Supprimer"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="test-card">
                            <div class="test-content">
                                <div class="label fw-bold text-primary text-center">DELF</div>
                                <div class="description text-center">Détails concernant les modalités du test en Belgique</div>
                                <div class="footer d-flex justify-content-end gap-3">
                                    <i class="fas fa-edit" title="Modifier"></i>
                                    <i class="fas fa-trash-alt text-danger" title="Supprimer"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="test-card">
                            <div class="test-content">
                                <div class="label fw-bold text-primary text-center">DALF</div>
                                <div class="description text-center">Détails concernant les modalités du test en Belgique</div>
                                <div class="footer d-flex justify-content-end gap-3">
                                    <i class="fas fa-edit" title="Modifier"></i>
                                    <i class="fas fa-trash-alt text-danger" title="Supprimer"></i>
                                </div>
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

    <!-- Script pour actualiser le titre -->
    <script>
        document.querySelectorAll('.choose-discipline').forEach(btn => {
            btn.addEventListener('click', function() {
                const discipline = this.getAttribute('data-discipline');
                const iconClass = this.getAttribute('data-icon');
                document.getElementById('ajoutTestLabel').innerHTML = `<i id="disciplineIcon" class="fas ${iconClass}"></i> ${discipline}`;
                document.getElementById('disciplineType').value = discipline;
            });
        });

    </script>
</body>
</html>
