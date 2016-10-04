//=require ../../base/admin/app.js

//=require ./service.js
//=require ./controllers/userRolesController.js
//=require ./controllers/userRolesIndexController.js

angular.module('userRolesApp', ['ngRoute', 'ui.bootstrap', 'baseApp', 'userRolesApp.userRolesController', 'userRolesApp.service'])
    .config(['$locationProvider', '$routeProvider',
        function ($locationProvider, $routeProvider) {
            $locationProvider.hashPrefix('!');
            $routeProvider
                .when('/user-roles/index', {
                    templateUrl: '/client/core/user-role/admin/views/index.html',
                    controller: 'userRolesIndexController'
                })
                .otherwise('/');
        }]);