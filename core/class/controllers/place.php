<?php 
$slim_app->get('/place/:id',function($id){
	$PlaceRepo = new PlaceRepository();
	$result = $PlaceRepo->Get($id);
	echo json_encode($result);
});
$slim_app->get('/place',function(){
	$PlaceRepo = new PlaceRepository();
	$result = $PlaceRepo->DataList($_GET['category'],$_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/place/:id',function($id){
	$PlaceRepo = new PlaceRepository();
	$PlaceRepo->Delete($id);
});
$slim_app->post('/place',function(){
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());

	$PlaceRepo = new PlaceRepository();
	$result = $PlaceRepo->Save($PlaceRepo->Transform($POST));
	echo json_encode($result); 
});
?>