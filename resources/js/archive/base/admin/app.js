angular.module('baseApp', []);

//=include ./directives/columnSorter.js

angular.module('baseApp.baseController', []);

angular.module('baseApp.baseController')
    .controller('ErrorsController', function ($scope) {
        $scope.errors = {};
        $scope.hasError = function (key) {
            if (key in $scope.errors) {
                return true;
            }
            return false;
        };
        $scope.getError = function (key) {
            if (key in $scope.errors) {
                return $scope.errors[key];
            }
            return '';
        };
        $scope.setErrors = function (data) {
            angular.forEach(data.message, function (value, key) {
                $scope.errors[key] = value;
            });
        };
    });