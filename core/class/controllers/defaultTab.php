<?php 
$slim_app->get('/DefaultTab/:id',function($id){
	$result = $GLOBALS['DefaultTabRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->get('/DefaultTab',function(){
	$result = $GLOBALS['DefaultTabRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/DefaultTab/:id',function($id){
	$GLOBALS['DefaultTabRepo']->Delete($id);
});
$slim_app->post('/DefaultTab',function(){
	$GLOBALS['DefaultTabRepo']->Save();
});
?>