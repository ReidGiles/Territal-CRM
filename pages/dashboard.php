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
                    <th>Property Type</th>
                    <th>Bedrooms</th>
                    <th>Monthly Rent</th>
                </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="property in propertyTenantLink">
                        <td><a href='index.php?p=editProperty&propertyID={{property.key.PropertyID}}'>{{property.key.BuildingName_StreetNo + ' ' + property.key.Street + ', ' + property.key.City}}</a></td>
                        <td><a href='index.php?p=editProperty&propertyID={{property.key.PropertyID}}'>{{property.value.FirstName + " " + property.value.LastName}}</a></td>
                        <td><a href='index.php?p=editProperty&propertyID={{property.key.PropertyID}}'>{{property.key.PropertyType}}</a></td>                       
                        <td><a href='index.php?p=editProperty&propertyID={{property.key.PropertyID}}'>{{property.key.Bedrooms}}</a></td>                       
                        <td><a href='index.php?p=editProperty&propertyID={{property.key.PropertyID}}'>{{property.key.MonthlyRent}}</a></td>
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
                    <th>Property Type</th>
                    <th>Bedrooms</th>
                    <th>Monthly Rent</th>
                </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="property in unoccupiedProperties">
                        <td><a href='index.php?p=editProperty&propertyID={{property.PropertyID}}'>{{property.BuildingName_StreetNo + ' ' + property.Street + ', ' + property.City}}</a></td>
                        <td><a href='index.php?p=editProperty&propertyID={{property.PropertyID}}'>{{property.PropertyType}}</a></td>                       
                        <td><a href='index.php?p=editProperty&propertyID={{property.PropertyID}}'>{{property.Bedrooms}}</a></td>
                        <td><a href='index.php?p=editProperty&propertyID={{property.PropertyID}}'>{{property.MonthlyRent}}</a></td>
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
            <select ng-model="rentFilter" ng-change="repopulate()" class="form-control" id="rentFilter" name="rentFilter">
                <option value="nolimit">No limit</option>
                <option value="500">Under 500</option>
                <option value="750">500 to 749</option>
                <option value="1000">750 to 999</option>
                <option value="1250">1000 to 1249</option>
                <option value="1500">1250 to 1499</option>
                <option value="1750">1500 to 1749</option>
            </select>
        </div>
        <div class="form-group">
            <label for="TypeFilter">Property Type:</label>
            <select ng-model="typeFilter" ng-change="repopulate()" class="form-control" id="TypeFilter" name="TypeFilter">
                <option value="any">Any</option>
                <option value="Apartment">Apartment</option>
                <option value="Studio">Studio</option>
                <option value="House">House</option>
                <option value="Bungalow">Bungalow</option>
                <option value="Land">Land</option>
            </select>
        </div>
        <div class="form-group">
            <label for="BedroomsFilter">Bedrooms:</label>
            <select ng-model="bedroomsFilter" ng-change="repopulate()" class="form-control" id="BedroomsFilter" name="BedroomsFilter">
                <option value="any">Any</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
        <div class="form-group">
            <label for="tenantFilter">Tenant:</label>
            <select ng-model="tenantFilter" ng-change="repopulate()" ng-disabled="showUnoccupied" class="form-control" id="tenantFilter" name="tenantFilter">
            <option value="all">Any</option>
            <?php
                $tenants = $tenantObj->getTenants($_SESSION['userData']['UserID']);
                foreach ($tenants as &$tenant) {
                    $tenantID = $tenant['TenantID'];
                    echo '<option value="' . $tenantID . '">' . $tenant['FirstName'] . ' ' . $tenant['LastName'] . '</option>';
                }
            ?>
            </select>
        </div>
    </div>
</div>