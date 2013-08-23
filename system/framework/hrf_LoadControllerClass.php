<?php
class Load_controller_class
{
	private $app;
	private $class;
	private $function;
	
	public function __construct($app, $class, $function) 
	{
		$this->app = $app;
		$this->class = $class;
		$this->function = $function;
	}

	public function checkActionExist()
	{
		$class = $this->app.'_'.$this->class;
		if (class_exists($class)) {
			$class_obj = new $class();
			$method_var = array($class_obj, $this->function);
			if(is_callable($method_var))
				return true;
		}

		return false;
	}
	
	public function load_function()
	{
		$this->class = $this->app . '_' . $this->class; 
		if (class_exists($this->class))
		{
			$class_obj = new $this->class();
			
			if(!method_exists($class_obj, $this->function) && !method_exists($class_obj, '__call'))
			{
				throw new Exception('Opgeroepen actie "' . $this->class . '->' . $this->function . '" bestaat niet. #404');
			}
			else
			{
				$function = $this->function;
				$class_obj->$function();
			}
		}
		else
		{
			throw new Exception('Class onbekend: ' . $this->class . ' #404');
		}
	}	
}