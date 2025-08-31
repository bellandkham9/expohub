
document.addEventListener("DOMContentLoaded", function () {
    let currentIndex = 0;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // 🎯 Chargement initial de la première question
    chargerQuestion(0);

    // ✅ Boutons circulaires : changement de question
    document.querySelectorAll('.question-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const index = parseInt(this.dataset.index);
            currentIndex = index;
            chargerQuestion(index);
            mettreAJourBoutons(index);
        });
    });

    // ✅ Fonction principale d'affichage d'une question
    function chargerQuestion(index) {
        const question = questions[index];
        currentIndex = index;

        document.querySelector('.situation-text').textContent = question.situation;
        document.querySelector('.question-text').textContent = question.question;

        const reponsesContainer = document.getElementById('reponses');
        reponsesContainer.innerHTML = '';

        ['A', 'B', 'C', 'D'].forEach((lettre, i) => {
            const proposition = question.propositions[i] ?? 'Proposition';

            const btn = document.createElement('button');
            btn.className = 'btn w-100 p-3 rounded bg-white text-start text-dark choix-reponse';
            btn.dataset.reponse = lettre;
            btn.dataset.index = index;
            btn.innerHTML = `<span class="fw-bold fs-4 me-2">${lettre}</span> ${proposition}`;

            btn.addEventListener('click', () => envoyerReponse(lettre, index));

            const col = document.createElement('div');
            col.className = 'col-md-5';
            col.appendChild(btn);

            reponsesContainer.appendChild(col);
        });

        mettreAJourBoutons(index);
    }
  function enregistrerResultatFinalEtRediriger() {
    fetch('/comprehension_ecrite/resultat/final', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log("Résultat enregistré :", data);
        // Redirection vers la page de résultats après enregistrement
        window.location.href = '/comprehension_ecrite/resultat';
    })
    .catch(error => {
        console.error('Erreur enregistrement résultat final :', error);
    });
}

    // ✅ Réponse utilisateur via AJAX
function envoyerReponse(reponse, index) {
    const questionId = questions[index].id;
    const testType = document.getElementById('testType')?.value;

    fetch('/comprehension_ecrite/repondre', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            question_id: questionId,
            reponse: reponse,
            test_type: testType
        })
    })
    .then(res => res.json())
    .then(data => {
        // ✅ Enchaîne automatiquement sur la question suivante
        setTimeout(() => {
            if (index < questions.length - 1) {
                chargerQuestion(index + 1);
            } else {
                alert("🎉 Test terminé !");
                enregistrerResultatFinalEtRediriger();
            }
        }, 1000); // ⏱️ délai de 1 seconde
    })
    .catch(err => console.error("Erreur AJAX:", err));
}


    // ✅ Mise à jour visuelle des boutons de navigation
    function mettreAJourBoutons(indexActif) {
        document.querySelectorAll('.question-btn').forEach((btn, i) => {
            btn.classList.remove('btn-success', 'btn-danger', 'btn-secondary');
            btn.classList.add(i === indexActif ? 'btn-success' : 'btn-secondary');
        });
    }

    // ✅ Timer 60 minutes
    let seconds = 60* 60;
    const timerEl = document.getElementById("timer");

    const countdown = setInterval(() => {
        const min = String(Math.floor(seconds / 60)).padStart(2, "0");
        const sec = String(seconds % 60).padStart(2, "0");
        timerEl.textContent = `${min}:${sec}`;
        seconds--;
        if (seconds < 0) {
            clearInterval(countdown);
            alert("⏱️ Temps écoulé !");
            window.location.href = "/comprehension_ecrite/resultat";
        }
    }, 1000);
});

