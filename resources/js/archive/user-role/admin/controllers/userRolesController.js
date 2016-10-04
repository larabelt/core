angular.module('userRolesApp.userRolesController', ['baseApp.baseController']);

angular.module('userRolesApp.userRolesController')
    .controller('BaseController', function ($scope, $controller) {
        $controller('ErrorsController', {$scope: $scope});
    });