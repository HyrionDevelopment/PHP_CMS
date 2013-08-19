<?php
class admin_pages_mysql
{
	function numrow_add1()
	{
		if(isset($_POST['title']) && isset($_POST['alias']) && isset($_POST['content']))
		{
			return true;
		}else{
			return false;
		}
	}
}