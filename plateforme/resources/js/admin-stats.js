document.getElementById("searchInput").addEventListener("keyup", function () {
    const value = this.value.toLowerCase();
    const rows = document.querySelectorAll("#userTable tbody tr");
    rows.forEach((row) => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(value) ? "" : "none";
    });
});

// Script pour gérer l'affichage du menu mobile
document.addEventListener("DOMContentLoaded", function () {
    const menuBtn = document.querySelector(".mobile-menu-btn");
    const sidebar = document.querySelector(".sidebar");

    menuBtn.addEventListener("click", function () {
        sidebar.classList.toggle("show");
    });

    // Ferme le menu quand on clique à l'extérieur
    document.addEventListener("click", function (event) {
        if (
            !sidebar.contains(event.target) &&
            !menuBtn.contains(event.target)
        ) {
            sidebar.classList.remove("show");
        }
    });
});

// Configuration du graphique
const ctx = document.getElementById("statisticsChart").getContext("2d");

// Données du graphique
const data = {
    labels: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
    ],
    datasets: [
        {
            label: "2022",
            data: [
                1200, 1900, 1700, 2200, 2500, 2100, 1800, 1500, 2000, 2300,
                2400, 1500,
            ],
            borderColor: "#4e73df",
            backgroundColor: "rgba(78, 115, 223, 0.1)",
            pointBackgroundColor: "#4e73df",
            pointBorderColor: "#fff",
            pointRadius: 5,
            pointHoverRadius: 7,
            tension: 0.4,
            fill: false,
            borderWidth: 3,
        },
        {
            label: "2021",
            data: [
                1000, 1600, 1400, 1800, 2000, 1700, 1500, 1300, 1600, 1900,
                2100, 1600,
            ],
            borderColor: "#1cc88a",
            backgroundColor: "rgba(28, 200, 138, 0.1)",
            pointBackgroundColor: "#1cc88a",
            pointBorderColor: "#fff",
            pointRadius: 5,
            pointHoverRadius: 7,
            tension: 0.4,
            fill: false,
            borderWidth: 3,
        },
    ],
};

// Options du graphique
const options = {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
        x: {
            display: false,
            grid: {
                display: false,
            },
        },
        y: {
            display: false,
            min: 0,
            max: 2500,
            grid: {
                display: false,
            },
        },
    },
    plugins: {
        legend: {
            display: false,
        },
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

// Création du graphique
const statisticsChart = new Chart(ctx, {
    type: "line",
    data: data,
    options: options,
});

// Gestion du changement de tri
document.querySelector(".sort-select").addEventListener("change", function () {
    // Animation de changement
    statisticsChart.data.datasets.forEach((dataset) => {
        dataset.data = dataset.data.map(() => Math.floor(Math.random() * 2500));
    });
    statisticsChart.update();
});
