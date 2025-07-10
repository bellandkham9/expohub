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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

        .audio-preview {
            margin-top: 15px;
        }

        .audio-preview audio {
            width: 100%;
            margin-bottom: 10px;
        }

        .form-section {
            margin-top: 30px;
        }

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
            <div class="col-md-3 col-lg-2 sidebar p-3">
                @include('admin.partials.side_bar')
            </div>
            <!-- Main content -->
            <div class="col-lg-10 col-md-9 p-4">
                <div class="container py-5">
                    <h2 class="mb-4">Importer un PDF – Compréhension écrite</h2>
    <p class="text-muted">Le PDF doit contenir : texte de lecture, question, 4 propositions, et réponse correcte.</p>


                    <!-- Upload Box -->
                    <div id="uploadBox" class="upload-box" role="button">
                        <div id="uploadContent" class="text-center">
                            <div class="fw-semibold mb-2">Cliquez ou déposez un fichier ici</div>
                            <div class="text-center">
                                <i class="fas fa-file-pdf fa-2x mt-2"></i>
                            </div>

                        </div>
                        <input type="file" id="fileInput" class="d-none" accept="pdf/*" multiple />
                    </div>

                    <!-- Aperçus audio -->
                    <div id="audioPreview" class="audio-preview"></div>

                    <!-- Formulaire des métadonnées -->
                    <div class="form-section">
                        <div class="mb-3">
                            <label for="transcription" class="form-label">Transcription du contenu pdf</label>
                            <textarea class="form-control" id="transcription" rows="3" placeholder="Description du contenu..."></textarea>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="text-end mt-3">
                        <button class="submit-btn">Envoyer les données</button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Upload Script -->
        <script>
            const uploadBox = document.getElementById('uploadBox');
            const fileInput = document.getElementById('fileInput');
            const uploadContent = document.getElementById('uploadContent');
            const audioPreview = document.getElementById('audioPreview');

            uploadBox.addEventListener('click', () => fileInput.click());

            fileInput.addEventListener('change', handleFiles);

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

            function handleFiles() {
                const files = fileInput.files;
                audioPreview.innerHTML = ''; // reset
                if (files.length > 0) {
                    uploadContent.classList.add('d-none');
                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        if (file.type.startsWith('audio/')) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const audio = document.createElement('audio');
                                audio.controls = true;
                                audio.src = e.target.result;
                                audioPreview.appendChild(audio);
                            };
                            reader.readAsDataURL(file);
                        }
                    }
                }
            }
        </script>

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
