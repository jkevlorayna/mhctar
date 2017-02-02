
app.controller('AppCategoryDetailsController', function ($scope, $http, $q, $location, svcCategory,growl,$uibModal,$stateParams,svcCategoryDetails) {
	$scope.pageNo = 1;
	$scope.pageSize = 10;
	if($scope.searchText == undefined){ $scope.searchText = ''; } 
	$scope.Id = $stateParams.CategoryId;	
	
	$scope.getById = function () {
		svcCategory.Get($scope.Id).then(function (r) {
				$scope.Category =  r;
        });
    }
	$scope.getById();
	
	
    $scope.load = function () {
		svcCategoryDetails.List($scope.searchText,$scope.pageNo,$scope.pageSize,$scope.Id).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
    }
    $scope.load();
	
	$scope.pageChanged = function () { $scope.load();}
	


	$scope.save = function () {
		svcCategory.Save($scope.formData).then(function (r) {
			$scope.load();
			growl.success("Data Successfully Save");
			$scope.formData = {  }
        });
    }
	

	
	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppCategoryDetailsModalController',
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
app.controller('AppCategoryDetailsModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcCategoryDetails,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){ $uibModalInstance.dismiss(); }
	
	$scope.delete = function () {
		svcCategoryDetails.Delete($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        });
    }
});	


app.controller('AppCategoryDetailsFormController', function ($state,$scope, $http, $q, $location, svcCategory,growl,$uibModal,$stateParams,svcCategoryDetails,svcCategoryDetailsTabs) {
	$scope.pageNo = 1;
	$scope.pageSize = 10;
	if($scope.searchText == undefined){ $scope.searchText = ''; } 
	$scope.CategoryId = $stateParams.CategoryId;	
	$scope.Id = $stateParams.Id;	
	
	$scope.CategorygetById = function () {
		svcCategory.Get($scope.CategoryId).then(function (r) {
				$scope.Category =  r;
				$scope.pageTitle = "Add New " + $scope.Category.Name;
				
        });
    }
	$scope.CategorygetById();
	
	
	$scope.getById = function () {
		$q.all([svcCategoryDetails.Get($scope.Id),svcCategoryDetailsTabs.List('',0,0,$scope.Id)]).then(function(r){
			$scope.formData =  r[0];
			$scope.formData.DetailsTabs = r[1].Results;
			console.log($scope.formData);
		})
    }

	
	$scope.Id == 0 ?  $scope.formData = {} : $scope.getById() ;
	
	
	$scope.save = function () {
		$scope.formData.CategoryId = $scope.CategoryId;
		svcCategoryDetails.Save($scope.formData).then(function (r) {
			growl.success("Data Successfully Save");

			 if($scope.Id == 0){
				 $state.go('category.detailsForm', { 'CategoryId': $scope.CategoryId , 'Id': r.Id });
			 }
        });
    }
	
	$scope.NewContent = function(){
		$state.go('category.detailsForm', { 'CategoryId': $scope.CategoryId , 'Id': 0 });
	}
	
	$scope.openTabModal = function (size) {
			var modal = $uibModal.open({
			templateUrl: 'views/category/details-tabList.html',
			controller: 'AppCategoryDetailsTabModalController',
			size: size,
			resolve: {
				CategoryDetailsId: function () {
					return $scope.Id;
				}
			}
			});
			modal.result.then(function () { }, function () { 
				$scope.getById();
			});
	};

	

	
});

app.controller('AppCategoryDetailsTabModalController', function ($rootScope,$scope, $http, $q, $location, svcCategoryDetailsTabs,growl,$uibModal,CategoryDetailsId,$uibModalInstance) {
	$scope.pageNo = 1;
	$scope.pageSize = 10;
	if($scope.searchText == undefined){ $scope.searchText = ''; } 
	$scope.CategoryDetailsId = 	CategoryDetailsId;
   
    $scope.load = function () {
		svcCategoryDetailsTabs.List($scope.searchText,$scope.pageNo,$scope.pageSize,$scope.CategoryDetailsId).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
    }
    $scope.load();
	
	$scope.pageChanged = function () { $scope.load();}
	

	$scope.formData = {  }
	$scope.save = function () {
		$scope.formData.CategoryDetailsId = $scope.CategoryDetailsId;
		svcCategoryDetailsTabs.Save($scope.formData).then(function (r) {
			$scope.load();
			growl.success("Data Successfully Save");
			$scope.formData = {  }
        });
    }
	
	$scope.getById = function (id) {
		svcCategoryDetailsTabs.Get(id).then(function (r) {
				$scope.formData =  r
        });
    }
	
	$scope.delete = function (id) {
		svcCategoryDetailsTabs.Delete(id).then(function (r) {
				$scope.load();
        });
	};
	
	$scope.close = function(){ $uibModalInstance.dismiss(); }
	
});




