<?php 
class CategoryDetailsRepository{
		function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_category_details  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_category_details  WHERE Id = '$id'");
			$query->execute();	
		}
		function DataList($searchText,$pageNo,$pageSize,$CategoryId){
			global $conn;
			$pageNo = ($pageNo - 1) * $pageSize; 
			
			$where = "";
			if($searchText != ''){
				$where .= "And Name LIKE '%$searchText%'";
			}
			if($CategoryId != 0){
				$where .= "And CategoryId = '$CategoryId'";
			}
			
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT * FROM  tbl_category_details WHERE 1 = 1 $where $limitCondition");
			$count = $searchText != '' ?  $query->rowcount() : $conn->query("SELECT * FROM  tbl_category_details")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_category_details (Name,CategoryId,Description) VALUES(:Name,:CategoryId,:Description)");
			return $query;	
		}
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_category_details SET Name = :Name , CategoryId = :CategoryId , Description = :Description WHERE Id = :Id");
			return $query;	
		}
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->Name = !isset($POST->Name) ? '' : $POST->Name; 
			$POST->CategoryId = !isset($POST->CategoryId) ? '' : $POST->CategoryId; 
			$POST->Description = !isset($POST->Description) ? '' : $POST->Description; 
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
			$query->bindParam(':CategoryId', $POST->CategoryId);
			$query->bindParam(':Description', $POST->Description);
			$query->execute();	
			
			if($POST->Id == 0){ $POST->Id = $conn->lastInsertId(); }
			return 	$POST;			
		}
}


?>