<?php
class hr_permissions
{

	function get_rank_id()
	{
	
		if(isset($_SESSION['user_id']) && isset($_SESSION['session_code']))
		{
			$dbh = DB_GetConnection();
			$sql = "SELECT rank_id FROM ".DB_PREFIX."user_ranks WHERE user_id=:user_id";
			
			$sth = $dbh->prepare($sql);
			$sth->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
			$sth->execute();
			
			$row1 = $sth->fetch();
			
			$rank_id = array(0 => $row1);
			
		}else{
			$rank_id = Array (0 => Array ( 'rank_id' => 1 ));
		}
		return $rank_id;
	}

	public function HR_Check_function_permissions($app,$class,$function)
	{
		/*
		Permission types:
			0: IP
			1: User
			2: Group/Rank
		*/
		$CLIENT_IP = $_SERVER['REMOTE_ADDR'];
		
		//IF IS TRUE THEN IP HAVE NO ISSUES
		//Maybe not access, Look first in default table
		
		if($this->HR_IP_PERMISSION_CHECK($CLIENT_IP,$app,$class,$function) == 2)
		{
			if($this->HR_CHECK_DEFAULT_PERMISSIONS($app,$class,$function) == 1)
			{
				return true;
			}else{
				return false;
			}
		}elseif($this->HR_IP_PERMISSION_CHECK($CLIENT_IP,$app,$class,$function) == 1)
		{
			echo "true";
			return true;
		}elseif($this->HR_IP_PERMISSION_CHECK($CLIENT_IP,$app,$class,$function) == 0)
		{
			return false;
		}
	}
	
	private function HR_IP_PERMISSION_CHECK($CLIENT_IP,$app,$class,$function)
	{
		$dbh = DB_GetConnection();
		
		$IP_SELECT_SQL = "SELECT * FROM ".DB_PREFIX."permissions WHERE Permission_type=0 AND Permission_value=:CLIENT_IP";
		
		$sth = $dbh->prepare($IP_SELECT_SQL);
		$sth->bindValue(':CLIENT_IP', $CLIENT_IP, PDO::PARAM_STR);
		$sth->execute();
		
		$row1 = $sth->fetchAll();
		if(empty($row1))
		{
			return 2;
		}else{
			
			/*
			echo "<pre>";
			print_r($row1);
			echo "</pre>";
			*/
			
			//echo "count:".count($row1);
			if(count($row1) > 1)
			{
				//ERROR LOG??
				//echo "grooter...";
			}
			
			$permission_id = $row1[0]['permission_id'];
			//echo $app."+".$class."+".$function;
			
			$Permission_sql1 = "SELECT * FROM ".DB_PREFIX."permissions2 WHERE permission_id=:permission_id AND App_name=:app AND Class_name=:class AND Function_name=:function";
			
			$sth2 = $dbh->prepare($Permission_sql1);
			$sth2->bindValue(':permission_id', $permission_id, PDO::PARAM_INT);
			$sth2->bindValue(':app', $app, PDO::PARAM_STR);
			$sth2->bindValue(':class', $class, PDO::PARAM_STR);
			$sth2->bindValue(':function', $function, PDO::PARAM_STR);
			$sth2->execute();
			
			$row2 = $sth2->fetchAll();
			
			/*
			echo "<pre>";
			print_r($row2);
			echo "</pre>";
			*/
			
			if(empty($row2))
			{
				return 2;
			}else{
				//echo "count2:".count($row2);
				if(count($row2) > 1)
				{
					//ERROR LOG??
					//echo "grooter2...";
				}
				
				if($row2[0]['Access'] == '1')
				{
					
					return 1;
				}else{
					return 0;
				}
			}
		}
		
		return true;
	}

	public function HR_CHECK_DEFAULT_PERMISSIONS($app,$class,$function)
	{
		$dbh = DB_GetConnection();
		
		$check_sql  = "SELECT * FROM ".DB_PREFIX."default_permissions WHERE App_name=:app AND Class_name=:class AND Function_name=:function";
		$check_sql2 = "SELECT * FROM ".DB_PREFIX."default_permissions WHERE App_name=:app AND Class_name=:class AND Function_name='*' OR App_name=:app AND Class_name='*' AND Function_name='*'";
		//$check_sql2 = "SELECT * FROM default_permissions WHERE App_name=:app AND Class_name=:class AND Function_name='*' OR Class_name='*'";
		
		$sth = $dbh->prepare($check_sql);
		$sth->bindValue(":app", $app, PDO::PARAM_STR);
		$sth->bindValue(":class", $class, PDO::PARAM_STR);
		$sth->bindValue(":function", $function, PDO::PARAM_STR);
		$sth->execute();
		$row1 = $sth->fetch();
		$sth = null;
		
		/*
		echo "<pre>";
			print_r($row1);
		echo "</pre>";
		*/
		if(empty($row1))
		{
			$sth = $dbh->prepare($check_sql2);
			$sth->bindValue(":app", $app, PDO::PARAM_STR);
			$sth->bindValue(":class", $class, PDO::PARAM_STR);
			$sth->execute();
			$row2 = $sth->fetch();
			$sth = null;
			
			/*
			echo "<pre>";
			print_r($row2);
			echo "</pre>";
			*/
			
			if($row2['Access'] == 1)
			{
				return 1;
			}elseif($row2['Access'] == 0){
				return 0;
			}
		}else{
			if($row1['Access'] == 1)
			{
				return 1;
			}elseif($row1['Access'] == 0){
				return 0;
			}
		}
	}
}