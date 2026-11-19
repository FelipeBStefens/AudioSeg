const statisticsElement = document.getElementById("statistics-data");

if (statisticsElement && typeof Chart !== "undefined") {

    const statistics = JSON.parse(statisticsElement.textContent);
    Chart.defaults.font.family = "Montserrat";
    Chart.defaults.color = "#a6a6a6";

    const axisOptions = {
        x: {
            grid: {display: false},
            ticks: {color: "#a6a6a6", font: {size: 10}},
            border: {color: "#504d4d"}
        },
        y: {
            beginAtZero: true,
            grid: {color: "rgba(255,255,255,.07)"},
            ticks: {color: "#a6a6a6", precision: 0, font: {size: 10}},
            border: {display: false}
        }
    };

    new Chart(document.getElementById("evolutionChart"), {
            type: "bar",
            data: {
                labels: statistics.months,
                datasets: [{
                    label: "Occurrences",
                    data: statistics.monthly_values,
                    backgroundColor: "#e8c82b",
                    hoverBackgroundColor: "#fcde33",
                    borderRadius: 6,
                    maxBarThickness: 42
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {legend: {display: false}},
                scales: axisOptions
            }
        }
    );

    new Chart(document.getElementById("regionChart"), {
            type: "doughnut",
            data: {
                labels: statistics.regions,
                datasets: [{
                    data: statistics.region_values,
                    backgroundColor: ["#fcde33", "#e8c82b", "#eacd3e", "#a6a6a6", "#777171", "#575252"],
                    borderColor: "#242222",
                    borderWidth: 4,
                    hoverOffset: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: "70%",
                plugins: {legend: {display: false}}
            }
        }
    );

    new Chart(document.getElementById("hoursChart"), {
            type: "line",
            data: {
                labels: statistics.hours,
                datasets: [{
                    label: "Occurrences",
                    data: statistics.hour_values,
                    borderColor: "#fcde33",
                    backgroundColor: "rgba(252,222,51,.12)",
                    fill: true,
                    tension: .38,
                    pointRadius: 3,
                    pointBackgroundColor: "#fcde33"
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {legend: {display: false}},
                scales: axisOptions
            }
        }
    );
}