<?php
class CW_admin_dashboard
{
	var $mysql;
	function index()
	{
		require_once('../system/framework/class.mysql.php');
		require_once('../system/class.mysql_config.php');
		$this->mysql = new Mysql();
		
		if(isset($_SESSION['user_id']))
		{
			//if(isset($_SESSION['admin_session']))
			echo "q2";
			echo $this->test;
		}else{
			echo "q1";
		}
	}
}