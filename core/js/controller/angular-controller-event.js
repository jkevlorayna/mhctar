app.controller('AppEventController', function ($rootScope,$scope, $http, $q, $location, $filter, svcEvent,growl,$uibModal,svcCategory) {
	
	$scope.pageNo = 1;
	$scope.pageSize = 10;
	if($scope.searchText == undefined){ $scope.searchText = ''; } 
	

    $scope.load = function () {
		svcEvent.list($scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
    }
    $scope.load();
	
	$scope.pageChanged = function () { $scope.load(); }
	
	
	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppEventModalController',
			size: size,
			resolve: {
				dataId: function () {
					return id;
				}
			}
			});
			modal.result.then(function () { }, function () { 
				$scope.load();
			});
  };
	
	
});
app.controller('AppEventModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcEvent,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcEvent.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        });
    }
});	
app.controller('AppEventFormController', function ($scope, $http, $q, $location, svcEvent,svcCategory,$stateParams,growl,uiGmapGoogleMapApi) {
$scope.Id = $stateParams.Id
  
	$scope.getById = function () {
		svcEvent.getById($scope.Id).then(function (r) {
				$scope.formData =  r
				$scope.formData.event_date = new Date(r.event_date);
        });
    }
	
	
	$scope.formData = $scope.Id == 0 ? { event_date:new Date() } : $scope.getById();
	$scope.pageTitle = $scope.Id == 0 ? 'Add Event'  : 'Update Event' ;
	
	$scope.save = function () {
		svcEvent.save($scope.formData).then(function (r) {
			growl.success("Data Successfully Save");
        });
    }
	






	
});

app.controller('AppEventMapController', function ($scope, $http, $q, $location, svcPlace,svcCategory,$stateParams,growl,uiGmapGoogleMapApi,FileUploader,$timeout,$uibModal) {
$scope.Id = $stateParams.Id

	$scope.getById = function () {
		svcPlace.getById($scope.Id).then(function (r) {
				$scope.formData =  r
				
						$scope.map = {center: {latitude: $scope.formData.latitude, longitude: $scope.formData.longitude }, zoom: 18  };
						$scope.marker = {
								id: 0,
								coords: $scope.map.center
						};
						$scope.options = {scrollwheel: false};
						$scope.loadMap();
					

        });
    }
	
	$scope.loadMap = function(maps){
		uiGmapGoogleMapApi.then(function(maps) {

			console.log('Google Maps loaded');

		});		
	}
	
	$scope.getById();
	
	
	$scope.refreshMap = function(){
		$scope.loadMap();
		$scope.refresh = true;
		console.log("refresh");
	}


});