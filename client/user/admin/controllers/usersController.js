angular.module('usersApp.usersController', ['baseApp.baseController']);

angular.module('usersApp.usersController')
    .controller('BaseController', function ($scope, $controller) {
        $controller('ErrorsController', {$scope: $scope});
    });