<?php
class CW_admin_login
{

	function index()
	{
		if(isset($_SESSION['user_id']))
		{
			$user_id = $_SESSION['user_id'];
		}else{
			if($_SERVER['REQUEST_METHOD'] == "POST")
			{
				echo "hallo";
			}else{
				require_once("style/templates/login.php");
			}
		}
	}

	function login()
	{
		
	}
}