<?php
class m_CMS_LOGIN extends Model_CMS
{
	function gen_code($user_id)
	{
		$dbh = DB_GetConnection();
		$array = array();
		
		$rand1 = substr(md5(uniqid(rand(), true)), 0, 12);
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$select = "SELECT * FROM ".DB_PREFIX."sessions WHERE user_id=:user_id";
		$sth1 = $dbh->prepare($select);
		$sth1->bindValue(":user_id", $user_id, PDO::PARAM_STR);
		$sth1->execute();
		
		if($sth1->rowCount() != 1)
		{
			//$sql = "INSERT INTO sessions (user_id, session_code, ip, timestamp) VALUES ('".$this->mysql->escape($user_id)."', '".$this->mysql->escape($rand1)."', '".$this->mysql->escape($ip)."', '".$this->mysql->escape(strtotime(date('Y-m-d H:i:s')))."' )";
			$sql = "INSERT INTO ".DB_PREFIX."sessions (user_id, session_code, ip, timestamp) VALUES (:user_id, :session_code, :ip, :timestamp)";
			$sth2 = $dbh->prepare($sql);
			$sth2->bindValue(":user_id", $user_id, PDO::PARAM_INT);
			$sth2->bindValue(":session_code", $rand1, PDO::PARAM_STR);
			$sth2->bindValue(":ip", $ip, PDO::PARAM_STR);
			$sth2->bindValue(":timestamp", strtotime(date('Y-m-d H:i:s')), PDO::PARAM_INT);
			$sth2->execute();
		}else{
			//$sql = "UPDATE sessions SET session_code='".$this->mysql->escape($rand1)."', ip='".$this->mysql->escape($ip)."', timestamp='".$this->mysql->escape(strtotime(date('Y-m-d H:i:s')))."' WHERE user_id=".$this->mysql->escape($user_id);
			$sql = "UPDATE ".DB_PREFIX."sessions SET session_code=:session_code, ip=:ip, timestamp=:timestamp WHERE user_id=:user_id";
			$sth2 = $dbh->prepare($sql);
			$sth2->bindValue(":session_code", $rand1, PDO::PARAM_STR);
			$sth2->bindValue(":ip", $ip, PDO::PARAM_STR);
			$sth2->bindValue(":timestamp", strtotime(date('Y-m-d H:i:s')), PDO::PARAM_INT);
			$sth2->bindValue(":user_id", $user_id, PDO::PARAM_STR);
			$sth2->execute();
		}
		
		
		//$this->mysql->query($sql, $data=null);
		return $rand1;
	}
	
	function check_login($user,$pass)
	{
		$dbh = DB_GetConnection();
		
		$sql = "SELECT * FROM ".DB_PREFIX."users WHERE username=:user AND password=:pass";
		
		$sth = $dbh->prepare($sql);
		$sth->bindValue(":user", $user, PDO::PARAM_STR);
		$sth->bindValue(":pass", $pass, PDO::PARAM_STR);
		$sth->execute();
		
		//$select = "SELECT * FROM users WHERE username='".$this->mysql->escape($user)."' AND password='".$this->mysql->escape($pass)."'";
		if($sth->rowCount() == 1)
		{
			return true;
		}
		return false;
	}
	
	function get_userid($user,$pass)
	{
		$dbh = DB_GetConnection();
		$select = "SELECT user_id FROM ".DB_PREFIX."users WHERE username=:user AND password=:pass";
		$sth = $dbh->prepare($select);
		$sth->bindValue(":user", $user, PDO::PARAM_STR);
		$sth->bindValue(":pass", $pass, PDO::PARAM_STR);
		$sth->execute();
		
		if($sth->rowCount() == 1)
		{
			$row = $sth->fetch();
			return $row['user_id'];
		}
		return false;
	}
	
	function start_session($user_id, $session_code)
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		$_SESSION['user_id'] = $user_id;
		$_SESSION['session_code'] = $session_code;
		$_SESSION['ip'] = $ip;
		if(!empty($ip) && !empty($user_id) && !empty($session_code))
		{
			if(!empty($_SESSION['ip']) && !empty($_SESSION['user_id']) && !empty($_SESSION['session_code']))
			{
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
		//echo "ID: ".$_SESSION['user_id']." Session_code: ".$_SESSION['session_code']." IP: ".$_SESSION['ip'];
	}
}