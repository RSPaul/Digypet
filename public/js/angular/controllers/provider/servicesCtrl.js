providerApp.controller('ServicesCtrl', function($scope, $http, $timeout, $locale,$routeParams, $location, $rootScope) {
	
	$scope.service = {pet_icon: "dog", pet_type: "", images: []};
	$scope.serviceData = {images: []};
	$scope.btnText = "Save Pet Service";
	$scope.serviceActive = true;

	$scope.loadServices = function() {
		$http.get('/api/provider/services')
		.then(function (response) {
			$scope.services = response.data.services;
		},function(error){
			if(error.data.message == 'Unauthenticated.') { swal("Session Expired", "Your session is expired, please login again to continue.", "error"); $timeout(function() { $('#logout-form').submit(); },3000);} else { swal("Error", error.data.message, "error"); }
		});
	}

	$scope.getServices = function(){

		if($routeParams.id) { 
			$http.get('/api/provider/service/'+ $routeParams.id)
			.then(function (response) {
				$scope.service = response.data.services;
				if(!$scope.service.images || !$scope.service.images.length) { 
					$scope.service.images = [] 
				}
			},function(error){
				if(error.data.message == 'Unauthenticated.') { swal("Session Expired", "Your session is expired, please login again to continue.", "error"); $timeout(function() { $('#logout-form').submit(); },3000);} else { swal("Error", error.data.message, "error"); }
			});
		}
	}

	if($routeParams.id && $routeParams.id != '') {
		$scope.getServices();
	}

	$scope.fileNameChanged = function (event) {
		var files = event.target.files;
		angular.forEach(files, function(value){
			var reader = new FileReader();
		    reader.readAsDataURL(value);
		   	reader.onload = function () {
		   	 $scope.loading = false;
		     $scope.service.images.push(reader.result);
		     $('.user-images').append("<img src='"+ reader.result +"'>")
		   	};
		});
	}
	$scope.fileNameChangedEdit = function (event) {
		var files = event.target.files;
		angular.forEach(files, function(value){
			var reader = new FileReader();
		    reader.readAsDataURL(value);
		   	reader.onload = function () {
		   	 $scope.loading = false;
		     $scope.serviceData.images.push(reader.result);
		   	};
		});
	}

	$scope.savePetService = function() {
		if($routeParams.id && $routeParams.id != '') {
			$scope.updatePetService();
		} else {

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
	}

	$scope.updatePetService = function() {
		$scope.btnText = "Please Wait..";
		$http.post('/api/provider/service/update', $scope.service)
		.then(function (response) {
		  	if(response.data.status) {
		  		$scope.btnText = "Update Pet Service";
		  		swal('Service Updated', response.data.message, "success");
		  		$location.path('/provider/services');
		  	} else {
		  		swal('Error', response.message, "error");
		  	}
		},function(error){
			$scope.btnText = "Update Pet Service";
	      	if(error.data.message == 'Unauthenticated.') { swal("Session Expired", "Your session is expired, please login again to continue.", "error"); $timeout(function() { $('#logout-form').submit(); },3000);} else { swal("Error", error.data.message, "error"); }
		});
	}

	$scope.deletePetService = function(id){
		swal({
          title: 'Delete Pet Service?',
          text: "You sure you want to delete this service",
          icon: "warning",
          buttons: true,
          dangerMode: true,
          html: true
      })
      .then((confirm) => {
        if(confirm) {
        $scope.loading = true;
          $http.delete('/api/provider/service/delete/' + id)
          .then(function (response) {
          	$scope.loading = false;
          	if(response.data.status) {    
	            swal('Deleted', response.data.message, "success");
          		//if(redirect) {
          			$scope.loadServices(); 
          		//} else {
	            	//$scope.loadServices();          			
          		//}
          	} else {
          		swal('Error', response.data.message, "error");
          	}
          }, function (error) {
          	$scope.loading = false;
            if(error.data.message == 'Unauthenticated.') { swal("Session Expired", "Your session is expired, please login again to continue.", "error"); $timeout(function() { $('#logout-form').submit(); },3000);} else { swal("Error", error.data.message, "error"); }
          });
        }
      });
	}

	$scope.changePetIcon = function(type) {
		if(type == 'Dogs') { $scope.service.pet_icon = "dog"; }
		else if(type == 'Cats') { $scope.service.pet_icon = "cat"; }
		else if(type == 'Birds') { $scope.service.pet_icon = "bird"; }
		else if(type == 'Hamsters') { $scope.service.pet_icon = "hamsters"; }
		else if(type == 'Turtles') { $scope.service.pet_icon = "turtles"; }
		else if(type == 'Guinea Pig') { $scope.service.pet_icon = "pig"; }
	}
});