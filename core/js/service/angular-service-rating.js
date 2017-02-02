app.factory('svcRating', function ($rootScope, $http, $q) {
    $this = {
        listAll: function () {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/rating/all/'
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },
        list: function (searchText,pageNo,pageSize,placeId) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/rating?searchText='+searchText+'&pageNo='+pageNo+'&pageSize='+pageSize+'&placeId='+placeId
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },
		  getById: function (id) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/rating/'+id
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },
			  getByGuestId: function (id,PlaceId) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/rating/guest/'+id+'/'+PlaceId
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        }
		,
		deleteData: function (id) {
            var deferred = $q.defer();
            $http({
                method: 'DELETE',
                url: BasePath+'/class/rating/'+id
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        }
		,save: function (postData) {
            var deferred = $q.defer();
            $http({
                method: 'POST',
                url: BasePath+'/class/rating',
                data:postData
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        }
    };
    return $this;
});