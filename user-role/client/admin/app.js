//=include ../base/app.js

//=include ./service.js
//=include ./controllers/usersController.js
//=include ./controllers/usersCreateController.js
//=include ./controllers/usersEditController.js
//=include ./controllers/usersIndexController.js

angular.module('usersApp', ['ngRoute', 'ui.bootstrap', 'baseApp', 'usersApp.usersController', 'usersApp.service'])
    .config(['$locationProvider', '$routeProvider',
        function ($locationProvider, $routeProvider) {
            $locationProvider.hashPrefix('!');
            $routeProvider
                .when('/index', {
                    templateUrl: '/client/core/user/admin/views/index.html',
                    controller: 'usersIndexController'
                })
                .when('/create', {
                    templateUrl: '/client/core/user/admin/views/create.html',
                    controller: 'usersCreateController'
                })
                .when('/edit/:user_id', {
                    templateUrl: '/client/core/user/admin/views/edit.html',
                    controller: 'usersEditController'
                })
                .otherwise('/');
        }]);