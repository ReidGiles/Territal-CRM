<?php
require_once('includes/db.php');
require_once('includes/header.php');

if (isset($_GET['p']))
{
    require_once('pages/'.$_GET['p'].'.php');
}
else require_once('pages/dashboard.php');

require_once('includes/footer.php');
?>