
angular.module('myApp', ['ngResource'])
    .controller('MyController',
        ['$scope', '$resource', function($scope, $resource) {
        var Article = $resource(
            '/sp/articles'
        );
        console.log(Article.query());
        //$scope.articles = Article.query()['articles'];
    }]);


