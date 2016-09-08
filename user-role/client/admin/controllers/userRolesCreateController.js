angular.module('userRolesApp.userRolesController')
    .controller('userRolesCreateController', function ($scope, $controller, $location, UserRole) {

        $controller('BaseController', {$scope: $scope});

        // object to hold all the data for the new user form
        $scope.userRole = {};

        // function to handle submitting the form
        // STORE A USER ================
        $scope.store = function () {

            $scope.loading = true;

            $scope.userRole.user_id = $scope.user.id;

            // save the user. pass in user data from the form
            // use the function we created in our service
            UserRole.store($scope.userRole)
                .success(function (data) {
                    $location.url('/users/edit/' + $scope.user.id)
                })
                .error(function (data) {
                    $scope.setErrors(data);
                });
        };

    });