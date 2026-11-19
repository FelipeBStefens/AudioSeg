<?php
    require_once __DIR__ . "/../connection.php";
    require_once __DIR__ . "/../queries/statistic_queries.php";

    function fetch_statistics_rows(mysqli $connection, String $sql, ?int $period = null) {

        $statement = $connection->prepare($sql);

        if (!$statement) {
            throw new Exception("Statistics query failed");
        }

        if ($period !== null) {
            $statement->bind_param("i", $period);
        }

        if (!$statement->execute()) {
            throw new Exception("Statistics query failed");
        }

        $result = $statement->get_result();

        if (!$result) {
            throw new Exception("Statistics query failed");
        }

        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $statement->close();
        return $rows;
    }

    function get_statistics(String $user_role, int $period) {

        $connection = user_connection($user_role);

        $totalResult = fetch_statistics_rows($connection, get_sql_statistics_total(), $period);
        $total = (int) ($totalResult[0]["total"] ?? 0);

        $last30Result = fetch_statistics_rows($connection, get_sql_statistics_last_30_days());
        $last30Days = (int) ($last30Result[0]["total"] ?? 0);

        $regionResult = fetch_statistics_rows($connection, get_sql_statistics_regions(), $period);
        $regions = [];
        $otherRegions = 0;

        foreach ($regionResult as $index => $row) {
            
            if ($index < 5) {
                $regions[] = ["name" => $row["name"], "total" => (int) $row["total"]];
            } 
            else {
                $otherRegions += (int) $row["total"];
            }
        }

        if ($otherRegions > 0) {
            $regions[] = ["name" => "Other Regions", "total" => $otherRegions];
        }

        $topRegion = $regionResult[0]["name"] ?? "No data";

        $monthlyResult = fetch_statistics_rows($connection, get_sql_statistics_monthly(), $period);
        $months = [];
        $monthlyValues = [];

        foreach ($monthlyResult as $row) {

            $months[] = $row["month_label"];
            $monthlyValues[] = (int) $row["total"];
        }

        $hourResult = fetch_statistics_rows($connection, get_sql_statistics_hours(), $period);
        $hourValues = array_fill(0, 8, 0);

        foreach ($hourResult as $row) {

            $index = (int) $row["hour_group"];

            if ($index >= 0 && $index < 8) {
                $hourValues[$index] = (int) $row["total"];
            }
        }

        $gunResult = fetch_statistics_rows($connection, get_sql_statistics_identified_guns(), $period);
        $identifiedGuns = (int) ($gunResult[0]["total"] ?? 0);

        $regionTotal = array_sum(array_column($regions, "total"));
        $connection->close();

        return [
            "period" => $period,
            "total" => $total,
            "last_30_days" => $last30Days,
            "top_region" => $topRegion,
            "identified_guns" => $identifiedGuns,
            "months" => $months,
            "monthly_values" => $monthlyValues,
            "regions" => $regions,
            "region_total" => $regionTotal,
            "hours" => $hourValues
        ];
    }
?>