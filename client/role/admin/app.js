//=require ../../../base/client/admin/app.js

//=require ./service.js
//=require ./controllers/rolesController.js
//=require ./controllers/rolesCreateController.js
//=require ./controllers/rolesEditController.js
//=require ./controllers/rolesIndexController.js

angular.module('rolesApp', ['ngRoute', 'ui.bootstrap', 'baseApp', 'rolesApp.rolesController', 'rolesApp.service'])
    .config(['$locationProvider', '$routeProvider',
        function ($locationProvider, $routeProvider) {
            $locationProvider.hashPrefix('!');
            $routeProvider
                .when('/roles/index', {
                    templateUrl: '/client/core/role/admin/views/index.html',
                    controller: 'rolesIndexController'
                })
                .when('/roles/create', {
                    templateUrl: '/client/core/role/admin/views/create.html',
                    controller: 'rolesCreateController'
                })
                .when('/roles/edit/:role_id', {
                    templateUrl: '/client/core/role/admin/views/edit.html',
                    controller: 'rolesEditController'
                })
                .otherwise('/');
        }]);