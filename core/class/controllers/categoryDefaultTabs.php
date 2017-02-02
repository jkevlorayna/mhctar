<?php 
$slim_app->get('/categoryDefaultTabs/:id',function($id){
	$CategoryDefaultTabRepo = new CategoryDefaultTabRepository();
	$result = $CategoryDefaultTabRepo->Get($id);
	echo json_encode($result);
});
$slim_app->get('/categoryDefaultTabs',function(){
	$CategoryDefaultTabRepo = new CategoryDefaultTabRepository();
	$result = $CategoryDefaultTabRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize'],$_GET['CategoryId']);
	echo json_encode($result);
});
$slim_app->delete('/categoryDefaultTabs/:id',function($id){
	$CategoryDefaultTabRepo = new CategoryDefaultTabRepository();
	$CategoryDefaultTabRepo->Delete($id);
});
$slim_app->post('/categoryDefaultTabs',function(){
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());

	$CategoryDefaultTabRepo = new CategoryDefaultTabRepository();
	$CategoryDefaultTabRepo->Save($CategoryDefaultTabRepo->Transform($POST));
});
?>