<?php 
$slim_app->get('/pages/:id',function($id){
	$PageRepo = new PageRepository();
	$result = $PageRepo->Get($id);
	echo json_encode($result);
});
$slim_app->get('/pages',function(){
	$PageRepo = new PageRepository();
	$result = $PageRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/pages/:id',function($id){
	$PageRepo = new PageRepository();
	$PageRepo->Delete($id);
});
$slim_app->post('/pages',function(){
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());

	$PageRepo = new PageRepository();
	$PageRepo->Save($PageRepo->Transform($POST));
});
?>