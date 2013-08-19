<?php
class admin_miniupdater_home
{
	function index()
	{
		$update_check = file_get_contents('http://cmswire.nl/miniupdater/v1.0.0_alpha/test.php');
		$decode = json_decode($update_check, true);
		if($decode['latest version'] != "1.0.0")
		{
			echo "Er zijn geen updates beschikbaar";
		}else{
			echo 'Er zijn updates beschikbaar, ga naar <a href="http://cmswire.nl">www.cmswire.nl</a> voor de download';
		}
	}
}