angular.module('baseApp.baseController')
    .controller('errorsController', function ($scope, $location, User) {

        $scope.errors = {};

        $scope.hasError = function (key) {

            if (key in $scope.errors) {
                return 'has-error';
            }

            return '';
        }

    });