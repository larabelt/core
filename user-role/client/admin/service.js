angular.module('userRolesApp.service', []);

angular.module('userRolesApp.service')
    .factory('UserRole', function ($http, $httpParamSerializer, $location) {

        return {

            // get all the users
            index: function (user_id) {

                var qs = $httpParamSerializer($location.search());

                return $http.get('/api/v1/user-roles?user_id=' + user_id + qs);
            },

            // get all the users
            get: function (id) {
                return $http.get('/api/v1/user-roles/' + id)
                    .success(function (data) {
                        return data;
                    });
                ;
            },

            // save a user (pass in user data)
            store: function (data) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/user-roles',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param(data)
                });
            },

            // save a user (pass in user data)
            update: function (id, data) {
                return $http({
                    method: 'PUT',
                    url: '/api/v1/user-roles/' + id,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param(data)
                });
            },

            // destroy a user
            destroy: function (id) {
                return $http.delete('/api/v1/user-roles/' + id);
            }
        }

    });