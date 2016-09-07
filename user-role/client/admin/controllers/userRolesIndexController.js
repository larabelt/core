angular.module('userRolesApp.userRolesController')
    .controller('userRolesIndexController', function ($scope, $http, $location, User) {

        // object to hold all the data for the new user form
        $scope.user = {};

        // loading variable to show the spinning loading icon
        $scope.loading = true;

        // get all the users first and bind it to the $scope.users object
        // use the function we created in our service
        // GET ALL USERS ==============
        $scope.index = function (user_id) {
            User.index(1)
                .success(function (data) {
                    $scope.users = data;
                    $scope.loading = false;
                });
        };

        // function to handle deleting a user
        // DELETE A USER ====================================================
        $scope.destroy = function (id) {

            $scope.loading = true;

            // use the function we created in our service
            User.destroy(id)
                .success(function (data) {

                    // if successful, we'll need to refresh the user list
                    User.index()
                        .success(function (getData) {
                            $scope.users = getData;
                            $scope.loading = false;
                        });

                });
        };

    });
;