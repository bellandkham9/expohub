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
                    <h3 class="fw-bold mb-3">Ajouter des audios d'entraînement</h3>
                    <p class="text-muted">Téléversez un ou plusieurs fichiers audio pour alimenter votre modèle IA.
                        Formats acceptés : MP3, WAV, OGG.</p>

                    <!-- Upload Box -->
                    <div id="uploadBox" class="upload-box" role="button">
                        <div id="uploadContent" class="text-center">
                            <div class="fw-semibold mb-2">Cliquez ou déposez ici vos audios</div>
                            <i class="fas fa-microphone-alt fa-2x text-secondary"></i>
                        </div>
                        <input type="file" id="fileInput" class="d-none" accept="audio/*" multiple />
                    </div>

                    <!-- Aperçus audio -->
                    <div id="audioPreview" class="audio-preview"></div>

                    <!-- Formulaire des métadonnées -->
                    <div class="form-section">


                        <div class="mb-3">
                            <label for="transcription" class="form-label">Transcription du contenu audio</label>
                            <textarea class="form-control" id="transcription" rows="3" placeholder="Écrivez ce que dit l’audio ici..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="langue" class="form-label">Langue parlée</label>
                            <select class="form-select" id="langue" required>
                                <option value="">-- Sélectionnez --</option>
                                <option value="fr">Français</option>
                                <option value="en">Anglais</option>
                                <option value="ln">Lingala</option>
                                <option value="sw">Swahili</option>
                            </select>
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
</body>

</html>
