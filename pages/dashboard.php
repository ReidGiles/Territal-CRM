<div class="pageHeader">
    <?php 
        if(!$_SESSION['loggedin'])
        {
            //User is not logged in
            echo "<h1>Access Denied</h1>";
            echo "<script> window.location.assign('index.php?p=login'); </script>";
            exit;
        }
        //Include users class
        require_once('classes/users.classes.php');
        $userObj = new users($DBH); //Lets pass through our DB connection
        $userProfile = $userObj->getUser($_SESSION['userData']['UserID']); //Call the getUser function
        // If the user has set their forename then greet them, else encourage them to update their profile.
        if ($userProfile['UserForename'])
        {
            echo "Welcome back, " . $userProfile['UserForename'];
        }
        else
        {
            echo "Welcome. Your user details are incomplete, please use 'Edit Profile' to update them.";
        }
    ?>
</div>

<div id="propertyCard" class="card container mt-5">
    <h1 class="card-header">Properties</h1>
    <div class="card-body dashboardCardData">       
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Address</th>
                <th>Name</th>
                <th>Monthly Rent</th>
            </tr>
            </thead>
            <tbody>
            <?php
            require_once('classes/properties.classes.php');
            require_once('classes/tenants.classes.php');
            $propertyObj = new properties($DBH);
            $tenantObj = new tenants($DBH);
            $properties = $propertyObj->getProperties($_SESSION['userData']['UserID']);
            foreach ($properties as &$property) {
                $tenant = $tenantObj->getTenant($_SESSION['userData']['UserID'], $property['TenantID']);
                echo "<tr>";
                echo "<td>" . $property['PropertyAddress'] . "</td>";
                echo "<td>" . $tenant['TenantForename'] . " " . $tenant['TenantSurname'] . "</td>";
                echo "<td>" . "£" . $property['PropertyRent'] . "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<div id="clientCard" class="card container mt-5">
<h1 class="card-header">Tenants</h1>
    <div class="card-body dashboardCardData">       
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Monthly Rent</th>
            </tr>
            </thead>
            <tbody>
            <?php
            //Include users class
            require_once('classes/tenants.classes.php');
            $tenantObj = new tenants($DBH);
            $propertyObj = new properties($DBH);
            $tenants = $tenantObj->getTenants($_SESSION['userData']['UserID']);
            foreach ($tenants as &$tenant) {
                $property = $propertyObj->getProperty($_SESSION['userData']['UserID'], $tenant['TenantID']);
                echo "<tr>";
                echo "<td>" . $tenant['TenantForename'] . " " . $tenant['TenantSurname'] . "</td>";
                if (isset($property['PropertyAddress'])){
                    echo "<td>" . $property['PropertyAddress'] . "</td>";
                }
                else echo "<td>No property on record</td>";
                if (isset($property['PropertyRent'])){
                    echo "<td>" . "£" . $property['PropertyRent'] . "</td>";
                }
                else echo "<td>£0</td>";
                echo "</tr>";
            }
            ?>
            </tbody>            
        </table>
    </div>
</div>