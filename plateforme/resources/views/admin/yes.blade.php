<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard Utilisateurs</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    .sidebar {
      min-height: 100vh;
      background-color: #f8f9fa;
      transition: all 0.3s;
    }

    .sidebar .nav-link.active {
      background-color: #0d6efd;
      color: #fff !important;
    }

    .sidebar-collapsed {
      transform: translateX(-100%);
    }

    @media (max-width: 991px) {
      .sidebar {
        position: fixed;
        z-index: 1040;
        width: 220px;
      }

      .content {
        margin-left: 0 !important;
      }
    }

    .card-summary {
      border-left: 5px solid #0d6efd;
    }
  </style>
</head>
<body>
  <div class="d-flex">
    <!-- Sidebar -->
    <nav id="sidebarMenu" class="sidebar d-lg-block bg-white shadow p-3">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h5>📘 EXPO HUB</h5>
        <button class="btn btn-sm d-lg-none" onclick="toggleSidebar()">✖</button>
      </div>
      <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action active">Gestion des Utilisateurs</a>
        <a href="#" class="list-group-item list-group-item-action">Statistiques</a>
        <a href="#" class="list-group-item list-group-item-action">Gestion des tests</a>
        <a href="#" class="list-group-item list-group-item-action">Gestion des activités</a>
      </div>
    </nav>

    <!-- Main content -->
    <div class="content flex-grow-1 p-3">
      <!-- Topbar -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <button class="btn btn-outline-primary d-lg-none" onclick="toggleSidebar()">☰</button>
        <input type="text" class="form-control w-50" placeholder="🔍 Chercher..." />
        <img src="https://randomuser.me/api/portraits/women/44.jpg" class="rounded-circle" width="40" />
      </div>

      <!-- Summary cards -->
      <div class="row g-3 mb-4">
        <div class="col-md-4">
          <div class="card card-summary shadow-sm">
            <div class="card-body">
              <h6 class="text-muted">Utilisateurs inscrits</h6>
              <h3>281</h3>
              <small class="text-success">+55 que la semaine passée</small>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-summary shadow-sm">
            <div class="card-body">
              <h6 class="text-muted">Utilisateurs actifs</h6>
              <h3>128</h3>
              <small class="text-success">+1 par rapport à hier</small>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-summary shadow-sm">
            <div class="card-body">
              <h6 class="text-muted">Utilisateurs inactifs</h6>
              <h3>2,300</h3>
              <small class="text-danger">+3 cette semaine</small>
            </div>
          </div>
        </div>
      </div>

      <!-- Table -->
      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Liste des utilisateurs</h5>
          <div class="d-flex gap-2">
            <input type="search" class="form-control" placeholder="Chercher un utilisateur…" />
            <button class="btn btn-primary">Ajouter un utilisateur</button>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th>Utilisateur</th>
                <th>Adresse email</th>
                <th>Rôle</th>
                <th>Statut</th>
                <th>Options</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Maya AKAMA</td>
                <td>maya@kama.com</td>
                <td>Administrateur</td>
                <td>En ligne le 03 Juillet 2025</td>
                <td><a href="#"><i class="bi bi-pencil-square"></i></a></td>
              </tr>
              <tr>
                <td>Liam CARTER</td>
                <td>liam.carter@example.com</td>
                <td>Développeur</td>
                <td>En ligne le 01 Août 2025</td>
                <td><a href="#"><i class="bi bi-pencil-square"></i></a></td>
              </tr>
              <!-- Ajoute d'autres lignes ici -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script>
    function toggleSidebar() {
      document.getElementById('sidebarMenu').classList.toggle('sidebar-collapsed');
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
