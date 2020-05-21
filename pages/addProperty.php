<?php
    if(!$_SESSION['loggedin'])
    {
		//User is not logged in
		echo "<h1>Access Denied</h1>";
		echo "<script> window.location.assign('index.php?p=login'); </script>";
		exit;
    }
    require_once('classes/properties.classes.php');
    $propertyObj = new properties($DBH);
?>

<div class="pageHeader">
Add New Property
</div>

<div class="container card mt-5 editCards overflow-auto">
    <div class="card-header">
        <h1>Add a new rental property</h1>
        <h6>Complete the form below to add a new property.</h6>
    </div>
    <div class="card-body">      
        <?php              
            if(isset($_POST['submit']))
            {
                if ($_POST['tenant'] !== 'Unoccupied'){
                    $addNewProperty = $propertyObj->addPropertyWithTenant($_SESSION['userData']['UserID'], $_POST['buildingNameStreetNo'], $_POST['street'], $_POST['city'], $_POST['postcode'], $_POST['type'], $_POST['bedrooms'], $_POST['rent'], $_POST['tenant']);
                }
                else $addNewProperty = $propertyObj->addPropertyWithoutTenant($_SESSION['userData']['UserID'], $_POST['buildingNameStreetNo'], $_POST['street'], $_POST['city'], $_POST['postcode'], $_POST['type'], $_POST['bedrooms'], $_POST['rent']);

                if($addNewProperty)
                {
                    echo '<div class="alert alert-success" role="alert">Your new property has been added!</div>';
                }
            }   
        ?>
 
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="address">Building Name / Street Number</label>
                <input type="text" class="form-control" id="buildingNameStreetNo" name="buildingNameStreetNo">
            </div>
            <div class="form-group">
                <label for="address">Street</label>
                <input type="text" class="form-control" id="street" name="street">
            </div>
            <div class="form-group">
                <label for="address">City</label>
                <input type="text" class="form-control" id="city" name="city">
            </div>
            <div class="form-group">
                <label for="address">Postcode</label>
                <input type="text" class="form-control" id="postcode" name="postcode">
            </div>
            <div class="form-group">
                <label for="rent">Property Type</label>
                <input type="text" class="form-control" id="type" name="type">
            </div>
            <div class="form-group">
                <label for="rent">Bedrooms</label>
                <input type="number" class="form-control" id="bedrooms" name="bedrooms">
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
                            echo '<option value="' . $tenantID . '">' . $tenant['FirstName'] . ' ' . $tenant['LastName'] . '</option>';
                        }
                    ?>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-default">Add Property</button>
        </form>
    </div>
</div>