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

// ===========================
// Graphique Chart.js
// ===========================

document.addEventListener("DOMContentLoaded", function () {
    const canvas = document.getElementById("statisticsChart");
    if (!canvas) return; // Si le canvas n'existe pas, on quitte

    // Assurez-vous que le canvas a une hauteur
    canvas.style.height = "400px";

    const ctx = canvas.getContext("2d");

    const data = {
        labels: [
            "Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"
        ],
        datasets: [
            {
                label: "2025",
                data: [1200, 1900, 1700, 2200, 2500, 2100, 1800, 1500, 2000, 2300, 2400, 1500],
                borderColor: "#4e73df",
                backgroundColor: "rgba(78, 115, 223, 0.2)",
                tension: 0.4,
                fill: false,
                pointRadius: 5,
                pointHoverRadius: 7,
                borderWidth: 3
            },
            {
                label: "2024",
                data: [1000, 1600, 1400, 1800, 2000, 1700, 1500, 1300, 1600, 1900, 2100, 1600],
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

    // Gestion du tri (change les données aléatoirement pour l'exemple)
    const sortSelect = document.querySelector(".sort-select");
    if (sortSelect) {
        sortSelect.addEventListener("change", function () {
            statisticsChart.data.datasets.forEach((dataset) => {
                dataset.data = dataset.data.map(() => Math.floor(Math.random() * 2500));
            });
            statisticsChart.update();
        });
    }
});
