
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
   


   
let questionsNonRepondues = questions
    .map((q, idx) => reponses[q.id] ? null : idx)
    .filter(idx => idx !== null);


function envoyerReponse(reponse, index) {
    const questionId = questions[index].id;

    fetch('/comprehension_ecrite/repondre', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            question_id: questionId,
            reponse: reponse,
            test_type: document.getElementById("testType").value,
        })
    })
    .then(res => res.json())
    .then(data => {
        // ✅ Supprimer l'index de la liste des questions non répondues
        questionsNonRepondues = questionsNonRepondues.filter(i => i !== index);

        if (questionsNonRepondues.length > 0) {
            // Charger la prochaine question non répondue
            const nextIndex = questionsNonRepondues[0];
            setTimeout(() => chargerQuestion(nextIndex), 500);
        } else {
            // Toutes les questions ont été répondues
            setTimeout(() => {
                alert("🎉 Test terminé !");
                enregistrerResultatFinalEtRediriger();
            }, 500);
        }
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
    let seconds = 60 * 60;
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

