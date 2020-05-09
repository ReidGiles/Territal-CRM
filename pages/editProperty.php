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

<div class="container card mt-5">
    <div class="card-body">
        <h1>Edit Property</h1>
        <p>Complete the form below to update your property details.</p>
        <?php              
            if(isset($_POST['submit']))
            {
                $adress = $_POST['address'];
                $rent = $_POST['rent'];
                if (empty($adress)){
                    $adress = $oldPropertyData['PropertyAddress'];
                }
                if (empty($rent)){
                    $rent = $oldPropertyData['PropertyRent'];
                }
                if ($_POST['tenant'] !== 'Unoccupied'){
                    $addNewProperty = $propertyObj->updateProperty($_SESSION['userData']['UserID'], $adress, $rent, $_POST['tenant'], $propertyID);
                }
                else $addNewProperty = $propertyObj->updateProperty($_SESSION['userData']['UserID'], $adress, $rent, $oldPropertyData['TenantID'], $propertyID);

                if($addNewProperty)
                {
                    echo '<div class="alert alert-success" role="alert">Your property has been updated!</div>';
                }
            }
        ?>
 
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="address">Property Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="<?php echo $oldPropertyData['PropertyAddress'] ?>">
            </div>
            <div class="form-group">
                <label for="rent">Monthly Rent</label>
                <input type="number" class="form-control" id="rent" name="rent" placeholder="<?php echo $oldPropertyData['PropertyRent'] ?>">
            </div>
            <div class="form-group">
                <label for="tenant">Assign Tenant:</label>
                <select class="form-control" id="tenant" name="tenant">
                    <?php
                        if ($oldTenantData)
                        {
                            echo '<option value="' . $oldTenantData['TenantID'] . '">' . $oldTenantData['TenantForename'] . ' ' . $oldTenantData['TenantSurname'] . '</option>';
                        }
                        else echo "<option>Currently unoccupied</option>"
                    ?>
                    <?php
                        $tenants = $tenantObj->getTenants($_SESSION['userData']['UserID']);
                        foreach ($tenants as &$tenant) {
                            $tenantID = $tenant['TenantID'];
                            if ($oldTenantData['TenantForename'] . " " . $oldTenantData['TenantSurname'] !== $tenant['TenantForename'] . ' ' . $tenant['TenantSurname'])
                            {
                                echo '<option value="' . $tenantID . '">' . $tenant['TenantForename'] . ' ' . $tenant['TenantSurname'] . '</option>';
                            }
                        }
                    ?>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-default">Update Property</button>
        </form>
    </div>
</div>