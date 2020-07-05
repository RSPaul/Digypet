providerApp.controller('ProfileCtrl', function($scope, $http, $timeout, $locale, $location, $rootScope) {
	$rootScope.activePath = $location.path();
	$scope.user = {password: '', confirm_password: '',pets: [],  profile_picture: '/uploads/profiles/l60Hf.png'};
	$scope.alertClass = 'success';
	$scope.alertMessage = '';


	$scope.me = function() {
		$http.get('/api/me')
		.then(function(response) {
		  $scope.user = response.data;
	      $scope.user.password =  '';
	      if(response.data.profile_picture && response.data.profile_picture !='') {
	      	$scope.user.profile_picture = '/uploads/profiles/' + response.data.profile_picture;
	      }

	    },function(error){
	      if(error.data.message == 'Unauthenticated.') { swal("Session Expired", "Your session is expired, please login again to continue.", "error"); $timeout(function() { $('#logout-form').submit(); },3000);} else { swal("Error", error.data.message, "error"); }
	      $scope.loading = false;
		});
	}

	$scope.updateProfile = function() {
		//console.log($scope.user);
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