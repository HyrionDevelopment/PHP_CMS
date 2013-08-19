<?php
class Controller_CMS
{
	var $load;
	protected $uri;
	protected $input;

	function __construct()
	{
		require_once 'system/framework/hrf_load.php';
		$this->load = new load();
	}
}
?>