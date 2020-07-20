providerApp.controller('PaymentsCtrl', function($scope, $http, $timeout, $locale, $location, $rootScope) {
	$rootScope.activePath = $location.path();
	$scope.alertClass = 'success';
	$scope.alertMessage = '';
	$scope.profileActive = true;
	$scope.accUpdateBtn = 'Add Bank';

  $scope.getBankDetails = function () {
    $http.get('/api/provider/get-bank-account')
    .then(function (response) {
      var data = response.data;
      $scope.account = (data.message && data.message.bank_name !== '') ? data.extra_data : {};
      console.log('data ',  $scope.account);

    }, function(error) {
      console.log('error getting bank details ', error);
    });
  }


  $scope.updateBankAccount = function () {
    $scope.accUpdateBtn = 'Please wait..';
    $http.post('/update-account', $scope.account)
    .then(function (response) {
      var data = response.data;
      if(response.status) {
        $scope.getBankDetails();
        swal("Success", "Bank details has been updated.", "success");
        $scope.accUpdateBtn = 'Submit';
      } else {
        swal("Error", data.message, "error");
        $scope.accUpdateBtn = 'Submit';
      }      
    }, function (error) {
      var errMsg = error.data.message;
      for(var key in error.data.errors) {
        if(error.data.errors[key] && error.data.errors[key].length) {
          for (var i =0; i < error.data.errors[key].length; i++) {
            errMsg = errMsg + error.data.errors[key][i];
          }
        }
      }
      swal("Error", errMsg, "error");
      $scope.accUpdateBtn = 'Submit';
    });
  }


	$scope.fileNameChanged = function (event, type) {
	    //upload file first
	    getBase64(event.target.files[0], type);
	    $timeout(function (){
	    $http.post('/upload-image',{image: $('#'+type).val()})
	    .then(function (response) {
	        var response = response.data;
	        if(response.status) {
	          if(type == 'front') {
	            $scope.account.front = response.path;
	          } else {
	            $scope.account.back = response.path;
	          }
	        } else {
	          swal('Error', response.message, "error");
	        }
	    },function(error){
	        swal("Error", error.data.message, "error");
	    });
	    },1000);
    }

});

function getBase64(file, type) {
   var reader = new FileReader();
   reader.readAsDataURL(file);
   reader.onload = function () {
     $('#'+type).val(reader.result);
   };
   reader.onerror = function (error) {
     console.log('Error: ', error);
     return error;
   };
}