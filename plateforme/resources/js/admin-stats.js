// admin-stats.js

// ===========================
// Menu mobile
// ===========================
document.addEventListener("DOMContentLoaded", function () {
    const menuBtn = document.querySelector(".mobile-menu-btn");
    const sidebar = document.querySelector(".sidebar");

    menuBtn.addEventListener("click", function () {
        sidebar.classList.toggle("show");
    });

    document.addEventListener("click", function (event) {
        if (!sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
            sidebar.classList.remove("show");
        }
    });
});

// admin-stats.js

// ... (votre code existant pour le menu mobile) ...

// ===========================
// Graphique Chart.js
// ===========================
document.addEventListener("DOMContentLoaded", function () {
    const canvas = document.getElementById("statisticsChart");
    if (!canvas) return;

    canvas.style.height = "400px";
    const ctx = canvas.getContext("2d");

    const data = {
        labels: [
            "Jan", "Feb", "Mar", "Apr", "May", "Jun",
            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ],
        datasets: [
            {
                label: `Utilisateurs ${currentYear}`,
                data: monthlyDataCurrentYear,
                borderColor: "#4e73df",           // bleu
                backgroundColor: "rgba(78, 115, 223, 0.1)",
                tension: 0.4,
                fill: false,
                pointRadius: 4,
                pointHoverRadius: 7,
                borderWidth: 2
            },
            {
                label: `Utilisateurs ${previousYear}`,
                data: monthlyDataPreviousYear,
                borderColor: "#1cc88a",           // vert
                backgroundColor: "rgba(28, 200, 138, 0.1)",
                tension: 0.4,
                fill: false,
                pointRadius: 4,
                pointHoverRadius: 7,
                borderWidth: 2,
                borderDash: [5, 5]                // tirets
            },
            {
                label: `Tests ${currentYear}`,
                data: monthlyDataCurrentYearTests,
                borderColor: "#e74a3b",           // rouge
                backgroundColor: "rgba(231, 74, 59, 0.1)",
                tension: 0.4,
                fill: false,
                pointRadius: 4,
                pointHoverRadius: 7,
                borderWidth: 2
            },
            {
                label: `Tests ${previousYear}`,
                data: monthlyDataPreviousYearTests,
                borderColor: "#f6c23e",           // jaune
                backgroundColor: "rgba(246, 194, 62, 0.1)",
                tension: 0.4,
                fill: false,
                pointRadius: 4,
                pointHoverRadius: 7,
                borderWidth: 2,
                borderDash: [5, 5]
            }
        ]
    };

    const options = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: { display: false },
            y: { display: false, min: 0, max: 2500 }
        },
        plugins: {
            legend: { display: false }, // tu gères ta légende custom en HTML
            tooltip: {
                backgroundColor: "rgba(255, 255, 255, 0.95)",
                titleColor: "#333",
                bodyColor: "#333",
                borderColor: "#ddd",
                borderWidth: 1,
                padding: 12,
                displayColors: true,
                callbacks: {
                    label: function (context) {
                        return `${context.dataset.label}: ${context.parsed.y}`;
                    }
                }
            }
        }
    };

    new Chart(ctx, {
        type: "line",
        data: data,
        options: options
    });
});



// Impresion de la page

document.addEventListener("DOMContentLoaded", function() {
    // Récupérer le bouton d'impression
    const printButton = document.getElementById("btn-print");

    // S'assurer que le bouton existe avant d'ajouter l'écouteur d'événement
    if (printButton) {
        printButton.addEventListener("click", function() {
            // Appeler la fonction d'impression du navigateur
            window.print();
        });
    }
})