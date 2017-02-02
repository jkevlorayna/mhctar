app.controller('AppGuestController', function ($rootScope,$scope, $http, $q, $location, $filter, svcGuest,growl,$uibModal,svcCategory) {
	
	$scope.pageNo = 1;
	$scope.pageSize = 10;
	if($scope.searchText == undefined){ $scope.searchText = ''; } 
	

    $scope.load = function () {
		svcGuest.list($scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
    }
    $scope.load();
	
	$scope.pageChanged = function () { $scope.load(); }
	
	
	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppGuestModalController',
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
app.controller('AppGuestModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcGuest,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcGuest.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        });
    }
});	
app.controller('AppGuestFormController', function ($scope, $http, $q, $location, svcGuest,svcCategory,$stateParams,growl,uiGmapGoogleMapApi) {
$scope.Id = $stateParams.Id
  
	$scope.getById = function () {
		svcGuest.getById($scope.Id).then(function (r) {
				$scope.formData =  r
				$scope.formData.news_date = new Date(r.news_date);
        });
    }
	
	
	$scope.formData = $scope.Id == 0 ? { news_date:new Date() } : $scope.getById();
	$scope.pageTitle = $scope.Id == 0 ? 'Add News'  : 'Update News' ;
	
	
	$scope.save = function () {
		svcGuest.save($scope.formData).then(function (r) {
			growl.success("Data Successfully Save");
        });
    }
	

	
	


	
});