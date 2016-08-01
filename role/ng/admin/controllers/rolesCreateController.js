
angular.module('rolesApp.rolesController')
    .controller('rolesCreateController', function ($scope, $controller, $location, Role) {

        $controller('BaseController', {$scope: $scope});

        // object to hold all the data for the new role form
        $scope.role = {};

        // function to handle submitting the form
        // STORE A ROLE ================
        $scope.store = function () {

            $scope.loading = true;

            // save the role. pass in role data from the form
            // use the function we created in our service
            Role.store($scope.role)
                .success(function (data) {
                    $location.url('/edit/' + data.id)
                })
                .error(function (data) {
                    $scope.setErrors(data);
                    // angular.forEach(data.message, function (value, key) {
                    //     $scope.errors[key] = value;
                    // });
                    // console.log($scope.errors);
                    // angular.forEach(data.message, function (value, key) {
                    //     $scope.errors[key] = value;
                    //     console.log(key + ': ' + value);
                    //     angular.forEach(value, function (value, key) {
                    //         console.log(key + ': ' + value);
                    //     });
                    // });
                    // console.log($scope.errors);
                });
        };

    });