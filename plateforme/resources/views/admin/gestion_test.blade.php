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
                        <div class="stat-card position-relative d-flex flex-column align-items-end bg-white rounded-3 p-3 shadow-sm h-100">
                            <span class="position-absolute top-0 start-0 translate-middle badge d-flex align-items-center justify-content-center p-2" style="background-color: #707070; width: 45px; height: 45px; border-radius: 8px; margin-left: 40px;">
                                <img src="{{ asset('images/user.png') }}" alt="Logo" style="max-width: 70%; max-height: 70%;">
                            </span>
                            <div class="w-100">
                                <div class="d-flex flex-column align-items-end">
                                    <div>
                                        <div class="text-muted small">Tests effectué</div>
                                        <div class="h4 mb-0">{{$totalTests}}</div>
                                    </div>
                                </div>
                                <hr style="background-color: #495057; height: 2px; width: 100%;">
                                <div class="text-muted small mt-1">
                                    <span style="color: #707070; font-weight: bold;">{{$testsLastWeek}}</span> que la semaine passée
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="stat-card position-relative d-flex flex-column align-items-end bg-white rounded-3 p-3 shadow-sm h-100">
                            <span class="position-absolute top-0 start-0 translate-middle badge d-flex align-items-center justify-content-center p-2" style="background-color: #0DF840; width: 45px; height: 45px; border-radius: 8px; margin-left: 40px;">
                                <img src="{{ asset('images/house.png') }}" alt="Logo" style="max-width: 70%; max-height: 70%;">
                            </span>
                            <div class="w-100">
                                <div class="d-flex flex-column align-items-end">
                                    <div>
                                        <p class="text-muted small">Abonnements en cours</p>
                                        <p class="h4 mb-0">{{$totalAbonnements}}</p>
                                    </div>
                                </div>
                                <hr style="background-color: #495057; height: 2px; width: 100%;">
                                <div class="text-muted small mt-1">
                                    <span style="color: #0DF840; font-weight: bold;">+{{$totalAbonnementsMois}}</span> ce mois
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="stat-card position-relative d-flex flex-column align-items-end bg-white rounded-3 p-3 shadow-sm h-100">
                            <span class="position-absolute top-0 start-0 translate-middle badge d-flex align-items-center justify-content-center p-2" style="background-color: #BB1C1E; width: 45px; height: 45px; border-radius: 8px; margin-left: 40px;">
                                <img src="{{ asset('images/chart.png') }}" alt="Logo" style="max-width: 70%; max-height: 70%;">
                            </span>
                            <div class="w-100">
                                <div class="d-flex flex-column align-items-end">
                                    <div>
                                        <div class="text-muted small">Tests abandonné</div>
                                        <div class="h4 mb-0">{{$testsAbandonnes}}</div>
                                    </div>
                                </div>
                                <hr style="background-color: #495057; height: 2px; width: 100%;">
                                <div class="text-muted small mt-1">
                                    <span style="color: #BB1C1E; font-weight: bold;">{{$testsAbandonnesSemaine}}</span> Cette Semaine
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="header-card d-flex justify-content-between align-items-center">
                    <div class="row justify-between" style="width: 100%">
                        <div class="col-md-5">
                            <h2 class="h4 m-4">Liste des Tests</h2>
                        </div>
                        <div class="col-md-4">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-5">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Rechercher...">
                                </div>
                                <div class="col-md-7">
                                    <button type="button" class="btn btn-primary mx-2 w-80 w-md-auto" data-bs-toggle="modal" data-bs-target="#ajoutTestModal">
                                        Ajouter un test
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="row g-3 align-items-center">
                                <button type="button" class="btn btn-success mx-2 w-80 w-md-auto" onclick="window.location.href='{{ route('train.dashboard') }}'">
                                    Generate Data
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row g-4 justify-content-center m-4">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="test-card text-center h-100 p-4">
                            <h3 class="test-title h5 mb-3">TCF CANADA</h3>
                            <p class="mb-4 text-muted">Une petite description ici pour parler du test!</p>
                            <div class="footer d-flex justify-content-end gap-3">
                                <button type="button" class="btn btn-sm"  onclick="window.location.href='{{ route('train.dashboard') }}'">
                                    <i class="fas fa-list" title="Choisir discipline"></i>
                                </button>
                                <button type="button" class="btn btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editModal" data-test-id="1" data-test-name="TCF CANADA" data-test-desc="Une petite description ici pour parler du test!">
                                    <i class="fas fa-edit" title="Modifier"></i>
                                </button>
                                <button type="button" class="btn btn-sm delete-btn" data-bs-toggle="modal" data-bs-target="#supprimerTestModal" data-test-id="1">
                                    <i class="fas fa-trash-alt text-danger" title="Supprimer"></i>
                                </button>
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
    
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Modifier le test</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editTestId" name="id">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="editTestName" placeholder="Nom du test">
                            <label for="editTestName">Nom du test *</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="editTestDesc" placeholder="Description" style="height: 100px"></textarea>
                            <label for="editTestDesc">Description</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" id="saveEditBtn">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="supprimerTestModal" tabindex="-1" aria-labelledby="supprimerTestLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="supprimerTestLabel">Supprimer le test</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Voulez-vous vraiment supprimer ce Test ? Cette action est irréversible.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Supprimer</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="choisirDisciplineModal" tabindex="-1" aria-labelledby="choisirDisciplineLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
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
        document.addEventListener('DOMContentLoaded', function() {
            const editModal = document.getElementById('editModal');
            const deleteModal = document.getElementById('supprimerTestModal');

            // Gérer le modal de modification
            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const testId = button.getAttribute('data-test-id');
                const testName = button.getAttribute('data-test-name');
                const testDesc = button.getAttribute('data-test-desc');

                const modalTestId = editModal.querySelector('#editTestId');
                const modalTestName = editModal.querySelector('#editTestName');
                const modalTestDesc = editModal.querySelector('#editTestDesc');

                modalTestId.value = testId;
                modalTestName.value = testName;
                modalTestDesc.value = testDesc;
            });

            // Gérer le modal de suppression
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const testId = button.getAttribute('data-test-id');
                
                // Vous pouvez stocker l'ID du test pour la suppression
                const confirmBtn = deleteModal.querySelector('#confirmDeleteBtn');
                confirmBtn.setAttribute('data-test-id', testId);
            });
            
            // Écouter le clic sur le bouton de confirmation de suppression
            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                const testId = this.getAttribute('data-test-id');
                // Ici, vous faites l'appel AJAX ou la redirection pour supprimer le test avec cet ID
                console.log('Suppression du test avec l\'ID :', testId);
                // Fermer le modal après l'action
                const modalInstance = bootstrap.Modal.getInstance(deleteModal);
                modalInstance.hide();
            });
        });
    </script>
</body>
</html>