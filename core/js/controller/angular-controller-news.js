app.controller('AppNewsController', function ($rootScope,$scope, $http, $q, $location, $filter, svcNews,growl,$uibModal,svcCategory) {
	
	$scope.pageNo = 1;
	$scope.pageSize = 10;
	if($scope.searchText == undefined){ $scope.searchText = ''; } 
	

    $scope.load = function () {
		svcNews.list($scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
    }
    $scope.load();
	
	$scope.pageChanged = function () { $scope.load(); }
	
	
	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppNewsModalController',
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
app.controller('AppNewsModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcNews,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcNews.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        });
    }
});	
app.controller('AppNewsFormController', function ($scope, $http, $q, $location, svcNews,svcCategory,$stateParams,growl,uiGmapGoogleMapApi) {
$scope.Id = $stateParams.Id
  
	$scope.getById = function () {
		svcNews.getById($scope.Id).then(function (r) {
				$scope.formData =  r
				$scope.formData.news_date = new Date(r.news_date);
        });
    }
	
	
	$scope.formData = $scope.Id == 0 ? { news_date:new Date() } : $scope.getById();
	$scope.pageTitle = $scope.Id == 0 ? 'Add Festival'  : 'Update Festival' ;
	
	
	$scope.save = function () {
		svcNews.save($scope.formData).then(function (r) {
			growl.success("Data Successfully Save");
        });
    }
	

	
	
	

	






	
});