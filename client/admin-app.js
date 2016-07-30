//=include ./base/app.js

//=include ./users/service.js
//=include ./users/controllers/usersController.js
//=include ./users/controllers/usersCreateController.js
//=include ./users/controllers/usersEditController.js
//=include ./users/controllers/usersIndexController.js

angular.module('usersApp', ['ngRoute', 'ui.bootstrap', 'baseApp', 'usersApp.usersController', 'usersApp.service'])
    .config(['$locationProvider', '$routeProvider',
        function ($locationProvider, $routeProvider) {
            $locationProvider.hashPrefix('!');
            $routeProvider
                .when('/users/index', {
                    templateUrl: '/ohio/users/views/index.html',
                    controller: 'usersIndexController'
                })
                .when('/users/create', {
                    templateUrl: '/ohio/users/views/create.html',
                    controller: 'usersCreateController'
                })
                .when('/users/edit/:user_id', {
                    templateUrl: '/ohio/users/views/edit.html',
                    controller: 'usersEditController'
                })
                .otherwise('/');
        }]);

angular.module('ohioApp', ['usersApp']);