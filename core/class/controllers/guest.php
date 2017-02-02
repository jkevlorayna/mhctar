<?php
$slim_app->get('/guest/:id',function($id){
	$result = $GLOBALS['GuestRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->get('/getbyguestid/:id',function($id){
	$result = $GLOBALS['GuestRepo']->GetByGuestId($id);
	echo json_encode($result);
});
$slim_app->get('/guest',function(){
	$result = $GLOBALS['GuestRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/guest/:id',function($id){
	$GLOBALS['GuestRepo']->Delete($id);
});
$slim_app->post('/guest',function(){
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());
	
	try {
	
		$GuestId = (!isset($POST->GuestId)) ? 0 : $POST->GuestId;		
		$row = $GLOBALS['GuestRepo']->GetByGuestId($GuestId);
		if($row == null){
			$GLOBALS['GuestRepo']->Save($POST);
		}
	} catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "\n";
	}

		
	
});
?>