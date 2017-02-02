<?php 
class EventRepository{
		public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_events  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_events  WHERE Id = '$id'");
			$query->execute();	
		}
		public function DataList($searchText,$pageNo,$pageSize){
			global $conn;

			$pageNo = ($pageNo - 1) * $pageSize; 
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT * FROM  tbl_events WHERE name LIKE '%$searchText%' ORDER BY event_date DESC $limitCondition ");
			$count = $searchText != '' ? $query->rowcount() : $conn->query("SELECT * FROM  tbl_events")->rowcount();
			$data = array();
			$data['Results'] = $query->fetchAll(PDO::FETCH_ASSOC);
			$data['Count'] = $count;
			return $data;	
		}
		public function Save(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
			
	
			$id  = (!isset($POST->Id))? 0 : $POST->Id;
			$name =  $POST->name;
			$content  = (!isset($POST->content))? 0 : $POST->content;
			$event_date  = (!isset($POST->event_date))? 0 : $POST->event_date;
			$latitude  = (!isset($POST->latitude))? 0 : $POST->latitude;
			$longitude  = (!isset($POST->longitude))? 0 : $POST->longitude;
			$address  = (!isset($POST->address))? 0 : $POST->address;
			$date_added = date('Y-m-d');
	

			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_events (name,content,latitude,longitude,address,date_added,event_date) VALUES(?,?,?,?,?,?,?)");
				$query->execute(array($name,$content,$latitude,$longitude,$address,$date_added,$event_date));
			}else{ 
				$query = $conn->prepare("UPDATE tbl_events SET name = ? , content = ? , latitude = ? , longitude = ? , address = ? , event_date = ? WHERE Id  = ? ");
				$query->execute(array($name,$content,$latitude,$longitude,$address,$event_date,$id));	
			}
		}
}
 $GLOBALS['EventRepo'] = new EventRepository();
?>