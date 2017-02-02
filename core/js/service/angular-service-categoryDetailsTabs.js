app.factory('svcCategoryDetailsTabs', function ($rootScope, $http, $q) {
    $this = {
        List: function (searchText,pageNo,pageSize,CategoryDetailsId) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/categoryDetailsTabs?searchText='+searchText+'&pageNo='+pageNo+'&pageSize='+pageSize+'&CategoryDetailsId='+CategoryDetailsId
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },Get: function (id) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/categoryDetailsTabs/'+id
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },Delete: function (id) {
            var deferred = $q.defer();
            $http({
                method: 'DELETE',
                url: BasePath+'/class/categoryDetailsTabs/'+id
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },Save: function (postData) {
            var deferred = $q.defer();
            $http({
                method: 'POST',
                url: BasePath+'/class/categoryDetailsTabs',
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