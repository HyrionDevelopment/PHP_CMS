<?php
require_once('system/framework/class.mysql.php');
class Login_helper
{
	public $mysql;
	function check_login()
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		if(isset($_SESSION['ip'], $_SESSION['user_id'], $_SESSION['session_code']))
		{
			return true;
		}else{
			return false;
		}
	}
	
	function must_login3()
	{
		$this->mysql = new Mysql();
		
		$ip = $_SERVER['REMOTE_ADDR'];
		if($this->check_login() == true)
		{
			if($_SESSION['ip'] == $ip)
			{
				$select = "SELECT * FROM sessions WHERE user_id=".$_SESSION['user_id'];
				if($this->mysql->num_row($select) == 1)
				{
					$row1 = $this->mysql->assoc($select);
					if(md5($row1["session_code"]) == $_SESSION['session_code'])
					{
						$get_date = date('Y-m-d', $row1['timestamp']);
						$current_date = date('Y-m-d');
						if($get_date == $current_date)
						{
							$get_time=$row1['timestamp'];
							$current_time = time();
							$get_time2=$get_time+(60*60*2);
														
							if($current_time<$get_time2)
							{
								$this->update_session();
								return true;
							}
						}
					}
				}
			}
		}else{
			return false;
		}
		
		
		
	}
	
	function must_login2()
	{
		$this->mysql = new Mysql();
		if($this->check_login() == true)
		{
			$ip = $_SERVER['REMOTE_ADDR'];
			$select = "SELECT * FROM sessions WHERE user_id=".$_SESSION['user_id'];
			$row1 = $this->mysql->assoc($select);
			$get_date = date('Y-m-d', $row1['timestamp']);
			$current_date = date('Y-m-d');
			$get_time=$row1['timestamp'];
			$current_time = time();
			$get_time2=$get_time+(60*60*2);
		
			if($_SESSION['ip'] == $ip
				&&
				$this->mysql->num_row($select) == 1
				&&
				md5($row1["session_code"]) == $_SESSION['session_code']
				&&
				$get_date == $current_date
				&&
				$current_time<$get_time2)
			{
				return true;
			}
		}else{
			return 2;
		}
		
	}	
	
	public function must_login()
	{
		if($this->must_login2() == false)
		{
			return $this->logout();
		}elseif($this->must_login2() == 2){
			return false;
		}else{
			session_regenerate_id();
			$this->update_session();
			return false;
		}
	}
	
	private function update_session()
	{
		$sql = "UPDATE sessions SET timestamp='".$this->mysql->escape(strtotime(date('Y-m-d H:i:s')))."' WHERE user_id=".$this->mysql->escape($_SESSION['user_id']);
		$this->mysql->query($sql, $data=null);
	}
	
	function logout()
	{
		$_SESSION = array(); //destroy all of the session variables
		session_destroy();
		header("location: /cmswire/alpha2/index.php/ucp/login/");
		
	}
}