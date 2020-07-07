searchApp.controller('SearchCtrl', function($scope, $http, $timeout, $locale, $location, $rootScope) {

	$scope.providers = function() {
		$http.get('/api/getProviders')
		.then(function(response) {
		  $scope.listproviders = response.data;
	    },function(error){
	      if(error.data.message == 'Unauthenticated.') { swal("Session Expired", "Your session is expired, please login again to continue.", "error"); $timeout(function() { $('#logout-form').submit(); },3000);} else { swal("Error", error.data.message, "error"); }
	      $scope.loading = false;
		});
	}

});