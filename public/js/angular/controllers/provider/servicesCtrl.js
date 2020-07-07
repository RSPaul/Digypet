providerApp.controller('ServicesCtrl', function($scope, $http, $timeout, $locale, $location, $rootScope) {
	
	$scope.service = {images: []};
	$scope.btnText = "Save Pet Service";

	$scope.loadServices = function() {
		$http.get('/api/provider/services')
		.then(function (response) {
			$scope.services = response.data.services;
		},function(error){
			if(error.data.message == 'Unauthenticated.') { swal("Session Expired", "Your session is expired, please login again to continue.", "error"); $timeout(function() { $('#logout-form').submit(); },3000);} else { swal("Error", error.data.message, "error"); }
		});
	}

	$scope.fileNameChanged = function (event) {
		var files = event.target.files;
		angular.forEach(files, function(value){
			var reader = new FileReader();
		    reader.readAsDataURL(value);
		   	reader.onload = function () {
		   	 $scope.loading = false;
		     $scope.service.images.push(reader.result);
		   	};
		});
	}

	$scope.savePetService = function() {
		$scope.btnText = "Please Wait..";
		$http.post('/api/provider/service/add', $scope.service)
		.then(function (response) {
		  	if(response.data.status) {
		  		$scope.btnText = "Save Pet Service";
		  		swal('Service Added', response.data.message, "success");
		  		$location.path('/provider/services');
		  	} else {
		  		swal('Error', response.message, "error");
		  	}
		},function(error){
			$scope.btnText = "Save Pet Service";
	      	if(error.data.message == 'Unauthenticated.') { swal("Session Expired", "Your session is expired, please login again to continue.", "error"); $timeout(function() { $('#logout-form').submit(); },3000);} else { swal("Error", error.data.message, "error"); }
		});
	}
});