<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TCF Canada - Expression Écrite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/expression_ecrite.css', 'resources/css/myExpressionEcrite.css'])
    <style>
        /* Style personnalisé */
        .tache-btn1 {
            width: 100px;
            border-radius: 8px;
            margin: 5px;
            transition: all 0.3s ease;
        }

        .btn-tache-active {
            background-color: #224194 !important;
            color: white !important;
        }

        .btn-tache-inactive {
            background-color: #e9ecef !important;
            color: #495057 !important;
        }

        .redaction-container {
            position: relative;
            margin-top: 20px;
        }

        #zoneRedaction {
            min-height: 150px;
            border-radius: 10px;
            padding: 15px;
        }


        #sendButton {
            position: absolute;
            bottom: 15px;
            right: 15px;
            background: none;
            border: none;
        }

        #sendButton img {
            width: 30px;
            height: 30px;
        }

        .char-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div class="container py-3">
        <div class="test-container">
            <div class="row g-2 justify-content-between align-items-center mb-4">
                <div class="col-md-2 text-center">
                    <div class="alert alert-info mb-0">Temps restant : <span id="timer">60:00</span></div>
                </div>
                <div class="col-md-8 text-center">
                    <h3>TCF CANADA, Expression écrite</h3>
                </div>
                <div class="col-md-2 text-center">
                    <button onclick="abandonnerTest()" id="btn-abonne" class="btn btn-danger">
                        <i class="fas fa-times-circle me-2"></i> Abandonner
                    </button>
                </div>
            </div>

            <div class="card mb-4 main-content">
                <div class="d-flex gap-3 p-2">
                    <div class="boutons-container d-flex flex-wrap">
                        @foreach ($taches as $q)
                            <button
                                class="btn tache-btn1 {{ $q->id == $tacheActive->id ? 'btn-tache-active' : 'btn-tache-inactive' }}"
                                data-tache="{{ $q->numero_tache }}">
                                Tâche {{ $q->numero_tache }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Zone dynamique pour le texte de la tâche -->
                <div class="card-body indication mt-7" id="indications">
                    <h5><strong>Indications</strong></h5>
                    
                    <p>{{ $tacheActive->contexte_texte }}</p>
                    <div class="consigne">
                        <p>{{ $tacheActive->consigne }}</p>
                    </div>
                    <div id="clavierSpeciaux" class="mt-2 d-flex justify-content-center">
                        <div class="d-flex flex-wrap gap-2 p-3"
                            style="box-shadow: 2px 2px 2px 2px gainsboro; border-radius: 15px; max-width: fit-content;">
                            <button type="button" class="btn btn-outline-secondary btn-sm char-btn">é</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm char-btn">è</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm char-btn">ê</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm char-btn">à</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm char-btn">ù</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm char-btn">ç</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm char-btn">ô</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm char-btn">î</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm char-btn">â</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm char-btn">û</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm char-btn">ë</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm char-btn">ï</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm char-btn">œ</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm char-btn">Æ</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm char-btn">«</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm char-btn">»</button>
                        </div>
                    </div>
                </div>
            </div>

            <form id="formRedaction" onsubmit="event.preventDefault(); envoyerRedaction();">
                <div class="redaction-container">
                    <textarea class="form-control" rows="6" name="reponse" id="zoneRedaction" placeholder="Rédige ta réponse ici..."></textarea>
                    <input type="hidden" id="questionId" name="expression_ecrite_id"
                        value="{{ $tacheActive->id ?? '' }}">
                    <button type="submit" class="btn" id="sendButton">
                        <img src="{{ asset('images/send.png') }}" alt="Envoyer">
                    </button>
                </div>
            </form>
        </div>
    </div>
    <input type="hidden" id="testType" value="{{$test_type}}">
    

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const testType = document.getElementById('testType').value;
            console.log("Valeur du test type :", testType);
        });
    </script>

    <script>
        // ⏱️ Timer
        let duration = 3600;
        const timerDisplay = document.getElementById('timer');
        setInterval(() => {
            const minutes = Math.floor(duration / 60);
            const seconds = duration % 60;
            timerDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            if (--duration < 0) {
                alert("Temps écoulé ! Vous allez voir vos résultats.");
                enregistrerResultatFinalEtRediriger()
            }
        }, 1000);

                        
        function enregistrerResultatFinalEtRediriger() {
            const data = {
            test_type: document.getElementById('testType')?.value
            };

            console.log("Data envoyée au serveur :", data);

            fetch("{{ route('expression_ecrite.resultat_final') }}", {
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

                window.location.href = '/expression-ecrite/resultat';
                
            })
            .catch(error => {
                console.log('Erreur enregistrement résultat final :', error);
            });
        }



        // Caractères spéciaux
        document.querySelectorAll('.char-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const textarea = document.getElementById('zoneRedaction');
                const char = this.textContent;
                const start = textarea.selectionStart;
                const end = textarea.selectionEnd;
                const text = textarea.value;
                textarea.value = text.substring(0, start) + char + text.substring(end);
                textarea.focus();
                textarea.selectionStart = textarea.selectionEnd = start + char.length;
            });
        });

        // ❌ Abandonner le test
        function abandonnerTest() {
            if (confirm("Voulez-vous vraiment abandonner le test ?")) {
                enregistrerResultatFinalEtRediriger();
            }
        }

        // 🔁 Changer de tâche
        document.querySelectorAll('.tache-btn1').forEach(btn => {
            btn.addEventListener('click', function() {
                const numeroTache = this.dataset.tache;

                // Mettre à jour le style des boutons
                document.querySelectorAll('.tache-btn1').forEach(b => {
                    b.classList.remove('btn-tache-active');
                    b.classList.add('btn-tache-inactive');
                });
                this.classList.remove('btn-tache-inactive');
                this.classList.add('btn-tache-active');

                fetch("{{ route('expression_ecrite.changer_tache') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            numero_tache: numeroTache
                        })
                    })
                    .then(async res => {
                        if (!res.ok) {
                            const errText = await res.text();
                            throw new Error(`Erreur HTTP (${res.status}): ${errText}`);
                        }
                        return res.json();
                    })
                    .then(data => {
                        const indicationsDiv = document.getElementById('indications');
                        const zoneRedaction = document.getElementById('formRedaction');

                        if (data.reponse !== null) {
                            indicationsDiv.innerHTML = `
                                <div class="alert alert-success">
                                    ✅ Cette tâche a déjà été complétée. Vous ne pouvez plus la modifier.
                                </div>
                            `;
                            zoneRedaction.style.display = "none";
                        } else {
                            indicationsDiv.innerHTML = `
                                <h5><strong>Indications</strong></h5>
                                <p>${data.tache.contexte_texte}</p>
                                <div class="consigne"><p>${data.tache.consigne}</p></div>

                                          <div id="clavierSpeciaux" class="mt-2 d-flex justify-content-center">
                                                <div class="d-flex flex-wrap gap-2 p-3" 
                                                    style="box-shadow: 2px 2px 2px 2px gainsboro; border-radius: 15px; max-width: fit-content;">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm char-btn">é</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm char-btn">è</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm char-btn">ê</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm char-btn">à</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm char-btn">ù</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm char-btn">ç</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm char-btn">ô</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm char-btn">î</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm char-btn">â</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm char-btn">û</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm char-btn">ë</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm char-btn">ï</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm char-btn">œ</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm char-btn">Æ</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm char-btn">«</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm char-btn">»</button>
                                                </div>
                                            </div>
                            `;
                            zoneRedaction.style.display = "block";
                        }

                        document.getElementById('questionId').value = data.tache.id;
                        document.getElementById('zoneRedaction').value = '';
                    })
                    .catch(err => {
                        alert("Erreur lors du chargement de la tâche !");
                        console.error(err);
                    });
            });
        });

        function envoyerRedaction() {
            const textarea = document.getElementById('zoneRedaction');
            const questionIdInput = document.getElementById('questionId');
            const sendButton = document.querySelector('#sendButton');
            const testType = document.getElementById('testType')?.value;

            // Validation des éléments DOM
            if (!textarea || !questionIdInput || !sendButton) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Éléments introuvables. Veuillez recharger la page.'
                });
                return;
            }

            const reponse = textarea.value.trim();
            const questionId = questionIdInput.value;

            // Validation du contenu
            if (!reponse) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Champ vide',
                    text: 'Veuillez rédiger une réponse avant d\'envoyer.'
                });
                return;
            }

            // Désactive le bouton pendant l'envoi
            sendButton.disabled = true;
            sendButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Envoi en cours...';

            fetch("{{ route('expression_ecrite.repondre') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": '{{ csrf_token() }}',
                        "Accept": "application/json" // Important pour les erreurs Laravel
                    },
                    body: JSON.stringify({
                        reponse: reponse,
                        expression_ecrite_id: questionId,
                        test_type: testType
                    })
                })
                .then(async response => {
                    // Gestion des réponses non-OK (400, 500, etc.)
                    if (!response.ok) {
                        let errorData;

                        try {
                            errorData = await response.json();
                        } catch (e) {
                            throw new Error(`Erreur ${response.status}: ${response.statusText}`);
                        }

                        throw new Error(errorData.message || errorData.error || 'Erreur inconnue');
                    }

                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Information',
                            text: data.error,
                            showConfirmButton: true
                        });
                        return;
                    }

                    // Succès
                    Swal.fire({
                        icon: 'success',
                        title: 'Succès!',
                        text: data.message || 'Votre réponse a été sauvegardée.',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Réinitialisation du formulaire
                    textarea.value = '';
                })
                .catch(error => {
                    console.error('Erreur:', error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: error.message || 'Une erreur est survenue lors de l\'envoi.',
                        showConfirmButton: true
                    });
                })
                .finally(() => {
                    // Réactive le bouton
                    sendButton.disabled = false;
                    sendButton.innerHTML = '<img src="{{ asset('images/send.png') }}" alt="Envoyer">';
                });
        }
    </script>
    <script>
        const speechSynthesis = window.speechSynthesis;
        const speakButton = document.getElementById('speak-button');
        const textInput = document.getElementById('text-input');

        speakButton.addEventListener('click', () => {
            const text = textInput.value;
            const speech = new SpeechSynthesisUtterance(text);
            speechSynthesis.speak(speech);
        });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
