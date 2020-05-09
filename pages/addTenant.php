<?php
    if(!$_SESSION['loggedin'])
    {
		//User is not logged in
		echo "<h1>Access Denied</h1>";
		echo "<script> window.location.assign('index.php?p=login'); </script>";
		exit;
    }
    require_once('classes/properties.classes.php');
    require_once('classes/tenants.classes.php');
    $propertyObj = new properties($DBH);
    $tenantObj = new tenants($DBH);
?>

<div class="pageHeader">
Add New Tenant
</div>

<div class="container card mt-5">
    <div class="card-body">
        <h1>Add a new tenant</h1>
        <p>Complete the form below to add a new tenant.</p>

        <?php   
            require_once('classes/tenants.classes.php');
            $tenantObj = new tenants($DBH);

            if(isset($_POST['submit']))
            {

                $addNewTenant = $tenantObj->addTenant($_SESSION['userData']['UserID'], $_POST['forename'], $_POST['surname'], $_POST['gender'], $_POST['age']);

                if($addNewTenant)
                {
                    echo '<div class="alert alert-success" role="alert">Your new tenant has been added!</div>';
                }
            }
        ?>
 
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="forename">Tenant Forename</label>
                <input type="text" class="form-control" id="forename" name="forename">
            </div>
            <div class="form-group">
                <label for="surname">Tenant Surname</label>
                <input type="text" class="form-control" id="surname" name="surname">
            </div>
            <div class="form-group">
                <label for="gender">Tenant Gender</label>
                <input type="text" class="form-control" id="gender" name="gender">
            </div>
            <div class="form-group">
                <label for="age">Tenant Age</label>
                <input type="number" class="form-control" id="age" name="age">
            </div>
            <button type="submit" name="submit" class="btn btn-default">Add Tenant</button>
        </form>
    </div>
</div>