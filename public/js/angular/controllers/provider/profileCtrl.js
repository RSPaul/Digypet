providerApp.controller('ProfileCtrl', function($scope, $http, $timeout, $locale, $location, $rootScope) {
	$rootScope.activePath = $location.path();
	$scope.user = {password: '', confirm_password: '',pets: {},service_pricing: {}, images: [], profile_picture: '/uploads/profiles/l60Hf.png'};
	$scope.alertClass = 'success';
	$scope.alertMessage = '';
	$scope.profileActive = true;

	$scope.me = function() {
		$http.get('/api/me')
		.then(function(response) {
		  $scope.user = response.data;
	      $scope.user.password =  '';
	      if(!$scope.user.profile_picture || $scope.user.profile_picture == '') { 
	      	$scope.user.profile_picture = ''; 
	      }
	      if(!$scope.user.images || !$scope.user.images.length) { 
	      	$scope.user.images = []; 
	      }
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
		//console.log($scope.user.profile_picture);
		var files = event.target.files;
		angular.forEach(files, function(value){
			var reader = new FileReader();
		    reader.readAsDataURL(value);
		   	reader.onload = function () {
		   	 $scope.loading = false;
		    // $scope.user.profile_picture.push(reader.result);
		    $scope.user.profile_picture = reader.result;
		     $('#userImage').attr('src', reader.result);
		   	};
		});
	}

	$scope.uploadUserImages = function (event) {
		//console.log($scope.user.images);
		var files = event.target.files;
		angular.forEach(files, function(value){
			var reader = new FileReader();
		    reader.readAsDataURL(value);
		   	reader.onload = function () {
		   	 $scope.loading = false;
		     $scope.user.images.push(reader.result);		     
		     //c//onsole.log($scope.user.images);
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

	$scope.updatePassword = function() {
		$scope.loading = true;
		$http.post('/api/passowrd/change', $scope.user)
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