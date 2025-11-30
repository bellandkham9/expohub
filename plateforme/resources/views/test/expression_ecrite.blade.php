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
@php
    $testTypeString = $test_type->examen . '-' . $test_type->nom_du_plan;
    $testTypeData = [
        'id' => $test_type->id,
        'string' => $testTypeString,
        'examen' => $test_type->examen,
        'nom_du_plan' => $test_type->nom_du_plan,
    ];
@endphp

<input type="hidden" id="testType" value='@json($testTypeData)'>

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
                        @foreach(['é','è','ê','à','ù','ç','ô','î','â','û','ë','ï','œ','Æ','«','»'] as $char)
                            <button type="button" class="btn btn-outline-secondary btn-sm char-btn">{{ $char }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <form id="formRedaction" onsubmit="event.preventDefault(); envoyerRedaction();">
            <div class="redaction-container">
                <textarea class="form-control" rows="6" name="reponse" id="zoneRedaction" placeholder="Rédige ta réponse ici..."></textarea>
                <input type="hidden" id="questionId" name="expression_ecrite_id" value="{{ $tacheActive->id ?? '' }}">
                <button type="submit" class="btn" id="sendButton">
                    <img src="{{ asset('images/send.png') }}" alt="Envoyer">
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // ⏱ Timer
    let duration = 3600; // 60 minutes
    const timerDisplay = document.getElementById('timer');
    setInterval(() => {
        const minutes = Math.floor(duration / 60);
        const seconds = duration % 60;
        timerDisplay.textContent = `${String(minutes).padStart(2,'0')}:${String(seconds).padStart(2,'0')}`;
        if (--duration < 0) {
            alert("Temps écoulé ! Vous allez voir vos résultats.");
            enregistrerResultatFinalEtRediriger();
        }
    }, 1000);

    // 🔁 Fonctions principales
    function attachClavierListeners() {
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
    }
    attachClavierListeners();

    window.abandonnerTest = function() {
        if (confirm("Voulez-vous vraiment abandonner le test ?")) {
            enregistrerResultatFinalEtRediriger();
        }
    }

    window.enregistrerResultatFinalEtRediriger = function() {
   
     // Récupération des infos du test
    let testTypeData = {};
    try {
        testTypeData = JSON.parse(document.getElementById("testType").value);
    } catch(e) {
        Swal.fire({ icon:'error', title:'Erreur', text:'Impossible de lire les informations du test.' });
        return;
    }

    const test_type = testTypeData.string || '';
    const test_type_id = parseInt(testTypeData.id, 10);
    const abonnement_id = test_type_id; // si abonnement_id = test_type_id comme dans ton controller

    if (!test_type || !test_type_id || isNaN(test_type_id)) {
        Swal.fire({ icon:'error', title:'Erreur', text:'Données du test invalides.' });
        return;
    }

        fetch("{{ route('expression_ecrite.resultat_final') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                test_type: testTypeData.string,   // garde la chaîne "TCF-Canada"
                abonnement_id: testTypeData.id,
                test_type: test_type,
                test_type_id: test_type_id,
                abonnement_id: abonnement_id    // on ajoute aussi l'id
            })
        })
        .then(async response => {
            if (!response.ok) throw new Error(await response.text());
            return response.json();
        })
        .then(data => window.location.href = '/expression-ecrite/resultat')
        .catch(err => console.error(err));
    }

    // 🔄 Changement de tâche
    document.querySelectorAll('.tache-btn1').forEach(btn => {
        btn.addEventListener('click', function() {
            const numeroTache = this.dataset.tache;

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
                body: JSON.stringify({ numero_tache: numeroTache })
            })
            .then(async res => {
                if (!res.ok) throw new Error(await res.text());
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
                            <div class="d-flex flex-wrap gap-2 p-3" style="box-shadow: 2px 2px 2px 2px gainsboro; border-radius: 15px; max-width: fit-content;">
                                @foreach(['é','è','ê','à','ù','ç','ô','î','â','û','ë','ï','œ','Æ','«','»'] as $char)
                                    <button type="button" class="btn btn-outline-secondary btn-sm char-btn">{{ $char }}</button>
                                @endforeach
                            </div>
                        </div>
                    `;
                    zoneRedaction.style.display = "block";
                    attachClavierListeners();
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

window.envoyerRedaction = function() {
    const textarea = document.getElementById('zoneRedaction');
    const questionId = parseInt(document.getElementById('questionId').value, 10);
    const sendButton = document.getElementById('sendButton');
    const reponse = textarea.value.trim();

    if (!reponse) {
        Swal.fire({ icon:'warning', title:'Champ vide', text:'Veuillez rédiger une réponse avant d\'envoyer.' });
        return;
    }

    // Récupération des infos du test
    let testTypeData = {};
    try {
        testTypeData = JSON.parse(document.getElementById("testType").value);
    } catch(e) {
        Swal.fire({ icon:'error', title:'Erreur', text:'Impossible de lire les informations du test.' });
        return;
    }

    const test_type = testTypeData.string || '';
    const test_type_id = parseInt(testTypeData.id, 10);
    const abonnement_id = test_type_id; // si abonnement_id = test_type_id comme dans ton controller

    if (!test_type || !test_type_id || isNaN(test_type_id)) {
        Swal.fire({ icon:'error', title:'Erreur', text:'Données du test invalides.' });
        return;
    }

    sendButton.disabled = true;
    sendButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Envoi en cours...';

    fetch("{{ route('expression_ecrite.repondre') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": '{{ csrf_token() }}',
            "Accept": "application/json"
        },
        body: JSON.stringify({
            reponse: reponse,
            expression_ecrite_id: questionId,
            test_type: test_type,
            test_type_id: test_type_id,
            abonnement_id: abonnement_id
        })
    })
    .then(async response => {
        if (!response.ok) {
            let errData;
            try { errData = await response.json(); } catch(e) { throw new Error(`Erreur ${response.status}`); }
            throw new Error(errData.message || errData.error || 'Erreur inconnue');
        }
        return response.json();
    })
    .then(data => {
        if (data.error) {
            Swal.fire({ icon:'warning', title:'Info', text:data.error });
            return;
        }
        Swal.fire({ icon:'success', title:'Succès!', text:data.message || 'Réponse sauvegardée.', timer:2000, showConfirmButton:false });
        textarea.value = '';
    })
    .catch(err => Swal.fire({ icon:'error', title:'Erreur', text:err.message }))
    .finally(() => {
        sendButton.disabled = false;
        sendButton.innerHTML = '<img src="{{ asset('images/send.png') }}" alt="Envoyer">';
    });
}



});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
