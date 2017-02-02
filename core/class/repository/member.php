<?php 
class MemberRepository{
		public function Get($id){
			global $conn;
			$query = $conn->query("SELECT * FROM tbl_member  WHERE Id = '$id'");
			return $query->fetch(PDO::FETCH_ASSOC);	
		}
		public function Delete($id){
			global $conn;
			$query = $conn->prepare("DELETE FROM  tbl_member  WHERE Id = '$id'");
			$query->execute();	
		}
		public function DataList($searchText,$pageNo,$pageSize,$type){
			global $conn;
	
			$pageNo = ($pageNo - 1) * $pageSize; 
			$limitCondition = $pageNo == 0 && $pageSize == 0 ? '' : 'LIMIT '.$pageNo.','.$pageSize;
			
			$query = $conn->query("SELECT * FROM  tbl_member WHERE firstname LIKE '%$searchText%' AND MemberTypeId = '$type'  $limitCondition ");
			$count = $searchText != '' ? $query->rowcount() : $conn->query("SELECT * FROM  tbl_member")->rowcount();
			
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
			$firstname = $POST->firstname;
			$lastname = $POST->lastname;
			$middlename = $POST->middlename;
			$gender = (!isset($POST->gender)) ? 0 : $POST->gender;
			$email = (!isset($POST->email)) ? 0 : $POST->email;
			$mobile_no = (!isset($POST->mobile_no)) ? 0 : $POST->mobile_no;
			$address = (!isset($POST->address)) ? 0 : $POST->address;
			$username = (!isset($POST->username)) ? 0 : $POST->username;
			$password = (!isset($POST->password)) ? 0 : $POST->password;
			$date_registered = date('Y-m-d');

			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_member (firstname,lastname,middlename,gender,email,mobile_no,address,username,password,date_registered) VALUES(?,?,?,?,?,?,?,?,?,?)");
				$query->execute(array($firstname,$lastname,$middlename,$gender,$email,$mobile_no,$address,$username,$password,$date_registered));	
			}else{
				$query = $conn->prepare("UPDATE tbl_member SET firstname = ? , lastname = ? , middlename = ? , gender = ? ,  email = ? , mobile_no = ? , address = ?  , username = ? , password = ?   WHERE Id = ? ");
				$query->execute(array($firstname,$lastname,$middlename,$gender,$email,$mobile_no,$address,$username,$password,$id));	
			}

			
		}
		public function SignUp(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
		
			$id  = (!isset($POST->Id))? 0 : $POST->Id;
			$firstname = $POST->firstname;
			$lastname = $POST->lastname;
			$middlename = $POST->middlename;
			$gender = $POST->gender;
			$email = $POST->email;
			$mobile_no = $POST->mobile_no;
			$address = $POST->address;
			$username = $POST->username;
			$password = $POST->password;
			$date_registered = date('Y-m-d');

			if($id == 0) { 
				$query = $conn->prepare("INSERT INTO tbl_member (firstname,lastname,middlename,gender,email,mobile_no,address,username,password,date_registered) VALUES(?,?,?,?,?,?,?,?,?,?)");
				$query->execute(array($firstname,$lastname,$middlename,$gender,$email,$mobile_no,$address,$username,$password,$date_registered));	
			}else{
				$query = $conn->prepare("UPDATE tbl_member SET firstname = ? , lastname = ? , middlename = ? , gender = ? ,  email = ? , mobile_no = ? , address = ?  , username = ? , password = ?   WHERE Id = ? ");
				$query->execute(array($firstname,$lastname,$middlename,$gender,$email,$mobile_no,$address,$username,$password,$id));	
			}

			
		}
		public function ChangePassword(){
			global $conn;
			$request = \Slim\Slim::getInstance()->request();
			$POST = json_decode($request->getBody());
	
			$Id = (!isset($POST->Id)) ? 0 : $POST->Id;
			$cpassword =  $POST->cpassword;
			$newpassword =  $POST->newpassword;
			
			$count = $conn->query("SELECT * FROM tbl_member WHERE  password = '$cpassword' AND Id = '$Id' ")->rowcount();

			if($count > 0){
				$query = $conn->prepare("UPDATE tbl_member SET password = ? WHERE Id = ? ");
				$query->execute(array($newpassword,$Id));
			}else{
				 return 'cpFalse';
			}

			
		}
}
$GLOBALS['MemberRepo'] = new MemberRepository();
?>