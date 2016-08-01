
angular.module('usersApp.usersController')
    .controller('usersCreateController', function ($scope, $controller, $location, User) {

        $controller('BaseController', {$scope: $scope});

        // object to hold all the data for the new user form
        $scope.user = {};

        // function to handle submitting the form
        // STORE A USER ================
        $scope.store = function () {

            $scope.loading = true;

            // save the user. pass in user data from the form
            // use the function we created in our service
            User.store($scope.user)
                .success(function (data) {

                    console.log(111);
                    console.log(data);
                    console.log(data.id);

                    $location.url('/users/edit/' + data.id)
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