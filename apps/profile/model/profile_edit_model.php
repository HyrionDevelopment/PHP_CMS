<?php
class profile_edit_model extends Model
{
	function __construct()
    {
        parent::construct();
		
    }
		
	function get_profile_data($user_id)
	{
		$dbh = DB_GetConnection();
		$sql = "SELECT * FROM ".DB_PREFIX."profile";
		$sth = $dbh->prepare($sql);
		$sth->execute();
		$result = $sth->fetchAll();
		$result_array = array();
		foreach($result as $row)
		{
			//$sql2 = "SELECT * FROM profile_data WHERE user_id=".$this->mysql->escape($user_id)." AND profile_id=".$this->mysql->escape($row['profile_id']);
			$sql2 = "SELECT * FROM ".DB_PREFIX."profile_data WHERE user_id=:user_id AND profile_id=:profile_id";
			$sth2 = $dbh->prepare($sql2);
			$sth2->bindValue(':user_id', $user_id, PDO::PARAM_INT);
			$sth2->bindValue(':profile_id', $row['profile_id'], PDO::PARAM_INT);
			$sth2->execute();
			$row2 = $sth2->fetch();
			if($row2['profile_data_value'] != NULL || $row2['profile_data_value'] != '')
			{
				$row['profile_data_value'] = $row2['profile_data_value'];
			}else{
				$row['profile_data_value'] = '';
			}
			
			if($row['required'] != 1)
			{
				$row['required2'] = "";
			}else{
				$row['required2'] = "*";
			}
			
			array_push($result_array, $row);
		}
		return $result_array;
	}
	
	/*
	function create_profile($user_id)
	{
		foreach($_POST as $key => $value) {
			if($key != "button")
			{
				//echo $key.":".$value."<br />";
				$sql_profile = "SELECT * FROM profile WHERE profile_field='".$this->mysql->escape($key)."'";
				$result1 = mysql_query($sql_profile);
				$row1 = mysql_fetch_assoc($result1);
				
				$select_sql = "SELECT * FROM profile_data WHERE user_id=".$this->mysql->escape($user_id)." AND profile_id='".$this->mysql->escape($row1['profile_id'])."'";
				if($this->mysql->num_row($select_sql, $data=null) < 1)
				{
					$sql = "INSERT INTO profile_data (user_id,profile_id,profile_data_value)VALUES(".$this->mysql->escape($user_id).",".$this->mysql->escape($row1['profile_id']).",'".$this->mysql->escape($value)."')";
					$this->mysql->query($sql, $data=null);
				}
				
			}
		}
		return true;
		//$sql = "INSERT INTO profile_data (user_id,profile_id,profile_data_value)VALUES(".$this->mysql->escape($user_id).",".$this->mysql->escape($_POST[]).",'".$this->mysql->escape($_POST[])."')";
	}
	*/
	
	function create_profile($user_id)
	{
		$dbh = DB_GetConnection();
		foreach($_POST as $key => $value) {
			if($key != "button")
			{
				//echo $key.":".$value."<br />";
				//$sql_profile = "SELECT * FROM profile WHERE profile_field='".$this->mysql->escape($key)."'";
				$sql_profile = "SELECT * FROM ".DB_PREFIX."profile WHERE profile_field=:key";
				$sth = $dbh->prepare($sql_profile);
				$sth->bindValue(':key', $key, PDO::PARAM_INT);
				$sth->execute();
				
				$row1 = $sth->fetch();
				$sth = NULL;
				
				//$select_sql = "SELECT * FROM profile_data WHERE user_id=".$this->mysql->escape($user_id)." AND profile_id='".$this->mysql->escape($row1['profile_id'])."'";
				$select_sql = "SELECT * FROM ".DB_PREFIX."profile_data WHERE user_id=:user_id AND profile_id=:profile_id";
				$sth = $dbh->prepare($select_sql);
				$sth->bindValue(':user_id', $user_id, PDO::PARAM_INT);
				$sth->bindValue(':profile_id', $row1['profile_id'], PDO::PARAM_INT);
				$sth->execute();
				$count = $sth->rowCount();
				$sth = NULL;
				if($count < 1 && $row1['profile_id'] != NULL)
				{
					//$sql = "INSERT INTO profile_data (user_id,profile_id,profile_data_value)VALUES(".$this->mysql->escape($user_id).",".$this->mysql->escape($row1['profile_id']).",'".$this->mysql->escape($value)."')";
					$sql = "INSERT INTO ".DB_PREFIX."profile_data (user_id,profile_id,profile_data_value)VALUES(:user_id, :profile_id, :value)";
					$sth = $dbh->prepare($sql);
					$sth->bindValue(':user_id', $user_id, PDO::PARAM_INT);
					$sth->bindValue(':profile_id', $row1['profile_id'], PDO::PARAM_INT);
					$sth->bindValue(':value', $value, PDO::PARAM_STR);
					$sth->execute();
//					$this->mysql->query($sql, $data=null);
					echo "1";
				}
				
			}
		}
		return true;
		//$sql = "INSERT INTO profile_data (user_id,profile_id,profile_data_value)VALUES(".$this->mysql->escape($user_id).",".$this->mysql->escape($_POST[]).",'".$this->mysql->escape($_POST[])."')";
	}
	
