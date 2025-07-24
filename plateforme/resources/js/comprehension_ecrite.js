document.addEventListener("DOMContentLoaded", function () {
    let currentIndex = 0; // 👈 Indice global de la question actuelle

    // Sélection des boutons de réponse
    document.querySelectorAll(".choix-reponse").forEach((btn) => {
        btn.addEventListener("click", () => {
            const selected = btn.dataset.reponse;
            const index = parseInt(btn.dataset.index);
            currentIndex = index; // 👈 Met à jour la question actuelle

            const q = questions[index];
            const saveUrl = '/comprehension_ecrite/repondre';
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(saveUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: JSON.stringify({
                    question_id: q.id,
                    reponse: selected,
                }),
            })
                .then((response) => {
                    if (!response.ok) throw new Error("Erreur de réponse");
                    return response.json();
                })
                .then((data) => {
                    if (data.correct) {
                        document.getElementById("audio-success").play();
                        if (typeof confetti !== "undefined") confetti();
                    } else {
                        document.getElementById("audio-fail").play();
                    }

                    // Question suivante
                    if (currentIndex < questions.length - 1) {
                        setTimeout(() => updateQuestion(currentIndex + 1), 1000);
                    } else {
                        setTimeout(() => {
                            alert("🎉 Test terminé !");
                            window.location.href = "/comprehension_ecrite/resultat";
                        }, 1500);
                    }
                })
                .catch((err) => {
                    console.error("Erreur AJAX:", err);
                });
        });
    });

    function updateQuestion(index) {
    const q = questions[index];
    currentIndex = index; // ✅ Met à jour la variable globale

    // Met à jour le texte de la situation
    const situationEl = document.querySelector(".situation-text");
    if (situationEl) {
        situationEl.textContent = q.situation;
    }

    // Met à jour la question
    const questionEl = document.querySelector(".question-text");
    if (questionEl) {
        questionEl.textContent = q.question;
    }

    // Met à jour les réponses (A, B, C, D)
    const reponseButtons = document.querySelectorAll(".choix-reponse");
    reponseButtons.forEach((btn, i) => {
        const lettre = ['A', 'B', 'C', 'D'][i];
        btn.textContent = ''; // Reset
        btn.dataset.index = index;
        btn.dataset.reponse = lettre;

        // Crée un contenu avec lettre + texte
        const spanLettre = document.createElement("span");
        spanLettre.classList.add("fw-bold", "fs-4", "me-2");
        spanLettre.textContent = lettre;

        btn.appendChild(spanLettre);
        btn.append(q.propositions[i] ?? 'Proposition');
    });

    // Met à jour les marqueurs (boutons circulaires en haut)
    document.querySelectorAll(".question-btn").forEach((btn) => {
        btn.classList.remove("btn-success");
        btn.classList.add("btn-secondary");
    });
    const currentBtn = document.querySelector(`.question-btn[data-index="${index}"]`);
    if (currentBtn) {
        currentBtn.classList.remove("btn-secondary");
        currentBtn.classList.add("btn-success");
    }
    }

    // Timer 60:00
    let seconds = 1* 60;
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


