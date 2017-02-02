<?php 
class RatingRepository{
		 public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_user_rating  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		 public function GetByGuestId($id,$PlaceId){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_user_rating  WHERE GuestId = '$id' AND PlaceId = '$PlaceId'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_user_rating  WHERE Id = '$id'");
			$query->execute();	
		}
		public function DataList($searchText,$pageNo,$pageSize,$PlaceId){
			global $conn;
					$pageNo = ($pageNo - 1) * $pageSize; 
					$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
					$query = $conn->query("SELECT *,tbl_user_rating.Id AS Id  FROM  tbl_user_rating 
					LEFT JOIN tbl_guest ON tbl_guest.GuestId = tbl_user_rating.GuestId
					WHERE PlaceId = '$PlaceId'  $limitCondition ");
					$count = $searchText != '' ? $query->rowcount() : $conn->query("SELECT * FROM  tbl_user_rating WHERE PlaceId = '$PlaceId' ")->rowcount();
					
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Save($POST){
			global $conn;

			
			$id = (!isset($POST->Id)) ? 0 : $POST->Id;
			$GuestId = (!isset($POST->GuestId)) ? 0 : $POST->GuestId;
			$PlaceId = (!isset($POST->PlaceId)) ? 0 : $POST->PlaceId;
			$rating = (!isset($POST->rating)) ? 0 : $POST->rating;
			$RatingDate = date('Y-m-d');
	
			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_user_rating (GuestId,rating,RatingDate,PlaceId) VALUES(?,?,?,?)");
				$query->execute(array($GuestId,$rating,$RatingDate,$PlaceId));	
			}else{
				$query = $conn->prepare("UPDATE tbl_user_rating SET GuestId = ?  , rating = ?  WHERE Id = ? ");
				$query->execute(array($GuestId,$rating,$id));	
			}

		}
}
$GLOBALS['RatingRepo'] = new RatingRepository();
?>