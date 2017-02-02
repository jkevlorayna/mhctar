<?php $path = 'core/' ?> 
<?php 
session_start(); 
if(!isset($_SESSION['isAuthenticated'])){ $isAuthenticated = false; }else{ $isAuthenticated = true; }
?>
<?php include('core/header.php'); ?>
<body class="texture" ng-controller="AppMainController" ng-init="<?php echo $isAuthenticated; ?>">
	<div style="width:400px;" growl></div>
	
<div id="cl-wrapper">
<?php //phpInfo(); ?>
  <div class="cl-sidebar" ng-show="session.isAuthenticated">
    <div class="cl-toggle"><i class="fa fa-bars"></i></div>
    <div class="cl-navblock">
      <div class="menu-space">
        <div class="content">
          <ul class="cl-vnavigation">
			    <li><a href="#/"><i class="fa fa-home"></i> Home</a></li>
				<li><a href="#/page/list"><i class="fa fa-table"></i>  Pages</a></li>
				<li><a href="#/user/list"><i class="fa fa-group"></i> User List</a></li>
					
				<li ng-cloak ng-repeat="row in SidebarCategory">
					<a href="#/category/{{row.Id}}/details"><i class="fa fa-folder"></i> {{row.Name}}</a>
				</li>

				<li>
					<a href="#"><i class="fa fa-folder"></i><span>Places</span></a> 
					<ul class="sub-menu">						
							<li><a href="#/place/list">List</a></li>
							<li><a href="#/place/category">Category</a></li>
							<li><a href="#/place/default/tabs">Default Tabs</a></li>
					</ul>		
				</li>
				<li>
					<a href="#"><i class="fa fa-folder"></i><span>Category</span></a> 
					<ul class="sub-menu">						
							<li><a href="#/category/list">List</a></li>
							<li><a href="#/category/{{DefaultCategory.Id}}/default/tabs">Default Tabs</a></li>
					</ul>		
				</li>
				<li>
					<a href="#"><i class="fa fa-folder"></i><span>Selection Menu</span></a> 
					<ul class="sub-menu">						
							<li><a href="#/user/type">User Type</a></li>
					</ul>		
				</li>
				<li>
					<a href="#"><i class="fa fa-gears"></i><span>Settings</span></a> 
					<ul class="sub-menu">						
							<li><a href="#/setting/defaultTab">Default Place Tab</a></li>
					</ul>		
				</li>
          </ul>
        </div>
      </div>
    </div>
  </div>


	
		<div class="container-fluid" id="pcont">
				
				  <div id="head-nav" class="navbar navbar-default" ng-show="session.isAuthenticated">
    <div class="container-fluid">
      <div class="navbar-collapse">
        <ul class="nav navbar-nav navbar-right user-nav">	
          <li class="dropdown profile_menu">
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> 
				<span>Welcome: {{session.userData.name}}</span> <b class="caret"></b>
			</a>
            <ul class="dropdown-menu">
              <li><a href="javascript:void(0)" ng-click="passwordModal('md',session.userData.user_id,'Admin')"> Change Password</a></li>
			  <li class="divider"></li>
              <li><a href="javascript:void(0)" ng-click="logout()"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
          </li>
        </ul>	
			<h3><i class="fa fa-gears"></i> MHCTAR Administrator</h3>
      </div>
    </div>
  </div>

				
				<div class="cl-mcont main_con">
						<div ui-view></div>
				</div>
	</div> 
	
</div>
<?php include('core/script.php') ?>
<div cg-busy="true"></div>
</body>
</html>
