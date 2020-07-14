searchApp.controller('SearchCtrl', function($scope, $http, $timeout, $locale, $location, $rootScope) {

	$scope.providers = function() {
		// $('.single-slider').jRange({
  //           from: -2.0,
  //           to: 2.0,
  //           step: 0.5,
  //           scale: [-2.0,-1.0,0.0,1.0,2.0],
  //           format: '%s ML',
  //           width: 220,
  //           showLabels: true,
  //           snap: true
  //        });
         
  //        $('.range-slider').jRange({
  //        from: 0,
  //        to: 100,
  //        //  step: 1,
  //        // scale: [0,25,50,75,100],
  //        format: '$%s',
  //        width: 290,
  //        showLabels: true,
  //        isRange : false,
  //        showScale:false
  //        });
         
  //       $('#datepicker').datepicker({
  //            weekStart: 1,
  //            daysOfWeekHighlighted: "6,0",
  //            autoclose: true,
  //            todayHighlight: true,
  //        });
  //       $('#datepicker').datepicker("setDate", new Date());    
		$http.get('/api/getProviders')
		.then(function(response) {
		  $scope.listproviders = response.data;
	    },function(error){
	      if(error.data.message == 'Unauthenticated.') { swal("Session Expired", "Your session is expired, please login again to continue.", "error"); $timeout(function() { $('#logout-form').submit(); },3000);} else { swal("Error", error.data.message, "error"); }
	      $scope.loading = false;
		});
	}

	$scope.filterByPetType = function () {
		if($scope.pd.pettype && $scope.pd.pettype != ''){
			$http.post('/api/filterProviders', $scope.pd)
			.then(function(response) {
			  $scope.listproviders = response.data;
		    },function(error){
		      if(error.data.message == 'Unauthenticated.') { swal("Session Expired", "Your session is expired, please login again to continue.", "error"); $timeout(function() { $('#logout-form').submit(); },3000);} else { swal("Error", error.data.message, "error"); }
		      $scope.loading = false;
			});
		}
	}

	$scope.filterByServiceType = function(){
		if($scope.pd.servicetype && $scope.pd.servicetype != ''){
			$http.post('/api/filterProviders', $scope.pd)
			.then(function(response) {
			  $scope.listproviders = response.data;
		    },function(error){
		      if(error.data.message == 'Unauthenticated.') { swal("Session Expired", "Your session is expired, please login again to continue.", "error"); $timeout(function() { $('#logout-form').submit(); },3000);} else { swal("Error", error.data.message, "error"); }
		      $scope.loading = false;
			});
		}
	}

});