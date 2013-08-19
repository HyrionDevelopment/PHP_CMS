<?php
abstract class CW_admin_controller
{
	
	protected $admin_load;
	
	function construct()
	{
		$this->admin_load = new CW_admin_load();
	}
}