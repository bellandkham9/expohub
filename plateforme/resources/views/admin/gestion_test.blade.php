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
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div
                            class="stat-card position-relative d-flex flex-column align-items-end bg-white rounded-3 p-3 shadow-sm h-100">
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
                                        <div class="h4 mb-0">{{ $totalTests }}</div>
                                    </div>
                                </div>
                                <hr style="background-color: #495057; height: 2px; width: 100%;">
                                <div class="text-muted small mt-1">
                                    <span style="color: #707070; font-weight: bold;">{{ $testsLastWeek }}</span> que la
                                    semaine passée
                                </div>
                            </div>
                        </div>
                    </div>
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
                                        <p class="text-muted small">Abonnements en cours</p>
                                        <p class="h4 mb-0">{{ $totalAbonnements }}</p>
                                    </div>
                                </div>
                                <hr style="background-color: #495057; height: 2px; width: 100%;">
                                <div class="text-muted small mt-1">
                                    <span style="color: #0DF840; font-weight: bold;">+{{ $totalAbonnementsMois }}</span>
                                    ce mois
                                </div>
                            </div>
                        </div>
                    </div>
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
                                        <div class="text-muted small">Tests abandonné</div>
                                        <div class="h4 mb-0">{{ $testsAbandonnes }}</div>
                                    </div>
                                </div>
                                <hr style="background-color: #495057; height: 2px; width: 100%;">
                                <div class="text-muted small mt-1">
                                    <span
                                        style="color: #BB1C1E; font-weight: bold;">{{ $testsAbandonnesSemaine }}</span>
                                    Cette Semaine
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="header-card d-flex justify-content-between align-items-center">
                    <div class="row justify-between" style="width: 100%">
                        <div class="col-md-5">
                            <h2 class="h4">Liste des Tests</h2>
                        </div>
                        <div class="col-md-7">
                            <div class="row g-3 align-items-center">
                                <div class="d-flex col-md-12">
                                    <input type="text" id="searchInput" class="form-control"
                                        placeholder="Rechercher...">
                                        <button style="background-color:#224194; color: white;" type="button"
                                        class="btn  mx-2 w-80 w-md-auto" data-bs-toggle="modal"
                                        data-bs-target="#ajoutTestModal">
                                        Ajouter un test
                                    </button>
                                </div>
                               {{--  <div class="col-md-5">
                                    <button style="background-color:#224194; color: white;" type="button"
                                        class="btn  mx-2 w-80 w-md-auto" data-bs-toggle="modal"
                                        data-bs-target="#ajoutTestModal">
                                        Ajouter un test
                                    </button>
                                </div> --}}
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row g-4 justify-content-center m-4">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @foreach ($tests as $test)
                        <div class="col-6 col-md-6 col-lg-4">
                            <div class="test-card text-center h-100 p-4">
                                <h3 class="test-title h5 mb-3">{{ $test->examen }}</h3>
                                <p class="mb-4 text-muted">{{ $test->description ?? 'Pas de description disponible' }}
                                </p>
                                <div class="footer d-flex justify-content-end gap-3">
                                    <button type="button" class="btn btn-sm"
                                        onclick="window.location.href='{{ route('train.dashboard', ['test_id' => $test->id]) }}'">
                                        <i class="fas fa-brain me-2" title="Choisir discipline"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm edit-btn" data-bs-toggle="modal"
                                        data-bs-target="#editModal" data-test-id="{{ $test->id }}"
                                        data-test-name="{{ $test->examen }}"
                                        data-test-desc="{{ $test->description }}">
                                        <i class="fas fa-edit" title="Modifier"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm delete-btn" data-bs-toggle="modal"
                                        data-bs-target="#supprimerTestModal" data-test-id="{{ $test->id }}">
                                        <i class="fas fa-trash-alt text-danger" title="Supprimer"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="row m-4">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="">
                            <h3>Liste des abonnements</h3>
                            <!-- Bouton pour ouvrir modal d'ajout -->
                            <button style="background-color:#224194; color: white;" class="btn  mb-3 mt-3"
                                data-bs-toggle="modal" data-bs-target="#ajoutAbonnementModal">
                                + Ajouter Abonnement
                            </button>

                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            <div class="table-responsive">
                                <table id="tableAbonnement" class="table table-hover mb-0">
                                    <thead>
                                        <tr class="table-dark white">
                                            <th><input type="checkbox" class="form-check-input"></th>
                                            <th>Nom du plan</th>
                                            <th>Examen</th>
                                            <th>Prix</th>
                                            <th>Durée (jours)</th>
                                            <th>Description</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($abonnements as $abonnement)
                                            <tr>
                                                <td><input type="checkbox" class="form-check-input"></td>
                                                <td>{{ $abonnement->nom_du_plan }}</td>
                                                <td>{{ $abonnement->examen ?? '-' }}</td>
                                                <td>{{ $abonnement->prix }} $</td>
                                                <td>{{ $abonnement->duree }}</td>
                                                <td>{{ $abonnement->description }}</td>
                                                <td>

                                                    <button class="btn btn-sm btn-warning edit-abonnement-btn"
                                                        data-bs-toggle="modal" data-bs-target="#editAbonnementModal"
                                                        data-id="{{ $abonnement->id }}"
                                                        data-nom="{{ $abonnement->nom_du_plan }}"
                                                        data-prix="{{ $abonnement->prix }}"
                                                        data-duree="{{ $abonnement->duree }}"
                                                        data-desc="{{ $abonnement->description }}"
                                                        data-test="{{ $abonnement->examen }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <button class="btn btn-sm btn-danger delete-abonnement-btn"
                                                        data-bs-toggle="modal" data-bs-target="#deleteAbonnementModal"
                                                        data-id="{{ $abonnement->id }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

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
                    <form action="{{ route('tests.store') }}" method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" name="examen" class="form-control" id="testNameAjout"
                                placeholder="Nom du test">
                            <label for="testNameAjout">Nom du test *</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="description" id="testDescAjout" placeholder="Description"
                                style="height: 100px"></textarea>
                            <label for="testDescAjout">Description</label>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button style="background-color: #224194; color: white;" type="submit" id="AjoutBtn" class="btn">Ajouter</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Modifier le test</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editTestId" name="id">
                        <div class="form-floating mb-3">
                            <input type="text" name="examen" class="form-control" id="editTestName"
                                placeholder="Nom du test">
                            <label for="editTestName">Nom du test *</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="description" id="editTestDesc" placeholder="Description"
                                style="height: 100px"></textarea>
                            <label for="editTestDesc">Description</label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button style="background-color:#224194; color: white;" type="submit" class="btn "
                                id="saveEditBtn">Enregistrer</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="supprimerTestModal" tabindex="-1" aria-labelledby="supprimerTestLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="supprimerTestLabel">Supprimer le test</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Voulez-vous vraiment supprimer ce Test ? Cette action est irréversible.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Supprimer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Ajout -->
    <div class="modal fade" id="ajoutAbonnementModal" tabindex="-1" aria-labelledby="ajoutAbonnementLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('abonnements.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter un abonnement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nom du plan *</label>
                            <input type="text" name="nom_du_plan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Examen *</label>
                            <select name="examen" class="form-control" required>
                                @foreach ($tests as $test)
                                    <option value="{{ $test->examen }}">{{ $test->examen }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Prix *</label>
                            <input type="number" name="prix" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Durée (jours) *</label>
                            <input type="number" name="duree" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button style="background-color: #224194;color: white;" type="submit" class="btn ">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edition -->
    <div class="modal fade" id="editAbonnementModal" tabindex="-1" aria-labelledby="editAbonnementLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editAbonnementForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Modifier un abonnement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nom du plan *</label>
                            <input type="text" name="nom_du_plan" id="editNomPlan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Examen *</label>
                            <select name="examen" id="editTestType" class="form-control" required>
                                @foreach ($tests as $test)
                                    <option value="{{ $test->examen }}">{{ $test->examen }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Prix *</label>
                            <input type="number" name="prix" id="editPrix" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Durée (jours) *</label>
                            <input type="number" name="duree" id="editDuree" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" id="editDescription" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button style="background-color: #224194;color: white;" type="submit" class="btn">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Suppression -->
    <div class="modal fade" id="deleteAbonnementModal" tabindex="-1" aria-labelledby="deleteAbonnementLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteAbonnementForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title">Supprimer un abonnement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Voulez-vous vraiment supprimer cet abonnement ?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script pour la recherche
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const value = this.value.toLowerCase();
            const cards = document.querySelectorAll('.test-card');
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(value) ? 'block' : 'none';
            });
        });

        // Script pour la gestion du sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.querySelector('.mobile-menu-btn');
            const sidebar = document.querySelector('.sidebar');
            if (menuBtn && sidebar) {
                menuBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
                document.addEventListener('click', function(event) {
                    if (!sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
                        sidebar.classList.remove('show');
                    }
                });
            }
        });

        // Script pour gérer les modaux de modification et de suppression de manière dynamique
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                let id = this.dataset.testId;
                document.getElementById('editTestId').value = id;
                document.getElementById('editTestName').value = this.dataset.testName;
                document.getElementById('editTestDesc').value = this.dataset.testDesc;



                let form = document.getElementById('editForm'); // le vrai formulaire
                form.action = "/tests/" + id; // route update
            });

        });

        document.getElementById('saveEditBtn').addEventListener('click', function() {
            document.getElementById('editForm').submit();
        });




        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                let id = this.dataset.testId;
                let form = document.getElementById('deleteForm'); // il faut renommer le form
                form.action = "/tests/" + id;
            });
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            document.getElementById('deleteForm').submit();
        });


        document.getElementById('AjoutBtn').addEventListener('click', function() {
            document.querySelector('#ajoutTestModal form').submit();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Édition
            document.querySelectorAll('.edit-abonnement-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    let id = this.dataset.id;
                    document.getElementById('editNomPlan').value = this.dataset.nom;
                    document.getElementById('editPrix').value = this.dataset.prix;
                    document.getElementById('editDuree').value = this.dataset.duree;
                    document.getElementById('editDescription').value = this.dataset.desc;
                    document.getElementById('editTestType').value = this.dataset.test;

                    let form = document.getElementById('editAbonnementForm');
                    form.action = "/abonnements/" + id; // route update
                });
            });

            // Suppression
            document.querySelectorAll('.delete-abonnement-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    let id = this.dataset.id;
                    let form = document.getElementById('deleteAbonnementForm');
                    form.action = "/abonnements/" + id; // route delete
                });
            });
        });
    </script>

</body>

</html>
