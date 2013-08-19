<?php
class CW_admin_home
{
	function index()
	{
		require_once('../system/framework/class.mysql.php');
		require_once('../system/class.mysql_config.php');
		$this->mysql = new Mysql();
		
		if(isset($_SESSION['user_id']))
		{
			//if(isset($_SESSION['admin_session']))
			//echo "q2";
			//echo $this->test;
			echo "Dit is de admin homepage die nog niet klaar is.";
		}else{
			echo "q1";
		}
	}
}