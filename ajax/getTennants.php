<?php
    require_once('../includes/db.php');
    require_once('../classes/tenants.classes.php');
    $tenantObj = new tenants($DBH);
    $tennants = $tenantObj->getTenants($_SESSION['userData']['UserID']);
    echo json_encode($tennants);
?>