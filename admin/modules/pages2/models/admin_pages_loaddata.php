<?php
class admin_pages_loaddata extends cw_admin_model
{
	
	function __construct()
    {
        parent::construct();
    }
	
	function add_get_username($user_id)
	{
		//$mysql = new Mysql();
		$sql = "SELECT username FROM users WHERE user_id='".$mysql->escape($user_id)."'";
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		return $row;
	}
	
	function edit_loadpage_data($page_id)
	{
		//$mysql = new Mysql();
		$sql = "SELECT * FROM pages WHERE page_id='".$mysql->escape($page_id)."'";
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		$row['page_content'] = stripslashes($row['page_content']);
		return $row;
	}
	
	function edit_get_username($user_id)
	{
		//$mysql = new Mysql();	
		$sql = "SELECT username FROM users WHERE user_id='".$mysql->escape($user_id)."'";
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		return $row;
	}
	
	function remove($page_id)
	{
		$sql = "SELECT * FROM pages WHERE page_id='".$mysql->escape($page_id)."'";
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
	}
	
	function home()
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

}