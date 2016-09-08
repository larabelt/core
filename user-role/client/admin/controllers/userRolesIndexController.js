angular.module('userRolesApp.userRolesController')
    .controller('userRolesIndexController', function ($scope, $http, $location, UserRole) {

        // object to hold all the data for the new user form
        $scope.userRoles = {};

        // loading variable to show the spinning loading icon
        $scope.loading = true;

        $scope.init = function () {

            $scope.loading = true;

            UserRole.index($scope.user_id)
                .success(function (data) {
                    $scope.userRoles = data;
                    $scope.loading = false;
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