angular.module('usersApp.usersController')
    .controller('usersEditController', function ($scope, $routeParams, User) {

        $scope.user_id = $routeParams.user_id;

        // object to hold all the data for the new user form
        $scope.user = {};

        $scope.init = function () {

            $scope.loading = true;

            User.get($scope.user_id)
                .success(function (data) {
                    $scope.user = data.data;
                    $scope.loading = false;
                });
        };

        // function to handle submitting the form
        // UPDATE A USER ================
        $scope.update = function (id) {

            $scope.loading = true;

            // save the user. pass in user data from the form
            // use the function we created in our service
            User.update(id, $scope.user)
                .success(function (data) {
                    $scope.user = data.data;
                    $scope.loading = false;
                })
                .error(function (data) {
                    console.log(data);
                });
        };

    });