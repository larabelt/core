angular.module('rolesApp.service', []);

angular.module('rolesApp.service')
    .factory('Role', function ($http, $httpParamSerializer, $location) {

        return {

            // get all the roles
            index: function () {

                var qs = $httpParamSerializer($location.search());

                return $http.get('/api/v1/roles?' + qs);
            },

            // get all the roles
            get: function (id) {
                return $http.get('/api/v1/roles/' + id)

                    .success(function (data) {
                        console.log(111);
                        console.log(data);
                        return data;
                    });
                ;
            },

            // save a role (pass in role data)
            store: function (data) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/roles',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param(data)
                });
            },

            // save a role (pass in role data)
            update: function (id, data) {
                return $http({
                    method: 'PUT',
                    url: '/api/v1/roles/' + id,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param(data)
                });
            },

            // destroy a role
            destroy: function (id) {
                return $http.delete('/api/v1/roles/' + id);
            }
        }

    });