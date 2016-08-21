//=include ./app.js

//=include ../../../user/client/admin/service.js
//=include ../../../user/client/admin/controllers/usersController.js
//=include ../../../user/client/admin/controllers/usersCreateController.js
//=include ../../../user/client/admin/controllers/usersEditController.js
//=include ../../../user/client/admin/controllers/usersIndexController.js

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

angular.module('ohioApp', ['usersApp']);