angular.module('userRolesApp.userRolesController')
    .controller('userRolesIndexController', function ($scope, $http, $location, UserRole, Role) {

        // object to hold all the data for the new role form
        $scope.roles = {};

        // object to hold all the data for the new user form
        $scope.userRole = {};

        $scope.userRoles = {};

        // loading variable to show the spinning loading icon
        $scope.loading = true;

        $scope.init = function () {

            $scope.loading = true;

            Role.index()
                .success(function (data) {
                    $scope.roles = data;
                });

            UserRole.index($scope.user_id)
                .success(function (data) {
                    $scope.userRoles = data;
                    $scope.loading = false;
                });
        };

        // function to handle submitting the form
        // STORE A USER ================
        $scope.store = function () {

            $scope.loading = true;

            $scope.userRole.user_id = $scope.user.id;

            // save the user. pass in user data from the form
            // use the function we created in our service
            UserRole.store($scope.userRole)
                .success(function (data) {
                    UserRole.index($scope.user_id)
                        .success(function (data) {
                            $scope.userRoles = data;
                            $scope.loading = false;
                        });
                })
                .error(function (data) {
                    $scope.setErrors(data);
                });
        };

        // function to handle deleting a user
        // DELETE A USER ====================================================
        $scope.destroy = function (id) {

            $scope.loading = true;

            // use the function we created in our service
            UserRole.destroy(id)
                .success(function (data) {

                    UserRole.index($scope.user_id)
                        .success(function (data) {
                            $scope.userRoles = data;
                            $scope.loading = false;
                        });

                });
        };

    });
;