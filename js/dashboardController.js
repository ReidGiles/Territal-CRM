angular.module('TerritalCRM', [])
    .controller('dashboardController', function ($scope, $http) {
        $scope.properties = [];
        $scope.tenants = [];
        $scope.propertyTenantLink = [];
        $scope.unoccupiedProperties = [];
        $scope.showOccupied = true;
        $scope.showUnoccupied = false;
        $scope.propertySwitch = "occupied";
        $scope.filter = [];       
        $scope.rentFilter = "nolimit";
        $scope.tenantFilter = "all";

        var populate = function(){
            $http.get("/Territal-CRM/ajax/getProperties.php").then(function (data, status, headers, config) {
                angular.forEach(data.data, function (value, key) {
                    $scope.properties.push(value);
                    if (!value.TenantID){
                        if ((value.MonthlyRent < parseInt($scope.rentFilter)) && value.MonthlyRent > (parseInt($scope.rentFilter)) - 250){
                            $scope.unoccupiedProperties.push(value);
                        }
                        else if ($scope.rentFilter == "nolimit"){
                            $scope.unoccupiedProperties.push(value);
                        }
                    }
                });
                $http.get("/Territal-CRM/ajax/getTennants.php").then(function (data, status, headers, config) {
                    angular.forEach(data.data, function (value, key) {
                        $scope.tenants.push(value);               
                    });
    
                    angular.forEach($scope.properties, function (value, key) {
                        var property = value;
                        angular.forEach($scope.tenants, function (value, key) {
                            var tenant = value;

                            


                            if (property.TenantID === tenant.TenantID){
                                if ((property.MonthlyRent < parseInt($scope.rentFilter)) && property.MonthlyRent >= (parseInt($scope.rentFilter)) - 250){
                                    if (property.TenantID == parseInt($scope.tenantFilter)){
                                        $scope.propertyTenantLink.push({key: property, value: tenant});
                                    }
                                    else if ($scope.tenantFilter == "all"){
                                        $scope.propertyTenantLink.push({key: property, value: tenant});
                                    }
                                }
                                else if ($scope.rentFilter == "nolimit"){
                                    if (property.TenantID == parseInt($scope.tenantFilter)){
                                        $scope.propertyTenantLink.push({key: property, value: tenant});
                                    }
                                    else if ($scope.tenantFilter == "all"){
                                        $scope.propertyTenantLink.push({key: property, value: tenant});
                                    }
                                }                               
                            }
                        });
                    });
                });
            });
        }

        var depopulate = function(){
            $scope.properties = [];
            $scope.tenants = [];
            $scope.propertyTenantLink = [];
            $scope.unoccupiedProperties = [];
        }

        populate();

        $scope.getTenant = function($tenantID){
            $http.get("/Territal-CRM/ajax/getTennant.php?tenantID" + $tenantID).then(function (data, status, headers, config) {              
                var test = data;
            });
        }

        $scope.toggleProperties = function(){            
            if ($scope.propertySwitch === "occupied"){
                $scope.showOccupied = true;
                $scope.showUnoccupied = false;
            }
            else{
                $scope.showOccupied = false;
                $scope.showUnoccupied = true;
            }
        }

        $scope.filterRent = function(){
            depopulate();
            populate();
            /*$http.get("/Territal-CRM/ajax/getProperties.php").then(function (data, status, headers, config) {
                angular.forEach(data.data, function (value, key) {
                    $scope.properties.push(value);
                    if (!value.TenantID){
                        $scope.unoccupiedProperties.push(value);
                    }
                });
                $http.get("/Territal-CRM/ajax/getTennants.php").then(function (data, status, headers, config) {
                    angular.forEach(data.data, function (value, key) {
                        $scope.tenants.push(value);               
                    });
    
                    angular.forEach($scope.properties, function (value, key) {
                        var property = value;
                        angular.forEach($scope.tenants, function (value, key) {
                            var tenant = value;
                            if ($scope.rentFilter !== "nolimit"){
                                if ((property.TenantID === tenant.TenantID) && (property.PropertyRent < parseInt($scope.rentFilter)) && property.PropertyRent > (parseInt($scope.rentFilter)) - 250){
                                    $scope.propertyTenantLink.push({key: property, value: tenant});
                                }
                            }
                            else if ((property.TenantID === tenant.TenantID)){
                                $scope.propertyTenantLink.push({key: property, value: tenant});
                            }
                        });
                    });
                });
            });*/
        }

        $scope.filterTenant = function(){
            depopulate();
            populate();
            /*$http.get("/Territal-CRM/ajax/getProperties.php").then(function (data, status, headers, config) {
                angular.forEach(data.data, function (value, key) {
                    $scope.properties.push(value);
                    if (!value.TenantID){
                        $scope.unoccupiedProperties.push(value);
                    }
                });
                $http.get("/Territal-CRM/ajax/getTennants.php").then(function (data, status, headers, config) {
                    angular.forEach(data.data, function (value, key) {
                        $scope.tenants.push(value);               
                    });
    
                    angular.forEach($scope.properties, function (value, key) {
                        var property = value;
                        angular.forEach($scope.tenants, function (value, key) {
                            var tenant = value;
                            if ($scope.tenantFilter !== "all"){
                                if ((property.TenantID === tenant.TenantID) && property.TenantID == parseInt($scope.tenantFilter)){
                                    $scope.propertyTenantLink.push({key: property, value: tenant});
                                }
                            }
                            else if ((property.TenantID === tenant.TenantID)){
                                $scope.propertyTenantLink.push({key: property, value: tenant});
                            }
                        });
                    });
                });
            });*/
        }
    });