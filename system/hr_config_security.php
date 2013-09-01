<?php
class hr_config_security {
	public function __construct($called_class=null)
	{
		$backtrace = debug_backtrace();
		$file = $backtrace[1]['file'];
		$file = explode('\\', $file);
		$counter = count($file);
		$file = $file[$counter-2].'/'.$file[$counter-1];
		if($file !== "system/db_init.php" && $called_class !== "Config")
		{
			die('Config security alert!!!'.$file);
		}
	}
}