<?php
class HR_Controller 
{
	private static $instance;

	public function __construct()
	{
		$this->load = new load();
		self::$instance =& $this;
	}

	public static function &getInstance()
	{
		return self::$instance;
	}
}
?>