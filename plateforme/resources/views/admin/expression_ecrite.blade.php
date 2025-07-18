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
     @vite(['resources/css/admin-entrainement.css'])

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
                    <h3 class="fw-bold mb-3">Ajouter un dialogue(en pdf) d'entraînement</h3>
                    <p class="text-muted">Téléversez un ou plusieurs fichiers pdf pour alimenter votre modèle IA.
                        Formats acceptés : PDF.</p>

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

