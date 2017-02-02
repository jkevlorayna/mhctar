
app.controller('AppPagesController', function ($scope, $http, $q, $location, $filter, svcPages,$uibModal) {
		$scope.pageNo = 1;
		$scope.pageSize = 10;
		if($scope.searchText == undefined){ $scope.searchText = ''; } 
    $scope.load = function () {
		svcPages.list($scope.searchText,$scope.pageNo,$scope.pageSize,'').then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
			console.log($scope.count);
        })
    }
    $scope.load();

	$scope.statusList = [{status:'Active'},{status:'InActive'}];
	
	$scope.pageChanged = function () { $scope.load(); }
	

	



	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppPagesModalController',
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
app.controller('AppPagesFormController', function ($rootScope,$scope, $http, $q, $location, $filter, svcPages,$uibModal,$stateParams,growl) {
$scope.Id = $stateParams.Id;
$scope.PageTitle = $scope.Id == 0 ? "Add New Page" : "Update Page";
	$scope.getById = function () {
		svcPages.getById($scope.Id).then(function (r) {
				$scope.formData =  r
					console.log($scope.formData);
        });
    }

	$scope.formData = $scope.Id == 0 ? {} : $scope.getById();
	
	$scope.save = function () {
		svcPages.save($scope.formData).then(function (r) {
			growl.success("Data Successfully Saved");
        });
    }


	
	
});	
app.controller('AppPagesModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcPages,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcPages.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        }, function (error) {

        });
    }
});	
