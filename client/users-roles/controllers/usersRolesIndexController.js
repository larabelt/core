angular.module('usersApp.usersController')
    .controller('usersIndexController', function ($scope, $http, $location, User) {

        $scope.criteria = {
            page: null,
            perPage: null,
            orderBy: null,
            sortBy: null
        };

        $scope.sorters = [];

        // object to hold all the data for the new user form
        $scope.user = {};

        // loading variable to show the spinning loading icon
        $scope.loading = true;

        $scope.setPage = function (pageNo) {
            console.log('setPage');
            angular.extend($scope.criteria, {page: pageNo});
        };

        $scope.pageChanged = function () {
            console.log('pageChanged');
            $location.search('page', $scope.criteria.page);
        };

        // get all the users first and bind it to the $scope.users object
        // use the function we created in our service
        // GET ALL USERS ==============
        $scope.index = function () {
            User.index()
                .success(function (data) {

                    $scope.users = data;
                    $scope.loading = false;

                    angular.extend($scope.criteria, {
                        page: data.meta.request.page,
                        perPage: data.meta.request.perPage,
                        orderBy: data.meta.request.orderBy,
                        sortBy: data.meta.request.sortBy
                    });

                    for (var i = 0; i < $scope.sorters.length; i++) {
                        var sorter = $scope.sorters[i];
                        sorter.update($scope.criteria);
                    }

                });
        };

        // function to handle deleting a user
        // DELETE A USER ====================================================
        $scope.destroy = function (id) {

            $scope.loading = true;

            // use the function we created in our service
            User.destroy(id)
                .success(function (data) {

                    // if successful, we'll need to refresh the user list
                    User.index()
                        .success(function (getData) {
                            $scope.users = getData;
                            $scope.loading = false;
                        });

                });
        };

    });
;