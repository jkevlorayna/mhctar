<?php 
$slim_app->get('/categoryDetails/:id',function($id){
	$CategoryDetailsRepo = new CategoryDetailsRepository();
	$result = $CategoryDetailsRepo->Get($id);
	echo json_encode($result);
});
$slim_app->get('/categoryDetails',function(){
	$CategoryDetailsRepo = new CategoryDetailsRepository();
	$result = $CategoryDetailsRepo->DataList($_GET['searchText'],$_GET['pageNo'],$_GET['pageSize'],$_GET['CategoryId']);
	echo json_encode($result);
});
$slim_app->delete('/categoryDetails/:id',function($id){
	$CategoryDetailsRepo = new CategoryDetailsRepository();
	$CategoryDetailsRepo->Delete($id);
});
$slim_app->post('/categoryDetails',function(){
	$request = \Slim\Slim::getInstance()->request();
	$POST = json_decode($request->getBody());
	$CategoryDetailsRepo = new CategoryDetailsRepository();
	$CategoryDefaultTabRepo = new CategoryDefaultTabRepository();
	$CategoryDetailsTabsRepo = new CategoryDetailsTabsRepository();
	
	$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;

	if($POST->Id == 0){
		$CategoryDefaultTabs = $CategoryDefaultTabRepo->DataList('',0,0,$POST->CategoryId);
		$CategoryDetails = $CategoryDetailsRepo->Save($CategoryDetailsRepo->Transform($POST));
		foreach($CategoryDefaultTabs['Results'] as $row){
			$data = new stdClass;
			$data->Name = $row->Name;
			$data->CategoryDetailsId = $CategoryDetails->Id;
			$CategoryDetailsTabsRepo->Save($CategoryDetailsTabsRepo->Transform($data));
		}
		echo json_encode($CategoryDetails);
	}else{
		$CategoryDetails = $CategoryDetailsRepo->Save($CategoryDetailsRepo->Transform($POST));
		$count = count($POST->DetailsTabs);
		if($count > 0){
			foreach($POST->DetailsTabs as $row){
				$CategoryDetailsTabsRepo->Save($CategoryDetailsTabsRepo->Transform($row));
			}
		}
	}
	
	
});
?>