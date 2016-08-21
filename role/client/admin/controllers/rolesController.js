angular.module('rolesApp.rolesController', ['baseApp.baseController']);

angular.module('rolesApp.rolesController')
    .controller('BaseController', function ($scope, $controller) {
        $controller('ErrorsController', {$scope: $scope});
    });