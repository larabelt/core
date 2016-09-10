angular.module('rolesApp.rolesController')
    .controller('rolesEditController', function ($scope, $routeParams, Role) {

        $scope.role_id = $routeParams.role_id;

        // object to hold all the data for the new role form
        $scope.role = {};

        $scope.init = function () {

            $scope.loading = true;

            Role.get($scope.role_id)
                .success(function (data) {
                    $scope.role = data;
                    $scope.loading = false;
                });
        };

        // function to handle submitting the form
        // UPDATE A ROLE ================
        $scope.update = function (id) {

            $scope.loading = true;

            // save the role. pass in role data from the form
            // use the function we created in our service
            Role.update(id, $scope.role)
                .success(function (data) {
                    $scope.role = data;
                    $scope.loading = false;
                })
                .error(function (data) {

                });
        };

    });