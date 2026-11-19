<?php
    
    require_once __DIR__ . "/../repository/data_access_object/statistic_repository.php";

    $user_role = $_SESSION["user_data"]["role_user"];

    $allowedPeriods = [30, 90, 365];
    $period = isset($_GET["period"]) ? (int) $_GET["period"] : 90;

    if (!in_array($period, $allowedPeriods, true)) {
        $period = 90;
    }

    $statistics = get_statistics($user_role, $period);
    return $statistics;
?>