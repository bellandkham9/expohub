<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .main-content {
            padding: 20px;
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

        @media (max-width: 992px) {
            .sidebar {
                height: auto;
                position: relative;
            }
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

    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            @include('admin.partials.side_bar')

            <div class="col-md-9 col-lg-10 main-content">
                Gestion des Activités
                <ul>
                <li><a href="{{route('model_examen')}}">Model examen</a></li>
                <li><a href="{{route('fichier_q_r')}}">Fichier Question et Réponses</a></li>
                <li><a href="{{route('model_question')}}">Model Questions</a></li>
                 <li><a href="{{route('model_reponse')}}">Model Réponses</a></li>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
