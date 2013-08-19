<?php
class admin_pages_loaddata extends cw_admin_model
{
	function __construct()
    {
        parent::construct();
    }
	
	function add_get_username($user_id)
	{
		$dbh = DB_GetConnection();
		$sql = "SELECT username FROM users WHERE user_id=:user_id";
		$sth = $dbh->prepare($sql);
		$sth->bindValue('user_id', $user_id, PDO::PARAM_INT);
		$sth->execute();
		return $sth->fetch();
	}
	
	function edit_loadpage_data($page_id)
	{
		$dbh = DB_GetConnection();
		$sql = "SELECT * FROM hr_pages WHERE page_id=:page_id";
		$sth = $dbh->prepare($sql);
		$sth->bindValue('page_id', $page_id, PDO::PARAM_INT);
		$sth->execute();
		$fetch = $sth->fetch();
		return $fetch;

		/*$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		$row['page_content'] = stripslashes($row['page_content']);
		return $row;*/
	}
	
	function edit_get_username($user_id)
	{
		$dbh = DB_GetConnection();
		$sql = "SELECT username FROM hr_users WHERE user_id=:user_id";
		$sth = $dbh->prepare($sql);
		$sth->bindValue('user_id', $user_id, PDO::PARAM_INT);
		$sth->execute();

		return $sth->fetch();
	}
	
	function remove($page_id)
	{
		$sql = "SELECT * FROM pages WHERE page_id='".$mysql->escape($page_id)."'";
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
	}
	
	function home2()
	{
		//$mysql = new Mysql();
		$sql = "SELECT * FROM pages";
		$result = mysql_query($sql);
		$result_array = array();
		while($row = mysql_fetch_assoc($result))
		{
			$sql2 = "SELECT username FROM users WHERE user_id='".$mysql->escape($row['page_create_user_id'])."'";
			$result2 = mysql_query($sql2);
			$row2 = mysql_fetch_assoc($result2);
			$row['page_author'] = $row2['username'];
			
			$date = $row['page_date'];
			$row['page_date'] = date('d-m-Y h:i:s', strtotime($row['page_date']));
			
			array_push($result_array, $row);
		}
		return $result_array;
	}

	function home()
	{
		$sql = "SELECT * FROM HR_pages";
		$dbh = DB_GetConnection();
		$sth = $dbh->prepare($sql);
		$sth->execute();
		$row = $sth->fetchAll();
		$row2 = array();

		foreach ($row as $key1 => $value1) {
			$sql2 = "SELECT username FROM hr_users WHERE user_id=:user_id";
			$sth = $dbh->prepare($sql2);
			$sth->bindValue(":user_id", $value1['page_create_user_id'], PDO::PARAM_INT);
			$sth->execute();
			$fetch = $sth->fetch();

			$row[$key1]['page_create_date'] = date('d-m-Y H:i:s', $value1['page_create_date']);
			$row[$key1]['page_last_edit'] = date('d-m-Y H:i:s', $value1['page_last_edit']);

			if(empty($fetch))
			{
				$row[$key1]['page_author'] = "unknown";	
			}else{
				$row[$key1]['page_author'] = $fetch[0];
			}
			
		}

		//print_r($row);
		return $row;
	}

}