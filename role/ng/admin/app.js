//=include ../base/app.js

//var roleApp = angular.module('rolesApp', []);

//=include ./service.js
//=include ./controllers/rolesController.js
//=include ./controllers/rolesCreateController.js
//=include ./controllers/rolesEditController.js
//=include ./controllers/rolesIndexController.js

angular.module('rolesApp', ['ngRoute', 'ui.bootstrap', 'baseApp', 'rolesApp.rolesController', 'rolesApp.service'])
    .config(['$locationProvider', '$routeProvider',
        function ($locationProvider, $routeProvider) {
            $locationProvider.hashPrefix('!');
            $routeProvider
                .when('/index', {
                    templateUrl: '/ohio/admin/roles/views/index.html',
                    controller: 'rolesIndexController'
                })
                .when('/create', {
                    templateUrl: '/ohio/admin/roles/views/create.html',
                    controller: 'rolesCreateController'
                })
                .when('/edit/:role_id', {
                    templateUrl: '/ohio/admin/roles/views/edit.html',
                    controller: 'rolesEditController'
                })
                .otherwise('/');
        }]);