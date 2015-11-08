//angular.module('myApp', ['ngResource', '$log'])
//    .service('myService', function($resource, $log){
//        $log.debug('myService');
//        var uri = '/sp/articles';
//
//        var resources = $resource(
//            uri
//        );
//
//        return {
//            setUri: function(uri) {
//                this.uri = uri
//            },
//            list: function() {
//                return resources.query();
//            }
//        };
//    });
//
// console.log("service read.");