<?php 
class ReviewRepository{
		 public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_review  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_review  WHERE Id = '$id'");
			$query->execute();	
		}
		public function DataList($searchText,$pageNo,$pageSize,$PlaceId){
			global $conn;
					$pageNo = ($pageNo - 1) * $pageSize; 
					$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
					$query = $conn->query("SELECT *,tbl_review.Id AS Id FROM  tbl_review 
					LEFT JOIN tbl_guest ON tbl_guest.GuestId = tbl_review.GuestId
					LEFT  JOIN tbl_user_rating ON tbl_review.PlaceId = tbl_user_rating.PlaceId
					
					WHERE tbl_review.PlaceId = '$PlaceId' GROUP BY tbl_review.Id  ORDER BY  reviewDate Desc  $limitCondition ");
					$count = $searchText != '' ? $query->rowcount() : $conn->query("SELECT * FROM  tbl_review WHERE PlaceId = '$PlaceId' ")->rowcount();
					
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
			$GuestId = (!isset($POST->GuestId)) ? 0 : $POST->GuestId;
			$PlaceId = (!isset($POST->PlaceId)) ? 0 : $POST->PlaceId;
			$content = (!isset($POST->content)) ? 0 : $POST->content;
			$reviewDate = date('Y-m-d');
	
			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_review (GuestId,content,reviewDate,PlaceId) VALUES(?,?,?,?)");
				$query->execute(array($GuestId,$content,$reviewDate,$PlaceId));	
			}else{
				$query = $conn->prepare("UPDATE tbl_review SET GuestId = ?  , content = ?  WHERE Id = ? ");
				$query->execute(array($GuestId,$content,$id));	
			}

		}
}
$GLOBALS['ReviewRepo'] = new ReviewRepository();
?>