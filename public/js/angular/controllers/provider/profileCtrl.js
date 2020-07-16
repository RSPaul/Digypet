providerApp.controller('ProfileCtrl', function($scope, $http, $timeout, $locale, $location, $rootScope) {
	$rootScope.activePath = $location.path();
	$scope.user = {password: '', confirm_password: '',pets: {},service_pricing: {}, images: [], profile_picture: '/uploads/profiles/l60Hf.png'};
	$scope.alertClass = 'success';
	$scope.alertMessage = '';


	$scope.me = function() {
		$http.get('/api/me')
		.then(function(response) {
		  $scope.user = response.data;
	      $scope.user.password =  '';
	      // if(response.data.profile_picture && response.data.profile_picture !='') {
	      // 	$scope.user.profile_picture = '/uploads/providers/' + response.data.profile_picture;
	      // }
	      if(!$scope.user.pets) { $scope.user.pets = {} }
	      if(!$scope.user.service_pricing) { 
	      	//console.log('Here'); 
	      	$scope.user.service_pricing = {};
	      }else{
	      	//$scope.user.service_pricing = response.data.service_pricing;
	      }
	      if(!$scope.user.profile_picture || !$scope.user.profile_picture.length) { $scope.user.profile_picture = [] }
	    },function(error){
	      if(error.data.message == 'Unauthenticated.') { swal("Session Expired", "Your session is expired, please login again to continue.", "error"); $timeout(function() { $('#logout-form').submit(); },3000);} else { swal("Error", error.data.message, "error"); }
	      $scope.loading = false;
		});
	}

	/* Upload Multiple Images*/

	$scope.uploadFile = function(files) {
	    var fd = new FormData();
	    //Take the first selected file
	    fd.append("file", files);

	    $http.post('/api/providerImages', fd)
		.then(function (response) {
		  	console.log(response);
		},function(error){
	      if(error.data.message == 'Unauthenticated.') { swal("Session Expired", "Your session is expired, please login again to continue.", "error"); $timeout(function() { $('#logout-form').submit(); },3000);} else { swal("Error", error.data.message, "error"); }
	      $scope.loading = false;
		});

	};

	$scope.fileNameChanged = function (event) {
		console.log($scope.user.profile_picture);
		var files = event.target.files;
		angular.forEach(files, function(value){
			var reader = new FileReader();
		    reader.readAsDataURL(value);
		   	reader.onload = function () {
		   	 $scope.loading = false;
		     $scope.user.profile_picture.push(reader.result);
		     console.log($scope.user.profile_picture);
		   	};
		});
	}

	$scope.updateProfile = function() {
		$http.post('/api/profile', $scope.user)
		.then(function (response) {
		  	var response = response.data;
		  	if(response.status) {
		  		$scope.me();
		  		swal('Profile Updated', response.message, "success");
		  	} else {
		  		swal('Error', response.message, "error");
		  	}
		  	$scope.loading = false;
		},function(error){
	      if(error.data.message == 'Unauthenticated.') { swal("Session Expired", "Your session is expired, please login again to continue.", "error"); $timeout(function() { $('#logout-form').submit(); },3000);} else { swal("Error", error.data.message, "error"); }
	      $scope.loading = false;
		});
	}

	$scope.changePassword = function() {
		$scope.loading = true;
		$http.post('/teacher/api/passowrd/change', $scope.user)
		.then(function (response) {
			$scope.loading = false;
		  	var response = response.data;
		  	if(response.status) {
		  		$scope.user.password = '';
		  		$scope.user.confirm_password = '';
		  		swal('Password Updated', response.message, "success");
		  	} else {
		  		swal('Error', response.message, "error");
		  	}
		},function(error){
			$scope.loading = false;
	      	if(error.data.message == 'Unauthenticated.') { swal("Session Expired", "Your session is expired, please login again to continue.", "error"); $timeout(function() { $('#logout-form').submit(); },3000);} else { swal("Error", error.data.message, "error"); }
		});
	}

});