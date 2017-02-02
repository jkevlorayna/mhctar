<?php 
$slim_app->get('/category/:id',function($id){
	$CategoryRepo = new CategoryRepository();
	$result = $CategoryRepo->Get($id);
	echo json_encode($result);
});
$slim_app->get('/category',function(){
	$CategoryRepo = new CategoryRepository();
	$result = $CategoryRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/category/:id',function($id){
	$CategoryRepo = new CategoryRepository();
	$CategoryRepo->Delete($id);
});
$slim_app->post('/category',function(){
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());

	$CategoryRepo = new CategoryRepository();
	$CategoryRepo->Save($CategoryRepo->Transform($POST));
});
?>