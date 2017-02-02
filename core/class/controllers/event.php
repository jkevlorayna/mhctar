<?php 
$slim_app->get('/event/:id',function($id){
	$result = $GLOBALS['EventRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->get('/event/category/:id',function($id){
	$result = $GLOBALS['EventRepo']->GetByCategory($id);
	echo json_encode($result);
});
$slim_app->get('/event',function(){
	$result = $GLOBALS['EventRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/event/:id',function($id){
	$GLOBALS['EventRepo']->Delete($id);
});
$slim_app->post('/event',function(){
	$GLOBALS['EventRepo']->Save();
});
?>