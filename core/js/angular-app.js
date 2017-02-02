// var MainFolder = 'tour';
var BasePath = 'core';
var app = angular.module('app', ['angular-input-stars','ui.router','ui.bootstrap','ngSanitize', 'ui.select','angular-growl','ngCookies','ngAnimate','checklist-model','uiGmapgoogle-maps','angular-loading-bar','angularFileUpload','ui.event']);
app.run(function ($rootScope, $location,$cookieStore,$window,svcLogin) {
   var cookieCheck = $cookieStore.get('credentials');
   


    $rootScope.$on("$stateChangeStart",function() { 
   		svcLogin.auth().then(function (r) {
			if(r == "false"){ 
				$location.path("/login");
			}
		});
    });
   


});
app.filter('propsFilter', function() {
  return function(items, props) {
    var out = [];

    if (angular.isArray(items)) {
      var keys = Object.keys(props);
        
      items.forEach(function(item) {
        var itemMatches = false;

        for (var i = 0; i < keys.length; i++) {
          var prop = keys[i];
          var text = props[prop].toLowerCase();
          if (item[prop].toString().toLowerCase().indexOf(text) !== -1) {
            itemMatches = true;
            break;
          }
        }

        if (itemMatches) {
          out.push(item);
        }
      });
    } else {
      // Let the output be the input untouched
      out = items;
    }

    return out;
  };
});
app.config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {
    $urlRouterProvider.otherwise("/login")
    $stateProvider
	    .state('home',
        {
            url: '/',
            templateUrl: "views/home.html",
            controller: "",
        })
        .state('login',
        {
            url: '/login',
            templateUrl: "views/login.html",
            controller: "AppLoginController",
        })
		//category
		 .state('category',
        {
            url: '/category',
            templateUrl: "views/category/index.html",
            controller: "",
        })
		.state('category.list',
        {
            url: '/list',
            templateUrl: "views/category/list.html",
            controller: "AppCategoryController",
        })
		.state('category.details',
        {
            url: '/:CategoryId/details',
            templateUrl: "views/category/details.html",
            controller: "AppCategoryDetailsController",
        })
		.state('category.detailsForm',
        {
            url: '/:CategoryId/details/form/:Id',
            templateUrl: "views/category/details-form.html",
            controller: "AppCategoryDetailsFormController",
        })
		.state('category.defaultTab',
        {
            url: '/:Id/default/tabs',
            templateUrl: "views/category/defaultTabs.html",
            controller: "AppCategoryDefaultTabsController",
        })
		// end category
		// place
			.state('place',
			{
				url: '/place',
				templateUrl: "views/place/index.html",
				controller: "",
			})
			.state('place.list',
			{
				url: '/list',
				templateUrl: "views/place/list.html",
				controller: "AppPlaceController",
			})
			.state('place.category',
			{
				url: '/category',
				templateUrl: "views/place/category.html",
				controller: "AppPlaceCategoryController",
			})
			.state('place.form',
			{
				url: '/form/:Id',
				templateUrl: "views/place/form.html",
				controller: "AppPlaceFormController",
			})
			.state('place.map',
			{
				url: '/map/:Id',
				templateUrl: "views/place/map.html",
				controller: "AppPlaceMapController",
			})
		// end place
		
		
		//user 
			.state('user',
			{
				url: '/user',
				templateUrl: "views/user/index.html",
				controller: "",
			})
			.state('user.list',
			{
				url: '/list',
				templateUrl: "views/user/list.html",
				controller: "AppUserController",
			})
			.state('user.type',
			{
				url: '/type',
				templateUrl: "views/user/type.html",
				controller: "AppUserTypeController",
			})
			.state('user.roles',
			{
				url: '/roles/:UserId',
				templateUrl: "views/user/roles.html",
				controller: "AppUserRoleController",
			})
			.state('userType',
			{
				url: '/usertype',
				templateUrl: "views/user_type.html",
				controller: "AppUserTypeController",
			})
		// end user
		
		//page 
			.state('page',
			{
				url: '/page',
				templateUrl: "views/page/index.html",
				controller: "",
			})
			.state('page.list',
			{
				url: '/list',
				templateUrl: "views/page/list.html",
				controller: "AppPagesController",
			})
			.state('page.form',
			{
				url: '/form/:Id',
				templateUrl: "views/page/form.html",
				controller: "AppPagesFormController",
			})
		// end page
		
		
		//event 
			.state('event',
			{
				url: '/event',
				templateUrl: "views/event/index.html",
				controller: "",
			})
			.state('event.list',
			{
				url: '/list',
				templateUrl: "views/event/list.html",
				controller: "AppEventController",
			})
			.state('event.form',
			{
				url: '/form/:Id',
				templateUrl: "views/event/form.html",
				controller: "AppEventFormController",
			})
			.state('event.map',
			{
				url: '/map/:Id',
				templateUrl: "views/event/map.html",
				controller: "AppEventMapController",
			})
		// end event
		
		
		//news 
			.state('news',
			{
				url: '/news',
				templateUrl: "views/news/index.html",
				controller: "",
			})
			.state('news.list',
			{
				url: '/list',
				templateUrl: "views/news/list.html",
				controller: "AppNewsController",
			})
			.state('news.form',
			{
				url: '/form/:Id',
				templateUrl: "views/news/form.html",
				controller: "AppNewsFormController",
			})
		// news event
		
		
		// setting
			.state('setting',
			{
				url: '/setting',
				templateUrl: "views/setting.html",
				controller: "AppSettingController",
			})
			.state('settingPlaceTab',
			{
				url: '/setting/defaultTab',
				templateUrl: "views/setting/defaultTab.html",
				controller: "AppDefaultTabController",
			})
		// end setting
		
		
		//guest 
			.state('guest',
			{
				url: '/guest',
				templateUrl: "views/guest/index.html",
				controller: "",
			})
			.state('guest.list',
			{
				url: '/list',
				templateUrl: "views/guest/list.html",
				controller: "AppGuestController",
			})
			.state('guest.form',
			{
				url: '/form/:Id',
				templateUrl: "views/guest/form.html",
				controller: "AppGuestFormController",
			})
		// guest
		
		
}]);
app.config(['growlProvider', function(growlProvider) {
  growlProvider.globalTimeToLive(5000);
   growlProvider.globalDisableCountDown(true);
}]);
app.config(['cfpLoadingBarProvider', function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.spinnerTemplate = '<div><span class="loading">Loading...</div>';
}])
app.config(function(uiGmapGoogleMapApiProvider) {
    uiGmapGoogleMapApiProvider.configure({
        key: 'AIzaSyAp8NuB7COJf5fTBJJiF6VGk9d6fT6LWiM',
        v: '3.20', //defaults to latest 3.X anyhow
        libraries: 'weather,geometry,visualization'
    });
})
