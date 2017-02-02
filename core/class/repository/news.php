<?php 
class NewsRepository{
		public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_news  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_news  WHERE Id = '$id'");
			$query->execute();	
		}
		public function DataList($searchText,$pageNo,$pageSize){
			global $conn;

			$pageNo = ($pageNo - 1) * $pageSize; 
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			$query = $conn->query("SELECT * FROM  tbl_news WHERE title LIKE '%$searchText%' ORDER BY news_date DESC $limitCondition ");
			$count = $searchText != '' ? $query->rowcount() : $conn->query("SELECT * FROM  tbl_news")->rowcount();
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
			$title =  $POST->title;
			$content  = (!isset($POST->content))? 0 : $POST->content;
			$news_date  = (!isset($POST->news_date))? 0 : $POST->news_date;
			$date_added = date('Y-m-d');
	

			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_news (title,content,news_date,date_added) VALUES(?,?,?,?)");
				$query->execute(array($title,$content,$news_date,$date_added));
			}else{ 
				$query = $conn->prepare("UPDATE tbl_news SET title = ? , content = ? , news_date = ? , date_added = ?  WHERE Id  = ? ");
				$query->execute(array($title,$content,$news_date,$date_added,$id));	
			}
		}
}
 $GLOBALS['NewsRepo'] = new NewsRepository();
?>