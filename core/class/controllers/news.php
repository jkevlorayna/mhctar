<?php 
$slim_app->get('/news/:id',function($id){
	$result = $GLOBALS['NewsRepo']->Get($id);
	echo json_encode($result);
});
$slim_app->get('/news/category/:id',function($id){
	$result = $GLOBALS['NewsRepo']->GetByCategory($id);
	echo json_encode($result);
});
$slim_app->get('/news',function(){
	$result = $GLOBALS['NewsRepo']->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize']);
	echo json_encode($result);
});
$slim_app->delete('/news/:id',function($id){
	$GLOBALS['NewsRepo']->Delete($id);
});
$slim_app->post('/news',function(){
	$GLOBALS['NewsRepo']->Save();
});
?>