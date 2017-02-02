<?php 
class DefaultTabRepository{
		 public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_default_tab  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_default_tab  WHERE Id = '$id'");
			$query->execute();	
		}
		public function DataList($searchText,$pageNo,$pageSize){
			global $conn;
					$pageNo = ($pageNo - 1) * $pageSize; 
					$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
					$query = $conn->query("SELECT * FROM  tbl_default_tab WHERE name LIKE '%$searchText%' $limitCondition ");
					$count = $searchText != '' ? $query->rowcount() : $conn->query("SELECT * FROM  tbl_default_tab")->rowcount();
					
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Save(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
			
			$id = (!isset($POST->Id)) ? 0 : $POST->Id;
			$name = $POST->name;
	
			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_default_tab (name) VALUES(?)");
				$query->execute(array($name));	
				return $conn->lastInsertId();
			}else{
				$query = $conn->prepare("UPDATE tbl_default_tab SET name = ?   WHERE Id = ? ");
				$query->execute(array($name,$id));	
				return $id;
			}
		
		}
}
 $GLOBALS['DefaultTabRepo'] = new DefaultTabRepository();



?>