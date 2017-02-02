app.controller('AppPlaceUploadController', function ($rootScope,$scope, $http, $q, svcPlace,growl,FileUploader,$stateParams) {

	
});	
app.controller('AppPlaceController', function ($rootScope,$scope, $http, $q, $location, $filter, svcPlace,growl,$uibModal,svcPlaceCategory,FileUploader) {
	
	$scope.pageNo = 1;
	$scope.pageSize = 10;
	if($scope.searchText == undefined){ $scope.searchText = ''; } 
	if($scope.category == undefined){ $scope.category = 'all'; } 
	
	$scope.loadCategory = function(){
		svcPlaceCategory.List('',0,0,'').then(function (r) {
            $scope.categoryList = r.Results;
        })

	}	
	
    $scope.load = function () {
		svcPlace.List($scope.category,$scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
    }
    $scope.load();
    $scope.loadCategory();
	
	$scope.ChangeCategory = function(){
		 $scope.load();
	}
	
	$scope.pageChanged = function () { $scope.load(); }
	


	
	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppPlaceModalController',
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
app.controller('AppPlaceModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcPlace,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcPlace.Delete($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        });
    }
});	
app.controller('AppPlaceFormController', function ($window,$scope, $http, $q, $location, svcPlace,svcReview,svcRating,svcPlaceCategory,$stateParams,growl,uiGmapGoogleMapApi,FileUploader,$timeout,$uibModal,svcPlaceTab) {
$scope.Id = $stateParams.Id

console.log($scope.Id);

	$scope.pageNo = 1;
	$scope.pageSize = 10;
    $scope.loadAll = function () {
			$q.all([svcPlaceCategory.List('',0,0,'')]).then(function(r){
				$scope.categoryList = r[0].Results;
			});
    }
	$scope.loadAll();
  
  
	$scope.pageChanged = function(){
		$scope.loadAll();
	}
  
  
  	$scope.loadImages = function () {
		svcPlace.GetImages($scope.Id).then(function (r) {
			$scope.Images = r.Results;
        });
    }
	if($scope.Id != 0){ $scope.loadImages (); }
	
  
	$scope.getById = function () {
		svcPlace.Get($scope.Id).then(function (r) {
				$scope.formData =  r;
        });
    }
	
	
	$scope.formData = $scope.Id == 0 ? {} : $scope.getById();
	$scope.pageTitle = $scope.Id == 0 ? 'Add Place'  : 'Update Place' ;
	
	$scope.save = function () {
		svcPlace.Save($scope.formData).then(function (r) {
				growl.success("Data Successfully Save");
				console.log(r);
				if($scope.Id == 0){ $location.path('/place/form/'+r.Id); }
        });
    }
	
	
	$scope.removeFile = function (filename,Id) {
		svcPlace.removeFile(filename,Id).then(function (r) {
			growl.error("Image Successfully Deleted");
			$scope.loadImages();
        });
    }
	
	$scope.openTabModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/place/tabs.html',
			controller: 'AppPlaceTabModalController',
			size: size,
			resolve: {
				dataId: function () {
					return id;
				}
			}
			});
			modal.result.then(function () { }, function () { 
				$scope.getById();
			});
  };
	
	
		$scope.removeReview = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppReviewModalController',
			size: size,
			resolve: {
				dataId: function () {
					return id;
				}
			}
			});
			modal.result.then(function () { }, function () { 
				$scope.loadAll();
			});
	};
	
	
	$scope.removeRating = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppRatingModalController',
			size: size,
			resolve: {
				dataId: function () {
					return id;
				}
			}
			});
			modal.result.then(function () { }, function () { 
				$scope.loadAll();
			});
	};



});
app.controller('AppReviewModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcReview,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcReview.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        });
    }
});	
app.controller('AppRatingModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcRating,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcRating.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        });
    }
});	
app.controller('AppPlaceTabModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcPlace,growl,$uibModal,dataId,$uibModalInstance,svcPlaceTab) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.loadTab = function(){
		svcPlaceTab.list($scope.id,'',0,0).then(function(r){
			$scope.list = r.Results;
		})
	}
	$scope.loadTab();
	
	$scope.formData = { PlaceId: $scope.id}
	$scope.save = function () {
		svcPlaceTab.save($scope.formData).then(function (r) {
			growl.success("Data Successfully Save");
			$scope.formData ={ PlaceId: $scope.id}
			$scope.loadTab();
        });
    }
	
	$scope.delete = function (Id) {
		svcPlaceTab.deleteData(Id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.loadTab();
        });
    }
	
	$scope.getById = function(Id){
		svcPlaceTab.getById(Id).then(function(r){
			$scope.formData = r;
		})
	}

});	

app.controller('AppPlaceMapController', function ($scope, $http, $q, $location, svcPlace,svcCategory,$stateParams,growl,uiGmapGoogleMapApi,FileUploader,$timeout,$uibModal) {
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

