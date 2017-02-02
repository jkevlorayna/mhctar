<?php 
$slim_app->get('/placetab/:id',function($id){
	$result = $GLOBALS['PlaceTabRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->get('/placetab/list/:id',function($id){
	$result = $GLOBALS['PlaceTabRepo']->DataList($id,$_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/placetab/:id',function($id){
	$GLOBALS['PlaceTabRepo']->Delete($id);
});
$slim_app->post('/placetab',function(){
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());
	
	$GLOBALS['PlaceTabRepo']->Save($POST);
});
?>