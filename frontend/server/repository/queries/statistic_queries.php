<?php
    function get_sql_statistics_total() {
        return "
            SELECT COUNT(DISTINCT id_gunshot) AS total
            FROM vw_public_gunshots
            WHERE date_gunshot >= DATE_SUB(NOW(), INTERVAL ? DAY);
        ";
    }

    function get_sql_statistics_last_30_days() {
        return "
            SELECT COUNT(DISTINCT id_gunshot) AS total
            FROM vw_public_gunshots
            WHERE date_gunshot >= DATE_SUB(NOW(), INTERVAL 30 DAY);
        ";
    }

    function get_sql_statistics_regions() {
        return "
            SELECT city AS name, COUNT(DISTINCT id_gunshot) AS total
            FROM vw_public_gunshots
            WHERE date_gunshot >= DATE_SUB(NOW(), INTERVAL ? DAY)
            GROUP BY city
            HAVING COUNT(DISTINCT id_gunshot) >= 5
            ORDER BY total DESC;
        ";
    }

    function get_sql_statistics_monthly() {
        return "
            SELECT DATE_FORMAT(MIN(date_gunshot), '%m/%Y') AS month_label, COUNT(DISTINCT id_gunshot) AS total
            FROM vw_public_gunshots
            WHERE date_gunshot >= DATE_SUB(NOW(), INTERVAL ? DAY)
            GROUP BY YEAR(date_gunshot), MONTH(date_gunshot)
            ORDER BY YEAR(date_gunshot), MONTH(date_gunshot);
        ";
    }

    function get_sql_statistics_hours() {
        return "
            SELECT FLOOR(HOUR(date_gunshot) / 3) AS hour_group, COUNT(DISTINCT id_gunshot) AS total
            FROM vw_public_gunshots
            WHERE date_gunshot >= DATE_SUB(NOW(), INTERVAL ? DAY)
            GROUP BY FLOOR(HOUR(date_gunshot) / 3)
            ORDER BY hour_group;
        ";
    }

    function get_sql_statistics_identified_guns() {
        return "
            SELECT COUNT(DISTINCT id_gun) AS total
            FROM vw_public_gunshots
            WHERE date_gunshot >= DATE_SUB(NOW(), INTERVAL ? DAY)
            AND id_gun IS NOT NULL;
        ";
    }
?>