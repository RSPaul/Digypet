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
						$scope.listproviders = $scope.listproviders.filter(unique);
					}
				}) 

			 }) 	
		}else{
			$scope.listproviders = $scope.filterlistproviders;
		}
	}

	$scope.filterByServiceType = function(){
			if($scope.serviceType && $scope.serviceType != ''){
			$scope.serviceType = $scope.serviceType.toLowerCase();
			$scope.listproviders = [];
				angular.forEach($scope.filterlistproviders, function(value, key) {
					angular.forEach(value.services, function(value1, key1) {
						if((value1.service_type.toLowerCase().indexOf($scope.serviceType) >= 0) ){
							$scope.listproviders.push(value);
							$scope.listproviders = $scope.listproviders.filter(unique);
						}
					}) 

				 }) 	
			}else{
				$scope.listproviders = $scope.filterlistproviders;
			}
	}

	$scope.filterByPriceUnit = function(){
		var arr = $scope.pricePerUnit.split(",");
		if(arr[0] && arr[0] != ''){
			$scope.listproviders = [];
				angular.forEach($scope.filterlistproviders, function(value, key) {
					angular.forEach(value.services, function(value1, key1) {
						if((value1.price >= arr[0] && value1.price <= arr[1]) ){
							$scope.listproviders.push(value);
							$scope.listproviders = $scope.listproviders.filter(unique);
						}
					}) 

				 }) 	
		}else{
				$scope.listproviders = $scope.filterlistproviders;
		}
	}

	$scope.filterByTraining = function (){
		if($scope.Training && $scope.Training != ''){
		$scope.Training = $scope.Training.toLowerCase();
			$scope.listproviders = [];
				angular.forEach($scope.filterlistproviders, function(value, key) {
					angular.forEach(value.services, function(value1, key1) {
						if((value1.description.toLowerCase().indexOf($scope.Training) >= 0) ){
							$scope.listproviders.push(value);
							$scope.listproviders = $scope.listproviders.filter(unique);
						}
					}) 

				 }) 	
			}else{
				$scope.listproviders = $scope.filterlistproviders;
		}
	}

	const unique = (value, index, self) => {
	  return self.indexOf(value) === index
	}

	$scope.filterByServiceDate = function(){
		let formatted_date = '';
		if($scope.serviceDate && $scope.serviceDate != ''){
		$scope.listproviders = [];
			angular.forEach($scope.filterlistproviders, function(value, key) {
				angular.forEach(value.services, function(value1, key1) {
					let current_datetime = new Date(value1.created_at)
					if(current_datetime.getMonth()+ 1 < 10){

						formatted_date = current_datetime.getDate() + "/0" + (current_datetime.getMonth() + 1) + "/" + current_datetime.getFullYear();
					}else{
						formatted_date = current_datetime.getDate() + "/" + (current_datetime.getMonth() + 1) + "/" + current_datetime.getFullYear();
					}
					if(formatted_date == $scope.serviceDate){
						$scope.listproviders.push(value);
						$scope.listproviders = $scope.listproviders.filter(unique);
					}
				}) 

			 }) 	
		}else{
			$scope.listproviders = $scope.filterlistproviders;
		}
	}

});