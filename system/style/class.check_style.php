<?php
class check_style
{
	
	public function default_style()
	{
		//Als de user geen style heeft ingesteld word deze functie geladen
		
		/*$sql = "SELECT * FROM ".DB_PREFIX."settings WHERE setting_name='default_style'";
		$result = mysql_query($sql); 
		if(mysql_num_rows($result) == 1)
		{
			$row =	mysql_fetch_assoc($result);
			return $row['setting_value'];
		}else{
			//
		}*/
		
		$dbh = DB_GetConnection();
		
		$sql = "SELECT * FROM ".DB_PREFIX."settings WHERE setting_name='default_style'";
		$sth = $dbh->prepare($sql);
		$sth->execute();
		
		$count = $sth->rowCount();
		
		if($count == 1)
		{
			$sth = $dbh->prepare($sql);
			$sth->execute();
			$row = $sth->fetch();
			return $row['setting_value'];
		}else{
			return 'default';
		}
		
	}
	
	private function user_style()
	{
		//Als de user een style heeft ingesteld word deze functie geladen
		if(isset($_SESSION['user_id']))
		{
			$this->user_id = $_SESSION['user_id'];
				
			$dbh = DB_GetConnection();
			$sql = "SELECT * FROM ".DB_PREFIX."userstyle WHERE user_id=:user_id";
			$sth = $dbh->prepare($sql);
			$sth->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
			$sth->execute();
			
			if($sth->rowCount() == 1)
			{
				$row = $sth->fetch();
				$sql2 = "SELECT * FROM ".DB_PREFIX."styles WHERE style_id=:style_id";
				$sth2 = $dbh->prepare($sql2);
				$sth2->bindValue(':style_id', $row['style_id'], PDO::PARAM_INT);
				$sth2->execute();		
				$row2 = $sth2->fetch();
				
				return $row2['style_name'];		
			}
			
		}
		return "stop";
	}
	
	public function load()
	{
		//Deze functie word ingeladen in een andere class
		if($this->user_style() == "stop")
		{
			$style = $this->default_style();
			return $style;
		}else{
			return $this->user_style();
		}
	}

	public function checkCache($style_name)
	{
		$path = 'cache/style/'.$style_name.'/';
		
		$folders = array(
			'css',
			'images',
			'js'
		); //Array with folders to check

		$files = array(
			'css/style.css',
			'../css.php'
		); //Array with files to check

		if($this->checkCacheFolders($path, $folders) == false)
		{
			return true;
		}elseif($this->checkCacheFiles($path, $files) == false)
		{
			return true;
		}elseif($this->checkCacheFiles($path, $files) == true)
		{
			return false;
		}
	}

	private function checkCacheFolders($path, $folders)
	{
		$return_count = 0;
		$array_count = count($folders);
		if (is_dir($path)) {
			foreach ($folders as $key1 => $folder)
			{
				if (is_dir($path.$folder.'/')) {
					$return_count = $return_count+1;
				}	
			}
		}
		echo  $array_count;
		if($return_count == $array_count)
		{
			return true;
		}
		return false;
	}

	private function checkCacheFiles($path, $files)
	{
		$return_count = 0;
		$array_count = count($files);
		if (is_dir($path)) {
			foreach ($files as $key1 => $file)
			{
				if (file_exists($path.$file)) {
					$return_count = $return_count+1;
				}	
			}
		}
		echo  $array_count;
		if($return_count == $array_count)
		{
			return true;
		}
		return false;
	}

	private function getFilename($path)
	{
		$array = explode('/', $path);
		$filename = end($array);
		return $filename;
	}

	public function refreshCache()
	{
		$pathCache = "cache/";
		$pathCacheStyle = $pathCache."style/";

		$pathStyleFolder = "styles";

		if(!is_dir($pathCache))
		{
			throw new Exception("Cache folder not found");
		}

		if(!is_writable($pathCache))
		{
			throw new Exception("Cache folder is not writable");
			exit();
		}

		if(!is_dir($pathCacheStyle))
		{
			$action = mkdir('cache/style', 0755) ? true : false;
		}

		if(!is_writable($pathCacheStyle))
		{
			throw new Exception("Cache folder is not writable");
		}
		$Style_array = array(
			"default"
		);
		$folders = array(
			'css',
			'images',
			'js'
		);


		foreach ($Style_array as $key1 => $value1) {
			if(!is_dir("cache/style/".$value1))
			{
				$action = mkdir("cache/style/".$value1) ? true : false;
			}

			$glob1 = glob("styles/".$value1.'/*');
			$glob2 = array();
			foreach ($folders as $key2 => $value2) {
				if(!is_dir("cache/style/".$value1."/".$value2))
				{
					$action = mkdir("cache/style/".$value1."/".$value2) ? true : false;
				}
				$glob2[$value2] = glob("styles/".$value1.'/'.$value2.'/*');
				$source = "styles/".$value1."/".$value2."/";
				$dest = "cache/style/".$value1."/".$value2."/";
				foreach ($glob2[$value2] as $key3 => $value3) {
					$filename = $this->getFilename($value3);
					copy($source.$filename, $dest.$filename);
				}
			}
		}

	}

}
?>
