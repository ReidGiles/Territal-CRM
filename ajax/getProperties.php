<?php
    require_once('../includes/db.php');
    require_once('../classes\properties.classes.php');
    $propertyObj = new properties($DBH);
    $properties = $propertyObj->getProperties($_SESSION['userData']['UserID']);
    echo json_encode($properties);
?>