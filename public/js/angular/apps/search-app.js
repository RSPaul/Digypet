var searchApp = angular.module("searchApp", ["ngRoute","angularUtils.directives.dirPagination", "ngSanitize"]);

/*
* Routing
*/
searchApp.config(function($routeProvider, $locationProvider) {
    $locationProvider.html5Mode(true);
    
    $routeProvider
    .when("/search", {
        templateUrl : "templates/search/search.html",
        controller: 'SearchCtrl'
    })
    .when("/provider/view/:Id", {
        templateUrl : "templates/search/view-provider.html",
        controller: 'ViewCtrl'
    })
    .otherwise("/search", {
        templateUrl : "templates/search/search.html"
    });
});

searchApp.filter
  ( 'range'
  , function() {
      var filter = 
        function(arr, lower, upper) {
          for (var i = lower; i <= upper; i++) arr.push(i)
          return arr
        }
      return filter
    }
  )

searchApp.directive("ngUploadChange",function(){
    return{
        scope:{
            ngUploadChange:"&"
        },
        link:function($scope, $element, $attrs){
            $element.on("change",function(event){
                if(event.target && event.target.files && event.target.files[0] && (event.target.files[0].size) > 6842880) {
                    swal("Error", "File size should not be more than 5 MB.", "error");
                } else {
                    $scope.$apply(function(){
                        $scope.ngUploadChange({$event: event})
                    })                    
                }
            })
            $scope.$on("$destroy",function(){
                $element.off();
            });
        }
    }
});

searchApp.filter('fromNow', function() {
  return function(date) {
    return moment(date).fromNow();
  }
});

searchApp.directive('showMore', [function() {
    return {
        restrict: 'AE',
        replace: true,
        scope: {
            text: '=',
            limit:'='
        },

        template: '<div><p ng-show="largeText"> {{ text | subString :0 :end }}.... <a href="javascript:;" ng-click="showMore()" ng-show="isShowMore">Show More</a><a href="javascript:;" ng-click="showLess()" ng-hide="isShowMore">Show Less </a></p><p ng-hide="largeText">{{ text }}</p></div> ',

        link: function(scope, iElement, iAttrs) {

            
            scope.end = scope.limit;
            scope.isShowMore = true;
            scope.largeText = true;

            if (scope.text.length <= scope.limit) {
                scope.largeText = false;
            };

            scope.showMore = function() {

                scope.end = scope.text.length;
                scope.isShowMore = false;
            };

            scope.showLess = function() {

                scope.end = scope.limit;
                scope.isShowMore = true;
            };
        }
    };
}]);


searchApp.filter('subString', function() {
    return function(str, start, end) {
        if (str != undefined) {
            return str.substr(start, end);
        }
    }
})

searchApp.directive('loading', function () {
      return {
        restrict: 'E',
        replace:true,
        template: '<div class="loading"><img src="/img/ajax-loader.gif"  /></div>',
        link: function (scope, element, attr) {
              scope.$watch('loading', function (val) {
                  if (val)
                      $(element).show();
                  else
                      $(element).hide();
              });
        }
      }
});