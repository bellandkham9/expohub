<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>TCF Canada - Expression Écrite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    @vite(['resources/css/expression_ecrite.css', 'resources/css/myExpressionEcrite.css'])
   
</head>

<body>
    <div class="container py-3">
        <div class="test-container">
            <div class="row g-2 justify-content-between align-items-center mb-4">
                <div class="col-md-2 text-center">
                    <div class="alert alert-info mb-0">Temps restant : <span id="timer">60:00</span></div>
                </div>
                <div class="col-md-8 text-center">
                    <h3>TCF CANADA, Expression Orale</h3>
                </div>
                <div class="col-md-2 text-center">
                    <button onclick="abandonnerTest()" class="btn btn-danger">
                        <i class="fas fa-times-circle me-2"></i> Abandonner
                    </button>
                </div>
            </div>

            <div id="main-content" class="card mb-4 main-content">
                <div class="d-flex gap-3 p-2">
                    <div class="boutons-container d-flex flex-wrap">
                        @foreach ($taches as $q)
                            <button
                                class="btn tache-btn1 {{ $q->id == $tacheActive->id ? 'btn-tache-active' : 'btn-tache-inactive' }}"
                                data-numero="{{ $q->numero }}" data-tache-id="{{ $q->id }}">
                                Tâche {{ $q->numero }}
                            </button>
                        @endforeach
                    </div>


                </div>

                <div class="card-body indication mt-7" id="indications">

                    <h5><strong>Indications</strong></h5>
                    <button class="btn" id="speak-button"><img src="{{ asset('images/volume.png') }}" width="32" alt=""></button>
                    <div class="p-2" style="width: 60%; height: 10vh; overflow-y: scroll; margin: 0 auto;">
                        <p style="text-align: justify" id="text-input">{{ $tacheActive->consigne }}</p>
                    </div>
                    <p>{{ $tacheActive->contexte_texte }}</p>
                    <div class="consigne">
                        <p style="text-align: justify">{{ $tacheActive->contexte }}</p>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <audio id="audioPreview" controls class="d-none mt-2"></audio>
                    </div>
                </div>
            </div>

            <div id="audioContainer" class="d-flex justify-content-center">
                <input type="hidden" id="questionId" value="{{ $tacheActive->id }}">
                <div id="recorderSection" class="text-center">
                    <button class="btn" id="startRecordBtn">
                        <img src="{{ asset('images/micro1.png') }}" alt="">
                    </button>
                    <button class="btn d-none" id="stopRecordBtn">
                        <img src="{{ asset('images/stop-micro.png') }}" width="30" height="32" alt="">
                    </button>

                    <button class="btn btn-success mt-2 d-none" id="uploadBtn">📤 Envoyer l'audio</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="test_type" value="{{$test_type}}">
    <input type="hidden" id="expression_orale_id" value="{{ $question->id ?? 1 }}">
    {{-- <textarea id="zoneRedaction"></textarea> --}}



    <!-- Scripts -->
    <script>
        // Timer
        let duration = 3600;
        const timerDisplay = document.getElementById('timer');
         const testType = document.getElementById('test_type')?.value;

         
