angular.module('TerritalCRM', [])
    .controller('dashboardController', function ($scope, $http) {
        $scope.properties = [];
        $scope.tenants = [];
        $scope.propertyTenantLink = [];
        $scope.filter = [];
        $scope.test = "Angular test";
        
        $http.get("/Territal-CRM/ajax/getProperties.php").then(function (data, status, headers, config) {
            angular.forEach(data.data, function (value, key) {
                $scope.properties.push(value);
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
                            $scope.propertyTenantLink.push({key: property, value: tenant});
                        }
                    });
                });
            });
        });

        $scope.getTenant = function($tenantID){
            $http.get("/Territal-CRM/ajax/getTennant.php?tenantID" + $tenantID).then(function (data, status, headers, config) {              
                var test = data;
            });
        }
    });