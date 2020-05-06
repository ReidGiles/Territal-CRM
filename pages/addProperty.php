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
Add New Property
</div>

<div class="container card mt-5">
    <div class="card-body">
        <h1>Add a new rental property</h1>
        <p>Complete the form below to add a new property.</p>

        <?php   
            //Include users class
            require_once('classes/users.classes.php');
            $userObj = new users($DBH); //Lets pass through our DB connection

            if(isset($_POST['submit']))
            {
                //Upload Image Here

                $addNewProperty = $userObj->updateUser($_SESSION['userData']['UserID'], $_POST['name'], $_POST['country'], $_POST['gender'], $_FILES['profile_image']); //Call the updateUser function

                if($addNewProperty)
                {
                    echo '<div class="alert alert-success" role="alert">Your profile has been updated!</div>';
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
            <button type="submit" name="submit" class="btn btn-default">Add Property</button>
        </form>
    </div>
</div>