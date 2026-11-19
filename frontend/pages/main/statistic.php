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

    $statistics = require __DIR__ . "/../../server/main/statistic_service.php";

    $regionLabels = array_column($statistics["regions"], "name");
    $regionValues = array_column($statistics["regions"], "total");

    $hourLabels = ["00–03h", "03–06h", "06–09h", "09–12h", "12–15h", "15–18h", "18–21h", "21–00h"];
?>

<!DOCTYPE html>

<html lang="pt-BR">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>AudioSeg - Statistics</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
        <link rel="stylesheet" href="../../style/main/statistic.css">
        <link rel="icon" href="../../assets/images/audioseg_logo.png" type="image/png">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script src="../../script/main/statistic.js" defer></script>
    </head>

    <body>
        <?php include __DIR__ . "/../header/header.php"; ?>

        <main class="statistics-layout">

            <section class="statistics-content">

                <div class="page-heading">
                    <div>
                        <p class="eyebrow">PUBLIC DATA • AUDIOSEG</p>
                        <h1>Statistics Panel</h1>
                    </div>

                    <form class="period-filter" method="GET">

                        <label for="period">Analysis Period</label>

                        <select id="period" name="period" onchange="this.form.submit()">
                            <option value="30" <?php echo $statistics["period"] === 30 ? "selected" : ""; ?>>Last 30 days</option>
                            <option value="90" <?php echo $statistics["period"] === 90 ? "selected" : ""; ?>>Last 90 days</option>
                            <option value="365" <?php echo $statistics["period"] === 365 ? "selected" : ""; ?>>Last 12 months</option>
                        </select>
                    </form>
                </div>

                <section class="metrics-grid" id="overview">

                    <article class="metric-card">
                        <div class="metric-heading">
                            <span>Registered Occurrences</span>
                            <span class="material-symbols-rounded">graphic_eq</span>
                        </div>

                        <strong><?php echo number_format($statistics["total"], 0, ",", "."); ?></strong>
                    </article>

                    <article class="metric-card">
                        <div class="metric-heading">
                            <span>Last 30 days</span>
                            <span class="material-symbols-rounded">calendar_month</span>
                        </div>

                        <strong><?php echo number_format($statistics["last_30_days"], 0, ",", "."); ?></strong>
                    </article>

                    <article class="metric-card">
                        <div class="metric-heading">
                            <span>Region with the most records</span>
                            <span class="material-symbols-rounded">location_on</span>
                        </div>

                        <strong class="metric-region"><?php echo $statistics["top_region"]; ?></strong>
                    </article>


                    <article class="metric-card metric-highlight">
                        <div class="metric-heading">
                            <span>Identified Weapons</span>
                            <span class="material-symbols-rounded">security</span>
                        </div>

                        <strong><?php echo number_format($statistics["identified_guns"], 0, ",", "."); ?></strong>
                    </article>
                </section>

                <section class="charts-grid">

                    <article class="dashboard-card evolution-card" id="evolution">
                        <div class="card-heading">
                            <div>
                                <p class="eyebrow">ACCOMPANIMENT</p>
                                <h3>Occurrences Evolution</h3>
                            </div>
                        </div>

                        <div class="chart-container">
                            <canvas id="evolutionChart"></canvas>
                        </div>
                    </article>

                    <article class="dashboard-card distribution-card" id="distribution">

                        <div class="card-heading">
                            <div>
                                <p class="eyebrow">DISTRIBUTION</p>
                                <h3>Occurrences by region</h3>
                            </div>

                            <span class="material-symbols-rounded card-icon">pie_chart</span>
                        </div>

                        <div class="chart-container doughnut-container">
                            <canvas id="regionChart"></canvas>
                        </div>

                        <div class="chart-legend">

                            <?php foreach ($statistics["regions"] as $index => $region) { ?>
                                <div class="legend-item">
                                    <span class="legend-color color-<?php echo $index; ?>"></span>
                                    <span><?php echo $region["name"]; ?></span>
                                    <strong><?php echo number_format($region["total"], 0, ",", "."); ?></strong>
                                </div>
                            <?php } ?>
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
                                        <th>Occurrences</th>
                                        <th>Participation</th>
                                        <th>Situation</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php 
                                        foreach ($statistics["regions"] as $index => $region) {

                                            $percentage = 0;

                                            if ($statistics["region_total"] > 0) {
                                                $percentage = ($region["total"] / $statistics["region_total"]) * 100;
                                            }
                                            else {
                                                $percentage = 0;
                                            }
                                    ?>

                                        <tr>
                                            <td><?php echo $region["name"]; ?></td>
                                            <td><?php echo number_format($region["total"], 0, ",", "."); ?></td>
                                            <td><?php echo number_format($percentage, 1, ",", "."); ?>%</td>
                                            <td><span class="table-status <?php echo $index === 0 ? "primary" : ""; ?>"><?php echo $index === 0 ? "Highest Volume" : "Monitoring"; ?></span></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </article>
                </section>
            </section>
        </main>
        
        <script id="statistics-data" type="application/json">
            <?php echo json_encode(["months" => $statistics["months"], "monthly_values" => $statistics["monthly_values"], "regions" => $regionLabels, "region_values" => $regionValues, "hours" => $hourLabels, "hour_values" => $statistics["hours"]]); ?>
        </script>
    </body>
</html>