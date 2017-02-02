
app.controller('AppCategoryDefaultTabsController', function ($stateParams,$rootScope,$scope, $http, $q, $location, svcCategory,growl,$uibModal,svcCategoryDefaultTabs) {
	$scope.pageNo = 1;
	$scope.pageSize = 10;
	if($scope.searchText == undefined){ $scope.searchText = ''; } 
	$scope.CategoryId = $stateParams.Id;	

	
    $scope.loadCategory = function () {
		svcCategory.List($scope.searchText,$scope.pageNo,$scope.pageSize,'').then(function (r) {
            $scope.CategoryList = r.Results;
        })
    }
    $scope.loadCategory();

	$scope.load = function(){
		svcCategoryDefaultTabs.List('',0,0,$scope.CategoryId).then(function(r){
			$scope.list = r.Results;
		})
	}
	$scope.load();
	

	$scope.formData = {  }
	$scope.save = function () {
		$scope.formData.CategoryId = $scope.CategoryId;
		svcCategoryDefaultTabs.Save($scope.formData).then(function (r) {
			$scope.load();
			growl.success("Data Successfully Save");
			$scope.formData = {  }
        });
    }
	
	$scope.getById = function (id) {
		svcCategoryDefaultTabs.Get(id).then(function (r) {
				$scope.formData =  r
        });
    }
	
	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppCategoryDefaultTabsModalController',
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
app.controller('AppCategoryDefaultTabsModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcCategory,growl,$uibModal,dataId,$uibModalInstance,svcCategoryDefaultTabs) {
	$scope.id = dataId;
	$scope.close = function(){ $uibModalInstance.dismiss(); }
	
	$scope.delete = function () {
		svcCategoryDefaultTabs.Delete($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        });
    }
});	
