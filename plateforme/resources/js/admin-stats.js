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
import Chart from 'chart.js/auto';

document.addEventListener("DOMContentLoaded", function () {
    const canvas = document.getElementById("statisticsChart");
    if (!canvas) return;

    canvas.style.height = "400px";

    const ctx = canvas.getContext("2d");

    const data = {
        labels: [
            "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ],
        datasets: [
            {
                label: currentYear, // Utilisation de l'année en cours
                data: monthlyDataCurrentYear, // Utilisation des données dynamiques
                borderColor: "#4e73df",
                backgroundColor: "rgba(78, 115, 223, 0.2)",
                tension: 0.4,
                fill: false,
                pointRadius: 5,
                pointHoverRadius: 7,
                borderWidth: 3
            },
            {
                label: previousYear, // Utilisation de l'année précédente
                data: monthlyDataPreviousYear, // Utilisation des données dynamiques
                borderColor: "#1cc88a",
                backgroundColor: "rgba(28, 200, 138, 0.2)",
                tension: 0.4,
                fill: false,
                pointRadius: 5,
                pointHoverRadius: 7,
                borderWidth: 3
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
            legend: { display: false },
            tooltip: {
                backgroundColor: "rgba(255, 255, 255, 0.95)",
                titleColor: "#333",
                bodyColor: "#333",
                borderColor: "#ddd",
                borderWidth: 1,
                padding: 12,
                displayColors: true,
                boxPadding: 5,
                callbacks: {
                    label: function (context) {
                        return `${context.dataset.label}: ${context.parsed.y}`;
                    },
                },
            },
        },
    };

    const statisticsChart = new Chart(ctx, {
        type: "line",
        data: data,
        options: options,
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