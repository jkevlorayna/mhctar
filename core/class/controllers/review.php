<?php 
$slim_app->get('/review/:id',function($id){
	$result = $GLOBALS['ReviewRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->post('/review/list',function(){
	$result = $GLOBALS['ReviewRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize'],$_GET['placeId']);
	echo json_encode($result);
});
$slim_app->delete('/review/:id',function($id){
	$GLOBALS['ReviewRepo']->Delete($id);
});
$slim_app->post('/review',function(){
	$GLOBALS['ReviewRepo']->Save();
});
?>