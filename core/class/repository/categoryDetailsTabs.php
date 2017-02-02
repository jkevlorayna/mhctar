<?php 
class CategoryDetailsTabsRepository{
		function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_category_details_tab  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_category_details_tab  WHERE Id = '$id'");
			$query->execute();	
		}
		function DataList($searchText,$pageNo,$pageSize,$CategoryDetailsId){
			global $conn;
			$pageNo = ($pageNo - 1) * $pageSize; 
			
			$where = "";
			if($searchText != ''){
				$where .= "And Name LIKE '%$searchText%'";
			}
			if($CategoryDetailsId != 0){
				$where .= "And CategoryDetailsId = '$CategoryDetailsId'";
			}
			
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT * FROM  tbl_category_details_tab WHERE 1 = 1 $where $limitCondition");
			$count = $searchText != '' ?  $query->rowcount() : $conn->query("SELECT * FROM  tbl_category_details_tab")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_category_details_tab (Name,Content,CategoryDetailsId) VALUES(:Name,:Content,:CategoryDetailsId)");
			return $query;	
		}
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_category_details_tab SET Name = :Name , Content = :Content , CategoryDetailsId = :CategoryDetailsId WHERE Id = :Id");
			return $query;	
		}
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->Name = !isset($POST->Name) ? '' : $POST->Name; 
			$POST->Content = !isset($POST->Content) ? '' : $POST->Content; 
			$POST->CategoryDetailsId = !isset($POST->CategoryDetailsId) ? '' : $POST->CategoryDetailsId; 
			return $POST;
		}
		function Save($POST){
			global $conn;
			if($POST->Id == 0){
				$query = $this->Create();
			}else{
				$query = $this->UPDATE();
				$query->bindParam(':Id', $POST->Id);
			}
			$query->bindParam(':Name', $POST->Name);
			$query->bindParam(':Content', $POST->Content);
			$query->bindParam(':CategoryDetailsId', $POST->CategoryDetailsId);
			$query->execute();	
			
			if($POST->Id == 0){ $POST->Id = $conn->lastInsertId(); }
			return 	$POST;			
		}
}


?>