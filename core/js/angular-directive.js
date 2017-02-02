app.directive('ckEditor', function () {
  return {
    require: '?ngModel',
    link: function (scope, elm, attr, ngModel) {
      var ck = CKEDITOR.replace(elm[0]);
      if (!ngModel) return;
      ck.on('instanceReady', function () {
        ck.setData(ngModel.$viewValue);
      });
      function updateModel() {
        scope.$apply(function () {
          ngModel.$setViewValue(ck.getData());
        });
      }
      ck.on('change', updateModel);
      ck.on('key', updateModel);
      ck.on('dataReady', updateModel);

      ngModel.$render = function (value) {
        ck.setData(ngModel.$viewValue);
      };
    }
  };
});
 app.directive('changePassword',function(svcLogin,growl,svcMember) {
    return {
		restrict: 'E',
		link: function($scope, element, attrs) {
			$scope.Id = attrs.id;
			$scope.user = attrs.user;
			
					$scope.save = function(){
						if($scope.user == 'Admin'){
							$scope.formData.user_id = $scope.Id;
							var dataPromise = svcLogin.changePassword($scope.formData);
						}else{
							$scope.formData.Id = $scope.Id;
							
							var dataPromise = svcMember.changePassword($scope.formData);
						}
						
						dataPromise.then(function(r){
							if(r == "cpFalse"){
								growl.error("Current Password Not Match");
							}else{
								$scope.close();
								growl.success("Password Successfully Change");
							}
						});	
						
						
					}
					
					$scope.passwordCorrect = false;
					$scope.ComparePassword = function(password,cpassword){
						$scope.passwordCorrect = (password==cpassword)?false:true;
					}
		},
	   templateUrl: 'views/changePassword/form.html',
    };
 });
  app.directive('starRating',function() {
		return {
			restrict : 'A',
			template : '<ul class="rating">'
					 + '	<li ng-repeat="star in stars" ng-class="star" ng-click="toggle($index)">'
					 + '\u2605'
					 + '</li>'
					 + '</ul>',
			scope : {
				ratingValue : '=',
				max : '=',
				onRatingSelected : '&'
			},
			link : function(scope, elem, attrs) {
				var updateStars = function() {
					scope.stars = [];
					for ( var i = 0; i < scope.max; i++) {
						scope.stars.push({
							filled : i < scope.ratingValue
						});
					}
				};
				
				scope.toggle = function(index) {
					scope.ratingValue = index + 1;
					scope.onRatingSelected({
						rating : index + 1
					});
				};
				
				scope.$watch('ratingValue',
					function(oldVal, newVal) {
						if (newVal) {
							updateStars();
						}
					}
				);
			}
		};
});
 app.directive('fileUploader',function(svcLogin,growl,svcMember,$stateParams,FileUploader ) {
    return {
		restrict: 'E',
		link: function($scope, element, attrs) {

		$scope.Id = $stateParams.Id;
		var uploader = $scope.uploader = new FileUploader({
            url: BasePath+'/class/upload.php?Id='+$scope.Id
        })

        // FILTERS

        uploader.filters.push({
            name: 'customFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                return this.queue.length < 10;
            }
        });

        // CALLBACKS

        uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
            console.info('onWhenAddingFileFailed', item, filter, options);
        };
        uploader.onAfterAddingFile = function(fileItem) {
            console.info('onAfterAddingFile', fileItem);
        };
        uploader.onAfterAddingAll = function(addedFileItems) {
            console.info('onAfterAddingAll', addedFileItems);
        };
        uploader.onBeforeUploadItem = function(item) {
            console.info('onBeforeUploadItem', item);
        };
        uploader.onProgressItem = function(fileItem, progress) {
            console.info('onProgressItem', fileItem, progress);
        };
        uploader.onProgressAll = function(progress) {
            console.info('onProgressAll', progress);
        };
        uploader.onSuccessItem = function(fileItem, response, status, headers) {
            console.info('onSuccessItem', fileItem, response, status, headers);
        };
        uploader.onErrorItem = function(fileItem, response, status, headers) {
            console.info('onErrorItem', fileItem, response, status, headers);
        };
        uploader.onCancelItem = function(fileItem, response, status, headers) {
            console.info('onCancelItem', fileItem, response, status, headers);
        };
        uploader.onCompleteItem = function(fileItem, response, status, headers) {
            console.info('onCompleteItem', fileItem, response, status, headers);
        };
        uploader.onCompleteAll = function() {
            $scope.loadImages();
			uploader.clearQueue();
        };

        console.info('uploader', uploader);
		
		
		},
	   templateUrl: 'views/fileUploader/form.html',
    };
 });
 