<?php
    session_start();

    include __DIR__ . "/../../server/security/validation.php";
    include __DIR__ . "/../../server/security/expiration.php";

    if (!validate_user()) {
        redirect();
        exit;
    }

    verify_expiration();

    $user = $_SESSION["user_data"];
?>

<?php
$statistics = [
    'total' => 1284,
    'last_30_days' => 146,
    'top_region' => 'Centro',
    'average_detection' => '4,2 s',
    'months' => ['Ago', 'Set', 'Out', 'Nov'],
    'monthly_values' => [286, 354, 498, 146],
    'regions' => [
        ['name' => 'Center', 'total' => 382],
        ['name' => 'North Zone', 'total' => 294],
        ['name' => 'East Zone', 'total' => 251],
        ['name' => 'South Zone', 'total' => 203],
        ['name' => 'Other Regions', 'total' => 154],
    ],
    'hours' => [42, 58, 76, 91, 125, 148, 132, 104],
];

$regionTotal = array_sum(array_column($statistics['regions'], 'total'));
$regionLabels = array_column($statistics['regions'], 'name');
$regionValues = array_column($statistics['regions'], 'total');
$hourLabels = ['00–03h', '03–06h', '06–09h', '09–12h', '12–15h', '15–18h', '18–21h', '21–00h'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Estatísticas públicas e agregadas do AudioSeg.">
    <title>AudioSeg - Statistics</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    <link rel="stylesheet" href="../../style/main/statistic.css">

    <link rel="icon" href="../../assets/images/AudioSegLogo.png" type="image/png">
    <link rel="stylesheet" href="../../style/main/settings.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <?php include __DIR__ . "/../header/header.php"?>

    <main class="statistics-layout">
        <aside class="sidebar">
            <div class="sidebar-heading">
                <span class="eyebrow">AUDIOSEG</span>
                <h2>Statistics</h2>
            </div>

            <nav class="sidebar-navigation" aria-label="Seções das estatísticas">
                <a class="selected" href="#overview">
                    <span class="material-symbols-rounded">dashboard</span>
                    Overview
                </a>
                <a href="#evolution">
                    <span class="material-symbols-rounded">show_chart</span>
                    Evolution
                </a>
                <a href="#distribution">
                    <span class="material-symbols-rounded">pie_chart</span>
                    Distribution
                </a>
                <a href="#regional">
                    <span class="material-symbols-rounded">location_on</span>
                    Regions
                </a>
            </nav>

            <div class="sidebar-footer">
                <span class="material-symbols-rounded">public</span>
                <p>Information and transparency for the community.</p>
            </div>
        </aside>

        <section class="statistics-content">
            <div class="page-heading">
                <div>
                    <p class="eyebrow">PUBLIC DATA • AUDIOSEG</p>
                    <h1>Statistics Panel</h1>
                    <p class="page-description">Monitor aggregated gunshot detection data.</p>
                </div>

                <div class="period-filter">
                    <label for="period">Analysis Period</label>
                    <select id="period" name="period">
                        <option value="30">Last 30 days</option>
                        <option value="90" selected>Last 90 days</option>
                        <option value="365">Last 12 months</option>
                    </select>
                </div>
            </div>

            <section class="metrics-grid" id="overview">
                <article class="metric-card">
                    <div class="metric-heading">
                        <span>Registered Ocurrences</span>
                        <span class="material-symbols-rounded">graphic_eq</span>
                    </div>
                    <strong><?= number_format($statistics['total'], 0, ',', '.') ?></strong>
                    <small><span class="status-dot"></span> Total for the period</small>
                </article>

                <article class="metric-card">
                    <div class="metric-heading">
                        <span>Last 30 days</span>
                        <span class="material-symbols-rounded">calendar_month</span>
                    </div>
                    <strong><?= number_format($statistics['last_30_days'], 0, ',', '.') ?></strong>
                    <small>Records from the last month</small>
                </article>

                <article class="metric-card">
                    <div class="metric-heading">
                        <span>Region with the most records</span>
                        <span class="material-symbols-rounded">location_on</span>
                    </div>
                    <strong class="metric-region"><?= htmlspecialchars($statistics['top_region']) ?></strong>
                    <small>Highest cumulative volume</small>
                </article>

                <article class="metric-card metric-highlight">
                    <div class="metric-heading">
                        <span>Average detection time</span>
                        <span class="material-symbols-rounded">timer</span>
                    </div>
                    <strong><?= htmlspecialchars($statistics['average_detection']) ?></strong>
                    <small>Average identification time</small>
                </article>
            </section>

            <section class="charts-grid">
                <article class="dashboard-card evolution-card" id="evolution">
                    <div class="card-heading">
                        <div>
                            <p class="eyebrow">ACCOMPANIMENT</p>
                            <h3>Ocurrences Evolution</h3>
                        </div>
                        <span class="card-label">Per month</span>
                    </div>
                    <div class="chart-container">
                        <canvas id="evolutionChart"></canvas>
                    </div>
                </article>

                <article class="dashboard-card distribution-card" id="distribution">
                    <div class="card-heading">
                        <div>
                            <p class="eyebrow">DISTRIBUTION</p>
                            <h3>Ocurrences by region</h3>
                        </div>
                        <span class="material-symbols-rounded card-icon">pie_chart</span>
                    </div>
                    <div class="chart-container doughnut-container">
                        <canvas id="regionChart"></canvas>
                    </div>
                    <div class="chart-legend">
                        <?php foreach ($statistics['regions'] as $index => $region): ?>
                            <div class="legend-item">
                                <span class="legend-color color-<?= $index ?>"></span>
                                <span><?= htmlspecialchars($region['name']) ?></span>
                                <strong><?= number_format($region['total'], 0, ',', '.') ?></strong>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </article>

                <article class="dashboard-card hours-card">
                    <div class="card-heading">
                        <div>
                            <p class="eyebrow">TIME INTERVALS</p>
                            <h3>Distribution throughout the day</h3>
                        </div>
                        <span class="material-symbols-rounded card-icon">schedule</span>
                    </div>
                    <div class="chart-container">
                        <canvas id="hoursChart"></canvas>
                    </div>
                </article>

                <article class="dashboard-card regional-card" id="regional">
                    <div class="card-heading">
                        <div>
                            <p class="eyebrow">TERRITORIAL SUMMARY</p>
                            <h3>Records by region</h3>
                        </div>
                        <span class="card-label">Grouped data</span>
                    </div>

                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Region</th>
                                    <th>Ocurrences</th>
                                    <th>Participation</th>
                                    <th>Situation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($statistics['regions'] as $index => $region):
                                    $percentage = $regionTotal > 0 ? ($region['total'] / $regionTotal) * 100 : 0;
                                ?>
                                    <tr>
                                        <td><?= htmlspecialchars($region['name']) ?></td>
                                        <td><?= number_format($region['total'], 0, ',', '.') ?></td>
                                        <td><?= number_format($percentage, 1, ',', '.') ?>%</td>
                                        <td>
                                            <span class="table-status <?= $index === 0 ? 'primary' : '' ?>">
                                                <?= $index === 0 ? 'Highest Volume' : 'Monitoring' ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </article>
            </section>

            <footer class="privacy-notice">
                <span class="material-symbols-rounded">verified_user</span>
                <div>
                    <strong>Privacy and transparency</strong>
                    <p>This dashboard presents only aggregated statistical information. Exact locations, addresses, and data that could identify individuals or compromise security operations are not displayed.</p>
                </div>
            </footer>
        </section>
    </main>

    <script>
        const chartLabels = <?= json_encode($statistics['months'], JSON_UNESCAPED_UNICODE) ?>;
        const monthlyValues = <?= json_encode($statistics['monthly_values']) ?>;
        const regionLabels = <?= json_encode($regionLabels, JSON_UNESCAPED_UNICODE) ?>;
        const regionValues = <?= json_encode($regionValues) ?>;
        const hourLabels = <?= json_encode($hourLabels, JSON_UNESCAPED_UNICODE) ?>;
        const hourValues = <?= json_encode($statistics['hours']) ?>;

        Chart.defaults.font.family = 'Montserrat';
        Chart.defaults.color = '#a6a6a6';

        const axisOptions = {
            x: {
                grid: { display: false },
                ticks: { color: '#a6a6a6', font: { size: 10 } },
                border: { color: '#504d4d' }
            },
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(255,255,255,.07)' },
                ticks: { color: '#a6a6a6', precision: 0, font: { size: 10 } },
                border: { display: false }
            }
        };

        new Chart(document.getElementById('evolutionChart'), {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Ocorrências',
                    data: monthlyValues,
                    backgroundColor: '#e8c82b',
                    hoverBackgroundColor: '#fcde33',
                    borderRadius: 6,
                    maxBarThickness: 42
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: axisOptions
            }
        });

        new Chart(document.getElementById('regionChart'), {
            type: 'doughnut',
            data: {
                labels: regionLabels,
                datasets: [{
                    data: regionValues,
                    backgroundColor: ['#fcde33', '#e8c82b', '#eacd3e', '#a6a6a6', '#777171'],
                    borderColor: '#242222',
                    borderWidth: 4,
                    hoverOffset: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: { legend: { display: false } }
            }
        });

        new Chart(document.getElementById('hoursChart'), {
            type: 'line',
            data: {
                labels: hourLabels,
                datasets: [{
                    label: 'Ocorrências',
                    data: hourValues,
                    borderColor: '#fcde33',
                    backgroundColor: 'rgba(252,222,51,.12)',
                    fill: true,
                    tension: .38,
                    pointRadius: 3,
                    pointBackgroundColor: '#fcde33'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: axisOptions
            }
        });

        // O seletor visual fica pronto para receber os períodos retornados pelo backend.
        document.getElementById('period').addEventListener('change', function () {
            // Integre aqui a atualização dos dados conforme o período selecionado.
            console.info('Período selecionado:', this.value);
        });
    </script>
</body>
</html>
