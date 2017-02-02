app.factory('svcCategoryDefaultTabs', function ($rootScope, $http, $q) {
    $this = {
        List: function (searchText,pageNo,pageSize,CategoryId) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/categoryDefaultTabs?searchText='+searchText+'&pageNo='+pageNo+'&pageSize='+pageSize+'&CategoryId='+CategoryId
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
                url: BasePath+'/class/categoryDefaultTabs/'+id
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
                url: BasePath+'/class/categoryDefaultTabs/'+id
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
                url: BasePath+'/class/categoryDefaultTabs',
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