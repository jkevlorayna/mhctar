<?php 
class PageRepository{
		function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_page  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_page  WHERE Id = '$id'");
			$query->execute();	
		}
		function DataList($searchText,$pageNo,$pageSize){
			global $conn;
			$pageNo = ($pageNo - 1) * $pageSize; 
			
			$where = "";
			if($searchText != ''){
				$where = "And Name LIKE '%$searchText%'";
			}
			
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT * FROM  tbl_page WHERE 1 = 1 $where $limitCondition");
			$count = $searchText != '' ?  $query->rowcount() : $conn->query("SELECT * FROM  tbl_page")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_page (Name,Content,Status,DateAdded) VALUES(:Name,:Content,:Status,:DateAdded)");
			return $query;	
		}
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_page SET Name = :Name , Content = :Content , Status = :Status , DateAdded = :DateAdded  WHERE Id = :Id");
			return $query;	
		}
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->Name = !isset($POST->Name) ? '' : $POST->Name; 
			$POST->Content = !isset($POST->Content) ? '' : $POST->Content; 
			$POST->Status = !isset($POST->Status) ? '' : $POST->Status; 
			$POST->DateAdded = !isset($POST->DateAdded) ? '' : $POST->DateAdded; 
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
			$query->bindParam(':Status', $POST->Status);
			$query->bindParam(':DateAdded', $POST->DateAdded);
			$query->execute();	
			
			if($POST->Id == 0){ $POST->Id = $conn->lastInsertId(); }
			return 	$POST;			
		}
}


?>