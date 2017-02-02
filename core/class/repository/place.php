<?php 
class PlaceRepository{
		function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_place  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_place  WHERE Id = '$id'");
			$query->execute();	
		}
		function DataList($Category,$searchText,$pageNo,$pageSize){
			global $conn;
			$pageNo = ($pageNo - 1) * $pageSize; 
			
			$where = "";
			if($searchText != ''){
				$where .= "And tbl_place.Name LIKE '%$searchText%'";
			}
			if($Category != 'all'){
				$where .= "And PlaceCategoryId  = '$Category'";
			}
			
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT *,tbl_place.Name AS Name,tbl_place.Id AS Id,tbl_place_category.Name AS Category FROM  tbl_place
			LEFT JOIN tbl_place_category ON tbl_place_category.Id  = tbl_place.PlaceCategoryId
			WHERE 1 = 1 $where $limitCondition");
			$count = $searchText != '' ?  $query->rowcount() : $conn->query("SELECT * FROM  tbl_place")->rowcount();
			
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Create(){
			global $conn;
			$query = $conn->prepare("INSERT INTO tbl_place (Name,Address,Description,Latitude,Longitude,WebsiteUrl,ContactInfo,PlaceCategoryId) VALUES(:Name,:Address,:Description,:Latitude,:Longitude,:WebsiteUrl,:ContactInfo,:PlaceCategoryId)");
			return $query;	
		}
		public function Update(){
			global $conn;
			$query = $conn->prepare("UPDATE tbl_place SET 
			Name = :Name ,
			Address = :Address,
			Description = :Description,
			Latitude = :Latitude,
			Longitude = :Longitude,
			WebsiteUrl = :WebsiteUrl,
			ContactInfo = :ContactInfo,
			PlaceCategoryId = :PlaceCategoryId
			WHERE Id = :Id");
			return $query;	
		}
		public function Transform($POST){
			$POST->Id = !isset($POST->Id) ? 0 : $POST->Id;
			$POST->Name = !isset($POST->Name) ? '' : $POST->Name; 
			$POST->Address = !isset($POST->Address) ? '' : $POST->Address; 
			$POST->Description = !isset($POST->Description) ? '' : $POST->Description; 
			$POST->Latitude = !isset($POST->Latitude) ? '' : $POST->Latitude; 
			$POST->Longitude = !isset($POST->Longitude) ? '' : $POST->Longitude; 
			$POST->WebsiteUrl = !isset($POST->WebsiteUrl) ? '' : $POST->WebsiteUrl; 
			$POST->ContactInfo = !isset($POST->ContactInfo) ? '' : $POST->ContactInfo; 
			$POST->PlaceCategoryId = !isset($POST->PlaceCategoryId) ? '' : $POST->PlaceCategoryId; 
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
			$query->bindParam(':Address', $POST->Address);
			$query->bindParam(':Description', $POST->Description);
			$query->bindParam(':Latitude', $POST->Latitude);
			$query->bindParam(':Longitude', $POST->Longitude);
			$query->bindParam(':WebsiteUrl', $POST->WebsiteUrl);
			$query->bindParam(':ContactInfo', $POST->ContactInfo);
			$query->bindParam(':PlaceCategoryId', $POST->PlaceCategoryId);
			$query->execute();	
			
			if($POST->Id == 0){ $POST->Id = $conn->lastInsertId(); }
			return 	$POST;			
		}
}


?>