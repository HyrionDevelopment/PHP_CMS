<?php
class app_folders
{
	var $app_dir = "apps";
	var $folders_a = array();
	var $files_a = array();
	
	function begin()
	{
		$folders = glob($this->app_dir."/*",GLOB_ONLYDIR);
		try
		{
			if($this->count_folders())
			{
				foreach($folders as $folder)
				{
					array_push($this->folders_a,$folder);
				}
			}else{
				throw new Exception('No Dirs');
			}
		}catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
		return $this->replace($this->files_a);	
	}
	
	function count_folders()
	{
		$folders = glob($this->app_dir."/*",GLOB_ONLYDIR);
		if(count($folders) > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function replace()
	{		
		foreach ($this->folders_a as &$file1) 
		{
			$path_file = $file1."/app.cfg";
			$file2 = str_replace($this->app_dir."/",'',$file1);
			if (file_exists($path_file)) 
			{
				$this->files_a[$file2] = 1;
			} else {
				$this->files_a[$file2] = 0;
			}
		}
		return $this->files_a;
	}
}