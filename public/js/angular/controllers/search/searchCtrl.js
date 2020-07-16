searchApp.controller('SearchCtrl', function($scope, $http, $timeout, $locale, $location, $rootScope) {
	$scope.filterlistproviders = [];
	$scope.providers = function() {
		$http.get('/api/getProviders')
		.then(function(response) {
		  $scope.listproviders = response.data;
		  $scope.filterlistproviders = response.data;
	    },function(error){
	      if(error.data.message == 'Unauthenticated.') { swal("Session Expired", "Your session is expired, please login again to continue.", "error"); $timeout(function() { $('#logout-form').submit(); },3000);} else { swal("Error", error.data.message, "error"); }
	      $scope.loading = false;
		});
	}

	$scope.filterByPetType = function () {
		if($scope.petType && $scope.petType != ''){
		$scope.listproviders = [];
			angular.forEach($scope.filterlistproviders, function(value, key) {
				angular.forEach(value.services, function(value1, key1) {
					if(value1.pet_type == $scope.petType){
						$scope.listproviders.push(value);
					}
				}) 

			 }) 	
		}else{
			$scope.listproviders = $scope.filterlistproviders;
		}
	}

	$scope.filterByServiceType = function(){
			if($scope.serviceType && $scope.serviceType != ''){
			$scope.listproviders = [];
				angular.forEach($scope.filterlistproviders, function(value, key) {
					angular.forEach(value.services, function(value1, key1) {
						if((value1.service_type.indexOf($scope.serviceType) >= 0) ){
							$scope.listproviders.push(value);
						}
					}) 

				 }) 	
			}else{
				$scope.listproviders = $scope.filterlistproviders;
			}
	}

});