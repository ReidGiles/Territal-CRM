<?php
    if(!$_SESSION['loggedin'])
    {
		//User is not logged in
		echo "<h1>Access Denied</h1>";
		echo "<script> window.location.assign('index.php?p=login'); </script>";
		exit;
    }
?>

<div class="pageHeader">
Add New Property
</div>

<div class="container card mt-5">
    <div class="card-body">
        <h1>Add a new rental property</h1>
        <p>Complete the form below to add a new property.</p>

        <?php   
            //Include users class
            require_once('classes/properties.classes.php');
            $propertyObj = new properties($DBH); //Lets pass through our DB connection

            if(isset($_POST['submit']))
            {
                if ($_POST['tenant'] !== 'Unoccupied'){
                    $addNewProperty = $propertyObj->addPropertyWithTenant($_SESSION['userData']['UserID'], $_POST['address'], $_POST['rent'], $_POST['tenant']);
                }
                else $addNewProperty = $propertyObj->addPropertyWithoutTenant($_SESSION['userData']['UserID'], $_POST['address'], $_POST['rent']);

                if($addNewProperty)
                {
                    echo '<div class="alert alert-success" role="alert">Your new property has been added!</div>';
                }
            }   
        ?>
 
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="address">Property Address</label>
                <input type="text" class="form-control" id="address" name="address">
            </div>
            <div class="form-group">
                <label for="rent">Monthly Rent</label>
                <input type="number" class="form-control" id="rent" name="rent">
            </div>
            <div class="form-group">
                <label for="tenant">Assign Tenant:</label>
                <select class="form-control" id="tenant" name="tenant">
                    <option>Unoccupied</option>
                    <?php
                        require_once('classes/tenants.classes.php');
                        $tenantObj = new tenants($DBH);
                        $tenants = $tenantObj->getTenants($_SESSION['userData']['UserID']);
                        foreach ($tenants as &$tenant) {
                            $tenantID = $tenant['TenantID'];
                            echo '<option value="' . $tenantID . '">' . $tenant['TenantForename'] . ' ' . $tenant['TenantSurname'] . '</option>';
                        }
                    ?>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-default">Add Property</button>
        </form>
    </div>
</div>