
app.controller('AppCategoryController', function ($rootScope,$scope, $http, $q, $location, svcCategory,growl,$uibModal) {
	$scope.pageNo = 1;
	$scope.pageSize = 10;
	if($scope.searchText == undefined){ $scope.searchText = ''; } 
		
    $scope.load = function () {
		svcCategory.List($scope.searchText,$scope.pageNo,$scope.pageSize,'').then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
    }
    $scope.load();
	
	$scope.pageChanged = function () { $scope.load();}
	

	$scope.formData = {  }
	$scope.save = function () {
		svcCategory.Save($scope.formData).then(function (r) {
			$scope.load();
			growl.success("Data Successfully Save");
			$scope.formData = {  }
			$rootScope.loadCategory();
        });
    }
	
	$scope.getById = function (id) {
		svcCategory.Get(id).then(function (r) {
				$scope.formData =  r
        });
    }
	
	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppCategoryModalController',
			size: size,
			resolve: {
				dataId: function () {
					return id;
				}
			}
			});
			modal.result.then(function () { }, function () { 
				$scope.load();
				$rootScope.loadCategory();
			});
	};
	
	
});
app.controller('AppCategoryModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcCategory,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){ $uibModalInstance.dismiss(); }
	
	$scope.delete = function () {
		svcCategory.Delete($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        });
    }
});	
