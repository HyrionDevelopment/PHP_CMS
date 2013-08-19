<?php
class Helper_Uri
{
	private $segments;

	function __construct()
	{
		$this->segments = array();
		foreach(explode('/', substr($_SERVER['PHP_SELF'], strlen(substr($_SERVER['PHP_SELF'], 0, strlen('/' . $GLOBALS['root']))))) as $segment)
		{
			if(!empty($segment))
			{
				array_push($this->segments, $segment);
			}
		}
	}
	function uri_segment($n)
	{
		if(isset($this->segments))
		{
			if(isset($this->segments[$n]))
			{
				return $this->segments[$n];
			}else{
				return null;
			}
		}
		else
		{
			return null;
		}
	}

	function uri_to_assoc($n = 3, $var = null)
	{
		$array = array();
		$key_cache = null;
		$begin = $n;
		for($i = 0; $i < (count($this->segments) - $begin); $i++, $n++)
		{
			$even = $i%2;
			if(!$even)
			{
				$key_cache = $this->segments[$n];
			}
			else
			{
				$array[$key_cache] = $this->segments[$n];
				$key_cache = null;
			}
		}
		if($key_cache)
		{
			$array[$key_cache] = null;
		}

		if(!$var) return $array;
		elseif(isset($array[$var]))
			return $array[$var];
		else
			return false;
	}
}
?>