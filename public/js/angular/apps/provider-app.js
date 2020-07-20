var providerApp = angular.module("providerApp", ["ngRoute","angularUtils.directives.dirPagination", "ngSanitize"]);

/*
* Routing
*/
providerApp.config(function($routeProvider, $locationProvider) {
    $locationProvider.html5Mode(true);
    
    $routeProvider
    .when("/provider", {
        templateUrl : "templates/provider/profile.html",
        controller: 'ProfileCtrl'
    })
    .when("/provider/bookings", {
        templateUrl : "templates/provider/bookings.html",
        controller: 'ProfileCtrl'
    })
    .when("/provider/services", {
        templateUrl : "templates/provider/services.html",
        controller: 'ServicesCtrl'
    })
    .when("/provider/service/add", {
        templateUrl : "templates/provider/add-service.html",
        controller: 'ServicesCtrl'
    })
    .when("/provider/service/view/:id", {
        templateUrl : "templates/provider/view-service.html",
        controller: 'ServicesCtrl'
    })
    .when("/provider/service/edit/:id", {
        templateUrl : "templates/provider/add-service.html",
        controller: 'ServicesCtrl'
    })
    .when("/provider/payments", {
        templateUrl : "templates/provider/payments.html",
        controller: 'PaymentsCtrl'
    })
    .when("/provider/messages", {
        templateUrl : "templates/provider/messages.html",
        controller: 'ProfileCtrl'
    })
    .when("/provider/profile", {
        templateUrl : "templates/provider/profile.html",
        controller: 'ProfileCtrl'
    })
    .otherwise("/provider", {
        templateUrl : "templates/provider/dashboard.html"
    });
});

providerApp.filter
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

providerApp.directive("ngUploadChange",function(){
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

providerApp.filter('fromNow', function() {
  return function(date) {
    return moment(date).fromNow();
  }
});

providerApp.directive('showMore', [function() {
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


providerApp.filter('subString', function() {
    return function(str, start, end) {
        if (str != undefined) {
            return str.substr(start, end);
        }
    }
})

providerApp.directive('loading', function () {
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