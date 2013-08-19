<?php
class cw_load
{
	function model($model, $data = null)
	{	
		if($data)
		{
	 		return new $model($data);
		}
		else
		{
			return new $model();
		}
	}
	
	function helper($helper, $data = null)
	{
		if($data)
		{
	 		return new $helper($data);
		}
		else
		{
			return new $helper();
		}
	}
	
	function libary($libary, $data = null)
	{
		if($data)
		{
	 		return new $libary($data);
		}
		else
		{
			return new $libary();
		}
	}
	
}
?>