function enregistrerResultatFinalEtRediriger() {
    const data = {
        test_type: document.getElementById('test_type')?.value // ✅ camelCase → snake_case
    };

    fetch("{{ route('expression_orale.resultat_final') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(async response => {
        if (!response.ok) {
            const text = await response.text();
            console.error("Réponse erreur brute :", text);
            throw new Error('Erreur HTTP : ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log("Résultat enregistré :", data);

         window.location.href = '/expression-orale/resultat';

    })
    .catch(error => {
        console.log('Erreur enregistrement résultat final :', error);
    });
}

        setInterval(() => {
            const minutes = Math.floor(duration / 60);
            const seconds = duration % 60;
            timerDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            if (--duration < 0) {
                alert("Temps écoulé ! Vous allez voir vos résultats.");
                enregistrerResultatFinalEtRediriger();
            }
        }, 1000);

        // Abandonner
        function abandonnerTest() {
            if (confirm("Voulez-vous vraiment abandonner le test ?")) {
                enregistrerResultatFinalEtRediriger();
            }
        }

        // Improved showToast function
        function showToast(message, type = 'success') {
            // Fallback if Toastify fails
            if (typeof Toastify === 'undefined') {
                alert(`${type.toUpperCase()}: ${message}`);
                return;
            }

            Toastify({
                text: message,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: type === 'error' ? "#dc3545" : "#28a745",
            }).showToast();
        }

        // Version corrigée du gestionnaire de tâches
        document.querySelectorAll('.tache-btn1').forEach(btn => {
            btn.addEventListener('click', async function() {
                const numeroTache = parseInt(this.dataset.numero);
                const tacheId = parseInt(this.dataset.tacheId);

                try {
                    // UI Feedback
                    const originalText = this.innerHTML;
                    this.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-1" role="status"></span>';
                    this.disabled = true;

                    // Visual update
                    // Mettre à jour le style des boutons
                    document.querySelectorAll('.tache-btn1').forEach(b => {
                        b.classList.remove('btn-tache-active');
                        b.classList.add('btn-tache-inactive');
                    });
                    this.classList.remove('btn-tache-inactive');
                    this.classList.add('btn-tache-active');

                    // API Call
                    const response = await fetch("{{ route('expression_orale.changer_tache') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json"
                        },
                        body: JSON.stringify({
                            numero: numeroTache,
                            tache_id: tacheId
                        })
                    });

                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

                    const data = await response.json();

                    if (!data.success || !data.tache) {
                        throw new Error(data.error || 'Données de tâche manquantes');
                    }

                    // Mise à jour sécurisée de l'UI
                    const indicationsDiv = document.getElementById('indications');
                    if (indicationsDiv) {
                        indicationsDiv.innerHTML = `
                    <h5><strong>Indications</strong></h5>
                    <div class="text-justify" style="width: 40%; margin: 0 auto;">
                        <p>${data.tache.consigne || 'Aucune consigne disponible'}</p>
                    </div>
                    <div class="consigne">
                        <p style="text-align: justify">${data.tache.contexte || ''}</p>
                    </div>
                `;
                    }

                    const questionIdInput = document.getElementById('questionId');
                    if (questionIdInput) {
                        questionIdInput.value = data.tache.id || '';
                    }

                    // Gestion de la réponse existante
                    const reponseInput = document.getElementById('reponse');
                    if (reponseInput) {
                        reponseInput.value = data.reponse || '';
                    }

                } catch (error) {
                    console.error('Erreur:', error);
                    alert('Erreur: ' + error.message);
                } finally {
                    // Réinitialisation correcte des boutons
                    document.querySelectorAll('.tache-btn1').forEach(b => {
                        b.disabled = false;
                        b.innerHTML =
                        `Tâche ${b.dataset.numero}`; // Corrigé: utiliser dataset.numero
                    });
                }
            });
        });
        // Fonctions utilitaires (à ajouter)
        function showToast(message, type = 'success') {
            // Implémentez votre système de notification/toast
            Toastify({
                text: message,
                duration: 3000,
                className: type === 'error' ? 'bg-danger' : 'bg-success'
            }).showToast();
        }

        function updateTimer(seconds) {
            // Implémentez votre logique de timer
        }

        function resetTimer(duree) {
            // Implémentez la réinitialisation du timer
        }

        // 🎤 Enregistrement audio
        let mediaRecorder, audioChunks = [];
        const startBtn = document.getElementById("startRecordBtn");
        const stopBtn = document.getElementById("stopRecordBtn");
        const uploadBtn = document.getElementById("uploadBtn");
        const audioPreview = document.getElementById("audioPreview");

        startBtn.addEventListener("click", async () => {
            const stream = await navigator.mediaDevices.getUserMedia({
                audio: true
            });
            mediaRecorder = new MediaRecorder(stream);
            audioChunks = [];

            mediaRecorder.ondataavailable = event => {
                if (event.data.size > 0) {
                    audioChunks.push(event.data);
                }
            };

            mediaRecorder.onstop = () => {
                const audioBlob = new Blob(audioChunks, {
                    type: 'audio/webm'
                });
                const audioUrl = URL.createObjectURL(audioBlob);
                audioPreview.src = audioUrl;
                audioPreview.classList.remove("d-none");
                uploadBtn.classList.remove("d-none");
                uploadBtn.onclick = () => envoyerAudio(audioBlob);
            };

            mediaRecorder.start();
            startBtn.classList.add("d-none");
            stopBtn.classList.remove("d-none");
        });

        stopBtn.addEventListener("click", () => {
            mediaRecorder.stop();
            stopBtn.classList.add("d-none");
            startBtn.classList.remove("d-none");
        });

       function envoyerAudio(audioBlob) {
    const formData = new FormData();
    formData.append("audio", audioBlob, "enregistrement.webm");
    formData.append("expression_orale_id", document.getElementById('questionId').value);
    formData.append("_token", "{{ csrf_token() }}");

    // Afficher un indicateur de chargement
    uploadBtn.disabled = true;
    uploadBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Envoi...';

    fetch("{{ route('expression_orale.handleMessage') }}", {
        method: "POST",
        body: formData,
        headers: {
            'Accept': 'application/json',
        }
    })
    .then(async response => {
        // Vérifier si la réponse est JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            throw new Error(`Réponse non-JSON reçue: ${text.substring(0, 100)}...`);
        }
        return response.json();
    })
    .then(data => {
        if (data.error) {
            throw new Error(data.error);
        }
        
         console.log({
                expression_orale_id: document.getElementById('questionId').value,
                audio_eleve: data.audio_path,
                transcription_eleve: data.transcription,
                texte_ia: data.ia_response,
                audio_ia: data.audio_ia_path,
                score: data.score || 0,
                test_type: testType
            });
            
        // Enregistrer la réponse après la transcription
        return fetch("{{ route('expression_orale.repondre') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                expression_orale_id: document.getElementById('questionId').value,
                audio_eleve: data.audio_path,         // audio_path => audio_eleve
                transcription_eleve: data.transcription,  // transcription => transcription_eleve
                texte_ia: data.ia_response,           // ia_response => texte_ia
                audio_ia: data.audio_ia_path,         // audio_ia reste pareil
                score: data.score || 0,
                test_type: testType                 // score optionnel
            })
           

        });

    })
    .then(response => response.json())
    .then(data => {
        Swal.fire({
            icon: 'success',
            title: 'Réponse envoyée',
            text: 'Votre réponse a été sauvegardée avec succès.',
            timer: 2000,
            showConfirmButton: false
        });
    })
    .catch(err => {
        console.error('Erreur:', err);
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: err.message || 'Une erreur est survenue lors de l\'envoi',
        });
    })
    .finally(() => {
        uploadBtn.disabled = false;
        uploadBtn.innerHTML = 'Envoyer';
    });
}
    
    </script>

    <script>
    const speechSynthesisInstance = window.speechSynthesis;
    const speakButton = document.getElementById('speak-button');
    const textElement = document.getElementById('text-input');

    function speakText(text) {
        // Stop toute lecture en cours
        speechSynthesisInstance.cancel();

        const speech = new SpeechSynthesisUtterance(text);
        speech.lang = "fr-FR"; // Met la voix en français
        speech.rate = 1; // Vitesse normale
        speech.pitch = 1; // Hauteur normale
        speechSynthesisInstance.speak(speech);
    }

    // Lancer la lecture automatiquement au chargement de la page
    window.addEventListener('load', () => {
        const text = textElement.textContent.trim();
        if (text) {
            speakText(text);
        }
    });

    // Lecture manuelle via bouton
    speakButton.addEventListener('click', () => {
        const text = textElement.textContent.trim();
        speakText(text);
    });
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
