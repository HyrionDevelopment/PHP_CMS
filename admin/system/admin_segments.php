<?php
class CW_admin_segments
{
	function get_segments()
	{
		require_once('../system/settings.php');
		$setting = new settings();
		$segments = array();
		foreach(explode('/', substr($_SERVER['PHP_SELF'], strlen(substr($_SERVER['PHP_SELF'], 0, strlen('/' . $setting->path_url().'admin/'))))) as $segment)
		{
			if(!empty($segment))
			{
				array_push($segments, $segment);
			}
		}
		return $segments;
	}
}