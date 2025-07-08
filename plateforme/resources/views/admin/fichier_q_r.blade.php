<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestion des Tests | ExpoHub</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

    <style>
        body {
            background-color: #f8f9fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

        .upload-box {
            border: 2px dashed #ccc;
            background-color: white;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            color: #444;
            cursor: pointer;
            position: relative;
            transition: border-color 0.3s, background-color 0.3s;
            min-height: 200px;
        }

        .upload-box.dragover {
            border-color: #0d6efd;
            background-color: #f0f8ff;
        }

        .submit-btn {
            background-color: #0d6efd;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background-color: #0b5ed7;
        }

        .preview-image {
            max-width: 100%;
            max-height: 160px;
            margin-top: 10px;
            border-radius: 10px;
            object-fit: contain;
        }

        @media (max-width: 992px) {
            .sidebar {
                position: relative;
                height: auto;
            }
        }

    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 col-md-3 sidebar">
                <h5 class="mb-4 text-primary fw-bold">ExpoHub</h5>
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
                        <a class="nav-link" href="#"><i class="fas fa-chart-bar me-2"></i> Statistiques</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link active" href="#"><i class="fas fa-tasks me-2"></i> Gestion des tests</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-calendar-alt me-2"></i> Gestion des activités</a>
                    </li>
                </ul>
            </div>

            <!-- Main content -->
            <div class="col-lg-10 col-md-9 p-4">
                <!-- Title & Description -->
                <h4 class="fw-bold">Apportez des nouvelles données pour générez plus de test</h4>
                <p class="text-muted" style="max-width: 700px;">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eu finibus neque. In sit amet tempor mauris. Suspendisse consectetur lobortis lacus, sed malesuada dui elementum id.
                </p>

                <!-- Upload Title -->
                <h5 class="mt-4">Fichier question et réponses</h5>

                <!-- Upload box -->
                <div id="uploadBox" class="upload-box mt-3" role="button">
                    <div id="uploadContent" class="text-center">
                        <div class="fw-semibold mb-2">Télécharger<br>l’image descriptive</div>
                        <i class="fas fa-cloud-upload-alt fa-2x text-secondary"></i>
                    </div>
                    <img id="previewImage" src="#" alt="Aperçu" class="preview-image d-none" />
                    <input type="file" id="fileInput" class="d-none" accept="image/*" />
                </div>
                <!-- Submit button -->
                <div class="mt-4 text-end">
                    <button class="submit-btn">Envoyez</button>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Script UPLOAD BUTTON-->
        <script>
            const uploadBox = document.getElementById('uploadBox');
            const fileInput = document.getElementById('fileInput');
            const previewImage = document.getElementById('previewImage');
            const uploadContent = document.getElementById('uploadContent');

            // Open file explorer
            uploadBox.addEventListener('click', () => fileInput.click());

            // When file selected
            fileInput.addEventListener('change', handleFiles);

            // Drag & Drop
            uploadBox.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadBox.classList.add('dragover');
            });

            uploadBox.addEventListener('dragleave', () => {
                uploadBox.classList.remove('dragover');
            });

            uploadBox.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadBox.classList.remove('dragover');
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    handleFiles();
                }
            });

            // Show preview
            function handleFiles() {
                const file = fileInput.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewImage.classList.remove('d-none');
                        uploadContent.classList.add('d-none'); // Hide icon & label
                    };
                    reader.readAsDataURL(file);
                }
            }

        </script>
</body>
</html>
