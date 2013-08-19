<?php
class Load
{

	public function model($model)
	{
		$app = $GLOBALS['app'];
		require_once "apps/$app/model/$model.php";
		$modelname = $model;
		$modelname = str_replace("Model", "", $modelname);
		$HR =& getInstance();
		$HR->model = (object) null;
		$HR->model->$modelname = new $model();

	}

	function model2($model, $data = null)
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
	
	function libary2($libary, $data = null)
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

	public function library($libary, $data = null)
	{

		if(is_array($libary))
		{
			foreach ($libary as $key => $value) 
			{
				$this->library($value);
			}
		}else{
			$HR =& getInstance();
			$HR->lib = (empty($HR->lib) ? (object) null : $HR->lib);
			$lib_classname = 'hrl_'.$libary;
			if (class_exists($lib_classname)) 
			{
				if($data)
				{
					$HR->lib->$libary = new $lib_classname($data);
			 		return new $lib_classname($data);
				}
				else
				{
					$HR->lib->$libary = new $lib_classname();
			 		return new $lib_classname();
				}
			}else{
				echo $lib_classname;
			}
			return false;
		}
	}
	
	public function extern($app,$type,$class_name)
	{
		require_once('apps/'.$app.'/'.$type.'/'.$class_name);
	}
	
	public function extern_advanced($path)
	{
		require_once('apps/'.$path);
	}
	
	public function extern_adv($path)
	{
		return $this->extern_advanced($path);
	}
}
?>