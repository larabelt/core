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
                    templateUrl: '/ng/users/views/index.html',
                    controller: 'usersIndexController'
                })
                .when('/create', {
                    templateUrl: '/ng/users/views/create.html',
                    controller: 'usersCreateController'
                })
                .when('/edit/:user_id', {
                    templateUrl: '/ng/users/views/edit.html',
                    controller: 'usersEditController'
                })
                .otherwise('/');
        }]);