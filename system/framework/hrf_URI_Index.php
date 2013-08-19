<?php
class URI_index
{
	
	function begin()
	{
		$segments = array();
		foreach(explode('/', substr($_SERVER['PHP_SELF'], strlen(substr($_SERVER['PHP_SELF'], 0, strlen('/' . $GLOBALS['root']))))) as $segment)
		{
			if(!empty($segment))
			{
				array_push($segments, $segment);
			}
		}
		return $this->check_all($segments);
	}
	
	function check_all($segments)
	{
		$uri_a = array();
		
		if($this->check_app($segments) == false)
		{
			return false;
		}

		if($this->check_seg1($segments,$uri_a))
		{
			$app = $segments[1];
			$uri_a['app'] = $app;
			
			if($this->check_seg2($segments,$uri_a))
			{
				$controller = $this->check_seg2($segments,$uri_a);
				$uri_a['controller'] = $controller;
				if($this->check_seg3($segments,$uri_a))
				{
					$actie = $this->check_seg3($segments,$uri_a);
					$uri_a['actie'] = $actie;
				}			
			}
		}else{
			$uri_a['app'] 		= 'cms';
			$uri_a['controller'] 	= 'load_page';
			$uri_a['actie'] 		= 'home';
		}
		return $uri_a;
	}
	
	function check_seg1($segments,$uri_a)
	{
		if(isset($segments[1]) && !empty($segments[1]))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function check_seg2($segments,$uri_a)
	{
		if(isset($segments[2]) && !empty($segments[2]))
		{
			$controller = $segments[2];
		}
		else
		{
			$controller = 'index';
		}
		return $controller;
	}
	
	function check_seg3($segments,$uri_a)
	{
		if(isset($segments[3]) && !empty($segments[3]))
		{
			$actie = $segments[3];
		}
		else
		{
			$actie = 'index';
		}
		return $actie;
	}
	
	function check_app($segments)
	{
		if(isset($segments[1]))
		{
			if($segments[1] == "login")
			{
				return false;
			}
			if($segments[1] == "ucp")
			{
				return false;
			}
			if($segments[1] == "homepage")
			{
				return false;
			}
			if($segments[1] == "page")
			{
				return false;
			}
		}
		return true;
	}
	
	function get_segments()
	{
		$segments = array();
		foreach(explode('/', substr($_SERVER['PHP_SELF'], strlen(substr($_SERVER['PHP_SELF'], 0, strlen('/' . $GLOBALS['root']))))) as $segment)
		{
			if(!empty($segment))
			{
				array_push($segments, $segment);
			}
		}
		return $segments;
	}
}