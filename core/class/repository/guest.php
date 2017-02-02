<?php 
class GuestRepository{
		 public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_guest  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		 public function GetByGuestId($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_guest  WHERE GuestId = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_guest  WHERE Id = '$id'");
			$query->execute();	
		}
		public function DataList($searchText,$pageNo,$pageSize){
			global $conn;
					$pageNo = ($pageNo - 1) * $pageSize; 
					$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
					$query = $conn->query("SELECT * FROM  tbl_guest WHERE name LIKE '%$searchText%'  $limitCondition ");
					$count = $searchText != '' ? $query->rowcount() : $conn->query("SELECT * FROM  tbl_guest")->rowcount();
					
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Save($POST){
			global $conn;			
			$id = (!isset($POST->Id)) ? 0 : $POST->Id;
			$GuestId = (!isset($POST->GuestId)) ? 0 : $POST->GuestId;
			$name = (!isset($POST->name)) ? 0 : $POST->name;
			$ImageUrl	 = (!isset($POST->ImageUrl	)) ? 0 : $POST->ImageUrl	;
			$email	 = (!isset($POST->email	)) ? 0 : $POST->email	;
			$ContactNumber = 0;
			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_guest (GuestId,name,ImageUrl,email,ContactNumber) VALUES(?,?,?,?,?)");
				$query->execute(array($GuestId,$name,$ImageUrl,$email,$ContactNumber));	
			}else{
				$query = $conn->prepare("UPDATE tbl_guest SET GuestId = ?  , name = ? , ImageUrl = ? , email = ? , ContactNumber = ?  WHERE Id = ? ");
				$query->execute(array($GuestId,$name,$ImageUrl,$email,$ContactNumber,$id));	
			}

		}
}
$GLOBALS['GuestRepo'] = new GuestRepository();
?>