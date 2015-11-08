'use strict';

(function() {
angular.module('controller', ['ngResource'])
    .config(['$logProvider', function($logProvider) {
        $logProvider.debugEnabled(true);
    }])
    .value('ApiUrl', 'http://localhost:8000')
    .service('myService', ['$resource', '$log', function($resource, $log) {
        $log.debug('myService');
        var Article = $resource(
            '/sp/articles'
        );

        var insert = function(insertArticle) {
            Article.save(insertArticle);
        };

        var remove = function(id) {
            Article.delete({id: id});
        }

        return {
            get: function() {
                return Article.query();
            },
            insert: function(insertArticle) {
                return insert(insertArticle);
            },
            remove: function(id) {
                return remove(id);
            }
        };
    }])
    .controller('MainController', ['$scope', '$log', 'myService', 'ApiUrl', '$location', function($scope, $log, myService, ApiUrl, $location){
        $log.debug('MyController');
        $log.debug(ApiUrl);

        $scope.onPost = function() {
            $log.debug('onPost');
            $location.path('/post');
        }

        $scope.articles = myService.get();
    }])
    .controller('PostController', [function() {

    }]);
})();
console.log('articleController');