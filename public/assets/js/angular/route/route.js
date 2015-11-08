'use strict';

(function(angular) {
    angular.module('myApp', ['' +
    'ngRoute',
    'controller'
    ])
        .config(function ($routeProvider) {
            $routeProvider
                .when('/', {
                    templateUrl: 'assets/js/angular/views/index.html',
                    controller: 'MainController'
                })
                .when('/post', {
                    templateUrl: 'assets/js/angular/views/post.html',
                    controller: 'PostController'
                })
                .when('/help', {
                    templateUrl: 'assets/js/angular/views/help.html'
                })
                .otherwise({
                    redirectTo: '/'
                })
        })
})(angular);
//console.log("route read.");