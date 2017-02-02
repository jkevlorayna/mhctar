<?php 
$slim_app->get('/placeCategory/:id',function($id){
	$PlaceCategoryRepo = new PlaceCategoryRepository();
	$result = $PlaceCategoryRepo->Get($id);
	echo json_encode($result);
});
$slim_app->get('/placeCategory',function(){
	$PlaceCategoryRepo = new PlaceCategoryRepository();
	$result = $PlaceCategoryRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/placeCategory/:id',function($id){
	$PlaceCategoryRepo = new PlaceCategoryRepository();
	$PlaceCategoryRepo->Delete($id);
});
$slim_app->post('/placeCategory',function(){
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());

	$PlaceCategoryRepo = new PlaceCategoryRepository();
	$PlaceCategoryRepo->Save($PlaceCategoryRepo->Transform($POST));
});
?>