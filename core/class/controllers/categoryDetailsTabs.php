<?php 
$slim_app->get('/categoryDetailsTabs/:id',function($id){
	$CategoryDetailsTabsRepo = new CategoryDetailsTabsRepository();
	$result = $CategoryDetailsTabsRepo->Get($id);
	echo json_encode($result);
});
$slim_app->get('/categoryDetailsTabs',function(){
	$CategoryDetailsTabsRepo = new CategoryDetailsTabsRepository();
	$result = $CategoryDetailsTabsRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize'],$_GET['CategoryDetailsId']);
	echo json_encode($result);
});
$slim_app->delete('/categoryDetailsTabs/:id',function($id){
	$CategoryDetailsTabsRepo = new CategoryDetailsTabsRepository();
	$CategoryDetailsTabsRepo->Delete($id);
});
$slim_app->post('/categoryDetailsTabs',function(){
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());

	$CategoryDetailsTabsRepo = new CategoryDetailsTabsRepository();
	$CategoryDetailsTabsRepo->Save($CategoryDetailsTabsRepo->Transform($POST));
});
?>