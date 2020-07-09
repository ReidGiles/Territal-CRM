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
    $propertyID;   
    if (isset($_GET['propertyID']))
    {
        $propertyID = $_GET['propertyID'];
    }
    $oldPropertyData = $propertyObj->getProperty($_SESSION['userData']['UserID'], $propertyID);
    $oldTenantData = $tenantObj->getTenant($_SESSION['userData']['UserID'], $oldPropertyData['TenantID']);
?>

<div class="pageHeader">
Edit Property
</div>

<div class="container card mt-5 editCards overflow-auto">
    <div class="card-header">
        <h1>Edit Property</h1>
        <h6>Complete the form below to update your property details.</h6>
    </div>
    <div class="card-body">
        <?php              
            if(isset($_POST['update']))
            {
                $buildingNameStreetNo = $_POST['buildingNameStreetNo'];
                $street = $_POST['street'];
                $city = $_POST['city'];
                $postcode = $_POST['postcode'];
                $propertyType = $_POST['type'];
                $bedrooms = $_POST['bedrooms'];
                $rent = $_POST['rent'];
                if (empty($buildingNameStreetNo)){
                    $buildingNameStreetNo = $oldPropertyData['BuildingName_StreetNo'];
                }
                if (empty($street)){
                    $street = $oldPropertyData['Street'];
                }
                if (empty($city)){
                    $city = $oldPropertyData['City'];
                }
                if (empty($postcode)){
                    $postcode = $oldPropertyData['Postcode'];
                }
                if (empty($propertyType)){
                    $propertyType = $oldPropertyData['PropertyType'];
                }
                if (empty($bedrooms)){
                    $bedrooms = $oldPropertyData['Bedrooms'];
                }
                if (empty($rent)){
                    $rent = $oldPropertyData['MonthlyRent'];
                }
                if ($_POST['tenant'] !== 'Currently unoccupied'){
                    $addNewProperty = $propertyObj->updateProperty($_SESSION['userData']['UserID'], $buildingNameStreetNo, $street, $city, $postcode, $propertyType, $bedrooms, $rent, $_POST['tenant'], $propertyID);
                }
                else $addNewProperty = $propertyObj->updatePropertyWithoutTenant($_SESSION['userData']['UserID'], $buildingNameStreetNo, $street, $city, $postcode, $propertyType, $bedrooms, $rent, $propertyID);

                if($addNewProperty)
                {
                    echo '<div class="alert alert-success" role="alert">Your property has been updated!</div>';
                }
            }

            if(isset($_POST['delete']))
            {
                $deleteProperty = $propertyObj->deleteProperty( $propertyID);

                if($deleteProperty)
                {
                    echo '<div class="alert alert-success" role="alert">Your property has been deleted!</div>';
                }
            }
        ?>

        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="address">Building Name / Street Number</label>
                <input type="text" class="form-control" id="buildingNameStreetNo" name="buildingNameStreetNo" placeholder=<?php echo $oldPropertyData['BuildingName_StreetNo'] ?>>
            </div>
            <div class="form-group">
                <label for="address">Street</label>
                <input type="text" class="form-control" id="street" name="street" placeholder=<?php echo $oldPropertyData['Street'] ?>>
            </div>
            <div class="form-group">
                <label for="address">City</label>
                <input type="text" class="form-control" id="city" name="city" placeholder=<?php echo $oldPropertyData['City'] ?>>
            </div>
            <div class="form-group">
                <label for="address">Postcode</label>
                <input type="text" class="form-control" id="postcode" name="postcode" placeholder=<?php echo $oldPropertyData['Postcode'] ?>>
            </div>
            <div class="form-group">
                <label for="rent">Property Type</label>
                <input type="text" class="form-control" id="type" name="type" placeholder=<?php echo $oldPropertyData['PropertyType'] ?>>
            </div>
            <div class="form-group">
                <label for="rent">Bedrooms</label>
                <input type="number" class="form-control" id="bedrooms" name="bedrooms" placeholder=<?php echo $oldPropertyData['Bedrooms'] ?>>
            </div>
            <div class="form-group">
                <label for="rent">Monthly Rent</label>
                <input type="number" class="form-control" id="rent" name="rent" placeholder=<?php echo $oldPropertyData['MonthlyRent'] ?>>
            </div>
            <div class="form-group">
                <label for="tenant">Assign Tenant:</label>
                <select class="form-control" id="tenant" name="tenant">
                    <?php
                        if ($oldTenantData)
                        {
                            echo '<option value="' . $oldTenantData['TenantID'] . '">' . $oldTenantData['FirstName'] . ' ' . $oldTenantData['LastName'] . '</option>';
                        }
                        else echo "<option>Currently unoccupied</option>"
                    ?>
                    <?php
                        $tenants = $tenantObj->getTenants($_SESSION['userData']['UserID']);
                        foreach ($tenants as &$tenant) {
                            $tenantID = $tenant['TenantID'];
                            if ($oldTenantData['FirstName'] . " " . $oldTenantData['LastName'] !== $tenant['FirstName'] . ' ' . $tenant['LastName'])
                            {
                                echo '<option value="' . $tenantID . '">' . $tenant['FirstName'] . ' ' . $tenant['LastName'] . '</option>';
                            }
                        }
                    ?>
                </select>
            </div>
            <button type="submit" name="update" class="btn btn-default">Update Property</button>
            <button id="delete" type="submit" name="delete" class="btn btn-default">Delete Property</button>
        </form>
    </div>
</div>