angular.module('usersApp.service', []);

angular.module('usersApp.service')
    .factory('User', function ($http, $httpParamSerializer, $location) {

        return {

            // get all the users
            index: function () {

                var qs = $httpParamSerializer($location.search());

                return $http.get('/api/v1/users?' + qs);
            },

            // get all the users
            get: function (id) {
                return $http.get('/api/v1/users/' + id)

                    .success(function (data) {
                        console.log(111);
                        console.log(data);
                        return data;
                    });
                ;
            },

            // save a user (pass in user data)
            store: function (data) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/users',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param(data)
                });
            },

            // save a user (pass in user data)
            update: function (id, data) {
                return $http({
                    method: 'PUT',
                    url: '/api/v1/users/' + id,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param(data)
                });
            },

            // destroy a user
            destroy: function (id) {
                return $http.delete('/api/v1/users/' + id);
            }
        }

    });