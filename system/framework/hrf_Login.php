<?php
class HRF_Login
{	
	public $db;
	public function __construct()
	{
		if(!DEFINED('DB_AUTO_CONNECT'))
		{
			$this->db = db_connect();
		}
	}
	
	/*public function secure_login()
	{
		if($this->check_session() == true)
		{
			$end = '';
			
			$ip = $_SERVER['REMOTE_ADDR'];
			$select = "SELECT * FROM sessions WHERE user_id=".$this->db->real_escape_string($_SESSION['user_id']);
			$result1 = $this->db->query($select);
			$row1 = $result1->fetch_assoc();
			$get_date = date('Y-m-d', $row1['timestamp']);
			$current_date = date('Y-m-d');
			$get_time=$row1['timestamp'];
			$current_time = time();
			$get_time2=$get_time+(60*60*2);
			if($_SESSION['ip'] == $ip
				&&
				$result1->num_rows == 1
				&&
				md5($row1["session_code"]) == $_SESSION['session_code']
				&&
				$get_date == $current_date
				&&
				$current_time<$get_time2)
			{
				$end = true;
			}else{
				$end = false;
			}
		}else{
			$end = 2;
		}
		
		if($end == false)
		{
			$this->logout();
			return 'j';
		}elseif($end == 2){
			return 'q';
		}elseif($end == true){
			session_regenerate_id();
			$this->update_session();
			return 'r';
		}
	}*/
	
	public function secure_login()
	{		
		$dbh = DB_GetConnection();
		if($this->check_session() == true)
		{
			$end = '';
			
			$ip = $_SERVER['REMOTE_ADDR'];
			$user_id = $_SESSION['user_id'];
			$select = "SELECT * FROM hr_sessions WHERE user_id=:user_id";
			$sth = $dbh->prepare($select);
			$sth->bindValue(':user_id', $user_id, PDO::PARAM_INT);
			$sth->bindValue(':user_id', $user_id, PDO::PARAM_INT);
			$sth->execute();
			$row1 = $sth->fetch();
			

			$get_date = date('Y-m-d', $row1['timestamp']);
			$current_date = date('Y-m-d');
			$get_time=$row1['timestamp'];
			$current_time = time();
			$get_time2=$get_time+(60*60*2);
			if($_SESSION['ip'] == $ip
				&&
				$sth->rowCount() == 1
				&&
				md5($row1["session_code"]) == $_SESSION['session_code']
				&&
				$get_date == $current_date
				&&
				$current_time<$get_time2)
			{
				$end = 1;
			}else{
				$end = 3;
			}
		}else{
			$end = 2;
		}
		
		if($end == 1){
			session_regenerate_id();
			$this->update_session();
			return 'r';
		}elseif($end == 3)
		{
			$this->logout();
			return 'j';
		}elseif($end == 2){
			return 'q';
		}
		
	}
	
	function check_session()
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		if(isset($_SESSION['user_id']))
		{
			return true;
		}else{
			return false;
		}
	}
	
	private function update_session()
	{
		$dbh = DB_GetConnection();
		$user_id = $_SESSION['user_id'];
		$date = strtotime(date('Y-m-d H:i:s'));
		
		$sql = "UPDATE hr_sessions SET timestamp=:timestamp WHERE user_id=:user_id";
		$sth = $dbh->prepare($sql);
		$sth->bindValue(':timestamp', $date, PDO::PARAM_INT);
		$sth->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		$sth->execute();
	}
	
	function logout()
	{
		$setting = new settings();
		$_SESSION = array(); //destroy all of the session variables
		session_destroy();
		header("location: ".$setting->baseURL());
	}
}