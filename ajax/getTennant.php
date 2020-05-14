<?php
    require_once('../includes/db.php');
    require_once('../classes/tenants.classes.php');
    $tenantObj = new tenants($DBH);
    $tenant = $tenantObj->getTenant($_SESSION['userData']['UserID'], $_POST['tenantID']);
    echo json_encode($tenant);
?>