	function edit_profile($user_id)
	{
		$dbh = DB_GetConnection();
		$check_array = array();
		//print_r($_POST);
		foreach($_POST as $key => $value) 
		{
			
			//$sql_profile = "SELECT * FROM profile WHERE profile_field='".$this->mysql->escape($key)."'";
			//$result1 = mysql_query($sql_profile);
			//$row1 = mysql_fetch_assoc($result1);
			
			$sql_profile = "SELECT * FROM ".DB_PREFIX."profile WHERE profile_field=:key";
			$sth = $dbh->prepare($sql_profile);
			$sth->bindValue(':key', $key, PDO::PARAM_INT);
			$sth->execute();
			
			if($sth->rowCount() > 0)
			{
				
				$row1 = $sth->fetch();
				$sth = NULL;
				
				$select_sql = "SELECT * FROM ".DB_PREFIX."profile_data WHERE user_id=:user_id AND profile_id=:profile_id";
				$sth = $dbh->prepare($select_sql);
				$sth->bindValue(':user_id', $user_id, PDO::PARAM_INT);
				$sth->bindValue(':profile_id', $row1['profile_id'], PDO::PARAM_INT);
				$sth->execute();
				$count = $sth->rowCount();
				$sth = NULL;
				if($count == 1)
				{	
					$continu = 0;
					if($row1['required'] == 1)
					{
						if($value == '' || empty($value))
						{
							$check_array[] = 1;
						}else{
							$continu = 1;
						}
					}else{
						$continu = 1;
					}
					if($continu == 1)
					{
						$sql = "UPDATE ".DB_PREFIX."profile_data SET profile_data_value=:value WHERE user_id=:user_id AND profile_id=:profile_id";
						$sth = $dbh->prepare($sql);
						$sth->bindParam(':value', $value, PDO::PARAM_STR);	
						$sth->bindValue(':user_id', $user_id, PDO::PARAM_INT);
						$sth->bindValue(':profile_id', $row1['profile_id'], PDO::PARAM_INT);				
						$sth->execute();
					}
				}else{
					$continu = 0;
					if($row1['required'] == 1)
					{
						if($value == '' || empty($value))
						{
							$check_array[] = 1;
						}else{
							$continu = 1;
						}
					}else{
						$continu = 1;
					}
					if($continu == 1)
					{
						$sql = "INSERT INTO ".DB_PREFIX."profile_data (user_id,profile_id,profile_data_value)VALUES(:user_id, :profile_id, :value)";
						$sth = $dbh->prepare($sql);
						$sth->bindParam(':value', $value, PDO::PARAM_STR);	
						$sth->bindValue(':user_id', $user_id, PDO::PARAM_INT);
						$sth->bindValue(':profile_id', $row1['profile_id'], PDO::PARAM_INT);				
						$sth->execute();
					}
				}
			}
		}
		//print_r($check_array);
		$eentrue=0;
		foreach($check_array as $value){
			$eentrue=$eentrue|$value;
		}
		if($eentrue){
			return 'forgot';
		}else{
			return 'success';	
		}
	}
	
	/*function check_profile($user_id)
	{
		$sql_profile = "SELECT * FROM profile";
		$result1 = mysql_query($sql_profile);
		$check_array = array();
		while($row1 = mysql_fetch_assoc($result1))
		{
			$select_sql = "SELECT * FROM profile_data WHERE user_id=".$this->mysql->escape($user_id)." AND profile_id='".$this->mysql->escape($row1['profile_id'])."'";
			$result2 = $this->mysql->query($select_sql, $data=null);
			$row2 = mysql_fetch_assoc($result2);
			if($this->mysql->num_row($select_sql, $data=null) > 0)
			{
				//echo "1";
				//echo $this->mysql->num_row($select_sql, $data=null);
				if($row2['profile_data_value'] == '' || empty($row2['profile_data_value']))
				{
					$check_array[] = 1;
				}
			}else{
				$check_array[] = 1;
			}
		}
		$eentrue=0;
		foreach($check_array as $value){
			$eentrue=$eentrue|$value;
		}
		if($eentrue){
			return 0;
		}else{
			return 1;	
		}
	}*/
	
	function check_profile($user_id)
	{
		$dbh = DB_GetConnection();
		$sql_profile = "SELECT * FROM profile";
		$sth = $dbh->query($sql_profile);
		$result1 = $sth->fetchAll();
		$sth = NULL;
		$check_array = array();
		foreach($result1 as $row1)
		{
			$select_sql = "SELECT * FROM profile_data WHERE user_id=:user_id AND profile_id=:profile_id";
			$sth = $dbh->prepare($select_sql);
			$sth->bindValue(':user_id', $user_id, PDO::PARAM_INT);
			$sth->bindValue(':profile_id', $row1['profile_id'], PDO::PARAM_INT);
			$sth->execute();
			
			$row2 = $sth->fetch();
			$count1 = $sth->rowCount();
			$sth = NULL;
			if($count1 > 0)
			{
				//echo "1";
				if($row2['profile_data_value'] == '' || empty($row2['profile_data_value']))
				{
					$check_array[] = 1;
				}
			}else{
				$check_array[] = 1;
			}
		}
		$eentrue=0;
		foreach($check_array as $value){
			$eentrue=$eentrue|$value;
		}
		if($eentrue){
			return 0;
		}else{
			return 1;	
		}
	}
}