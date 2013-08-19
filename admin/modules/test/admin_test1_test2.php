<?php
class Admin_test1_test2
{
	function test3()
	{
		$load_style = new CW_admin_loadstyle();
		echo $load_style->header();
		echo "Admin Pagina";
		echo $load_style->footer();
	}
}