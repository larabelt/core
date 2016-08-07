//=include ./app.js

//=include ../../../user/ng/admin/service.js
//=include ../../../user/ng/admin/controllers/usersController.js
//=include ../../../user/ng/admin/controllers/usersCreateController.js
//=include ../../../user/ng/admin/controllers/usersEditController.js
//=include ../../../user/ng/admin/controllers/usersIndexController.js

angular.module('usersApp', ['ngRoute', 'ui.bootstrap', 'baseApp', 'usersApp.usersController', 'usersApp.service'])
    .config(['$locationProvider', '$routeProvider',
        function ($locationProvider, $routeProvider) {
            $locationProvider.hashPrefix('!');
            $routeProvider
                .when('/users/index', {
                    templateUrl: '/ng/core/user/admin/views/index.html',
                    controller: 'usersIndexController'
                })
                .when('/users/create', {
                    templateUrl: '/ng/core/user/admin/views/create.html',
                    controller: 'usersCreateController'
                })
                .when('/users/edit/:user_id', {
                    templateUrl: '/ng/core/user/admin/views/edit.html',
                    controller: 'usersEditController'
                })
                .otherwise('/');
        }]);

angular.module('ohioApp', ['usersApp']);