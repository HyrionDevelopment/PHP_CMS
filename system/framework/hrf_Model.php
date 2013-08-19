<?php
abstract class Model extends index
{
	protected $load;

	function __construct()
	{
		if($GLOBALS['redirect'] !== true)
		{
			$this->load = new Load();
			
			$segments = array();
			foreach(explode('/', substr($_SERVER['PHP_SELF'], strlen(substr($_SERVER['PHP_SELF'], 0, strlen('/' . $GLOBALS['root']))))) as $segment)
			{
				if(!empty($segment))
				{
					array_push($segments, $segment);
				}
			}
			$str = get_called_class();
			preg_match("/_/", $str, $match1);
			if(empty($match1))
			{
				$str2 = preg_replace("/([a-z0-9])([A-Z])/", '$1 $2', $str);  
				$ex = explode(" ", $str2);
			}else{
				$ex = explode("_", $str);
			}
			
			if($segments[1] != strtolower($ex[0]))
			{
				throw new Exception('Model loaded in an other APP without using a API. ERROR[501] ['.$segments[1].':'.$ex[0].']');
			}
			
			$ex_end = end($ex);
			
			if($ex_end != "model" && $ex_end != "Model")
			{
				echo end($ex);
				throw new Exception('Name Structure corrupt in Model: "'.get_called_class().'". Pleas read the manual about Name structures. ERROR[502]', 502);
			}
		}
	}
}
?>