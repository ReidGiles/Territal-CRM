<div ng-app="TerritalCRM" ng-controller="dashboardController">
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
                <tr>{{test}}
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
                    echo "<td><a href='index.php?p=editProperty&propertyID=" . $property['PropertyID'] . "'" . '>' . $property['PropertyAddress'] . "</a></td>";
                    
                    if ($tenant){
                        echo "<td><a href='index.php?p=editProperty&propertyID=" . $property['PropertyID'] . "'" . '>' . $tenant['TenantForename'] . " " . $tenant['TenantSurname'] . "</a></td>";
                    }
                    else echo "<td><a href='index.php?p=editProperty&propertyID=" . $property['PropertyID'] . "'" . '>' . "No tenant on record</a></td>";
                    echo "<td><a href='index.php?p=editProperty&propertyID=" . $property['PropertyID'] . "'" . '>' . "£" . $property['PropertyRent'] . "</a></td>";
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
                    <tr ng-repeat="property in propertyTenantLink">
                        <td>{{property.value.TenantForename + " " + property.value.TenantSurname}}</td>
                        <td>{{property.key.PropertyAddress}}</td>
                        <td>{{property.key.PropertyRent}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>