<div class="pageHeader">
    <?php 
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
            //Include users class
            require_once('classes/properties.classes.php');
            require_once('classes/tenants.classes.php');
            $propertyObj = new properties($DBH);
            $tenantObj = new tenants($DBH);
            $properties = $propertyObj->getProperties();
            foreach ($properties as &$property) {
                $tenant = $tenantObj->getTenant($property['TenantID']);
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
            $tenants = $tenantObj->getTenants();
            foreach ($tenants as &$tenant) {
                $property = $propertyObj->getProperty($tenant['TenantID']);
                echo "<tr>";
                echo "<td>" . $tenant['TenantForename'] . " " . $tenant['TenantSurname'] . "</td>";
                echo "<td>" . $property['PropertyAddress'] . "</td>";
                echo "<td>" . "£" . $property['PropertyRent'] . "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>            
        </table>
    </div>
</div>