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
            require_once('classes/properties.classes.php');
            require_once('classes/tenants.classes.php');
            $propertyObj = new properties($DBH);
            $tenantObj = new tenants($DBH);
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

    <div ng-show="showOccupied" id="clientCard" class="card container mt-5">
        <h1 id="occupiedHeader" class="card-header">Occupied Properties</h1>
        <div class="card-body dashboardCardData">       
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Address</th>
                    <th>Tenant</th>
                    <th>Monthly Rent</th>
                </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="property in propertyTenantLink">
                        <td><a href='index.php?p=editProperty&propertyID={{property.key.PropertyID}}'>{{property.key.PropertyAddress}}</a></td>
                        <td><a href='index.php?p=editProperty&propertyID={{property.key.PropertyID}}'>{{property.value.TenantForename + " " + property.value.TenantSurname}}</a></td>                       
                        <td><a href='index.php?p=editProperty&propertyID={{property.key.PropertyID}}'>{{property.key.PropertyRent}}</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div ng-show="showUnoccupied" id="clientCard" class="card container mt-5">
        <h1 class="card-header">Inactive Properties</h1>
        <div class="card-body dashboardCardData">       
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Address</th>
                    <th>Tenant</th>
                    <th>Monthly Rent</th>
                </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="property in unoccupiedProperties">
                        <td><a href='index.php?p=editProperty&propertyID={{property.PropertyID}}'>{{property.PropertyAddress}}</a></td>
                        <td><a href='index.php?p=editProperty&propertyID={{property.PropertyID}}'>Currently Unoccupied</a></td>                       
                        <td><a href='index.php?p=editProperty&propertyID={{property.PropertyID}}'>{{property.PropertyRent}}</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div id="filterCard" class="card container mt-5">
        <h1 class="card-header">Filter</h1>
        <div class="form-group">
            <label for="OccupationFilter">Occupation:</label>
            <select ng-model="propertySwitch" ng-change="toggleProperties()" class="form-control" id="OccupationFilter" name="OccupationFilter">
                <option value="occupied">Occupied</option>
                <option value="unoccupied">Unoccupied</option>
            </select>
        </div>
        <div class="form-group">
            <label for="rentFilter">Monthly Rent:</label>
            <select ng-model="rentFilter" ng-change="filterRent()" class="form-control" id="rentFilter" name="rentFilter">
                <option value="nolimit">No limit</option>
                <option value="500">Under 500</option>
                <option value="750">500 to 749</option>
                <option value="1000">750 to 999</option>
                <option value="1250">1000 to 1249</option>
                <option value="1500">1250 to 1499</option>
                <option value="2000">1500 to 1999</option>
            </select>
        </div>
        <div class="form-group">
            <label for="tenantFilter">Tenant:</label>
            <select class="form-control" id="tenantFilter" name="tenantFilter">
            <option>All</option>
            <?php
                $tenants = $tenantObj->getTenants($_SESSION['userData']['UserID']);
                foreach ($tenants as &$tenant) {
                    $tenantID = $tenant['TenantID'];
                    echo '<option value="' . $tenantID . '">' . $tenant['TenantForename'] . ' ' . $tenant['TenantSurname'] . '</option>';
                }
            ?>
            </select>
        </div>
        <div class="form-group">
            <label for="rentFilter">Address:</label>
            <select class="form-control" id="rentFilter" name="rentFilter">
                <option>All</option>
                <option>0 - 499,999</option>
                <option>500,000 - 999,999</option>
            </select>
        </div>
    </div>
</div>