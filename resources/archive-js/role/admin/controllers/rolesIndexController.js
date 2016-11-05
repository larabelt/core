angular.module('rolesApp.rolesController')
    .controller('rolesIndexController', function ($scope, $http, $location, Role) {

        $scope.criteria = {
            page: null,
            perPage: null,
            orderBy: null,
            sortBy: null
        };

        $scope.sorters = [];

        // object to hold all the data for the new role form
        $scope.role = {};

        $scope.roles = {};

        // loading variable to show the spinning loading icon
        $scope.loading = true;

        $scope.setPage = function (pageNo) {
            angular.extend($scope.criteria, {page: pageNo});
        };

        $scope.pageChanged = function () {
            $location.search('page', $scope.criteria.page);
        };

        // get all the roles first and bind it to the $scope.roles object
        // use the function we created in our service
        // GET ALL ROLES ==============
        $scope.index = function () {
            Role.index()
                .success(function (data) {

                    $scope.roles = data;
                    $scope.loading = false;

                    angular.extend($scope.criteria, {
                        page: data.current_page,
                        perPage: data.per_page,
                        orderBy: data.meta.request.orderBy,
                        sortBy: data.meta.request.sortBy
                    });

                    for (var i = 0; i < $scope.sorters.length; i++) {
                        var sorter = $scope.sorters[i];
                        sorter.update($scope.criteria);
                    }

                });
        };

        // function to handle deleting a role
        // DELETE A ROLE ====================================================
        $scope.destroy = function (id) {

            $scope.loading = true;

            // use the function we created in our service
            Role.destroy(id)
                .success(function (data) {

                    // if successful, we'll need to refresh the role list
                    Role.index()
                        .success(function (getData) {
                            $scope.roles = getData;
                            $scope.loading = false;
                        });

                });
        };

    });
;