angular.module('baseApp')
    .directive('ohioColumnSorter', function () {
        return {
            restrict: 'E',
            link: function (scope, element, attrs) {

                scope.sortBy = 'asc';
                scope.sortByClass = 'arrows-v';
                scope.criteria = scope.$parent.criteria;

                scope.attrs = attrs;
                scope.element = element;

                scope.update = function (criteria) {
                    scope.sortBy = 'asc';
                    scope.sortByClass = 'arrows-v';
                    if (scope.attrs.orderBy == criteria.orderBy) {
                        scope.element.addClass('active');
                        if (criteria.sortBy == 'asc') {
                            scope.sortBy = 'desc';
                            scope.sortByClass = 'sort-amount-asc';
                        } else {
                            scope.sortBy = 'asc';
                            scope.sortByClass = 'sort-amount-desc';
                        }
                    }
                }

                scope.$parent.sorters.push(scope);

            },
            replace: true,
            transclude: true,
            scope: {
                uri: '@',
                criteria: '@',
                orderBy: '@',
                sortBy: '@',
                sortByClass: '@'
            },
            templateUrl: "/client/core/base/admin/views/column-sorter.html"
        };
    });