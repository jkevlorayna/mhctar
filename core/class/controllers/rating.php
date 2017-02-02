<?php 
$slim_app->get('/rating/:id',function($id){
	$result = $GLOBALS['RatingRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->get('/rating/guest/:id/:placeid',function($id,$placeid){
	$result = $GLOBALS['RatingRepo']->GetByGuestId($id,$placeid);
	echo json_encode($result);
});
$slim_app->get('/rating',function(){
	$result = $GLOBALS['RatingRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize'],$_GET['placeId']);
	echo json_encode($result);
});
$slim_app->delete('/rating/:id',function($id){
	$GLOBALS['RatingRepo']->Delete($id);
});
$slim_app->post('/rating',function(){
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());
			
	$result = $GLOBALS['RatingRepo']->GetByGuestId($POST->GuestId,$POST->PlaceId);
	$POST->Id = $result['Id'];
	$GLOBALS['RatingRepo']->Save($POST);
});
?>