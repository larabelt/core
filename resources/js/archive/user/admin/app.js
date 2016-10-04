//=require ../../base/admin/app.js

//=require ./service.js
//=require ./controllers/usersController.js
//=require ./controllers/usersCreateController.js
//=require ./controllers/usersEditController.js
//=require ./controllers/usersIndexController.js

angular.module('usersApp', ['ngRoute', 'ui.bootstrap', 'baseApp', 'usersApp.usersController', 'usersApp.service'])
    .config(['$locationProvider', '$routeProvider',
        function ($locationProvider, $routeProvider) {
            $locationProvider.hashPrefix('!');
            $routeProvider
                .when('/users/index', {
                    templateUrl: '/client/core/user/admin/views/index.html',
                    controller: 'usersIndexController'
                })
                .when('/users/create', {
                    templateUrl: '/client/core/user/admin/views/create.html',
                    controller: 'usersCreateController'
                })
                .when('/users/edit/:user_id', {
                    templateUrl: '/client/core/user/admin/views/edit.html',
                    controller: 'usersEditController'
                })
                .otherwise('/');
        }]);