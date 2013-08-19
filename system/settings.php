<?php
class Settings
{

	function __construct()
	{
		//$this->mysql = new Mysql();
	}
	
	function get_setting_value($setting_name)
	{
		return $this->GetSettingValue($setting_name);
	}
		
	function base_url()
	{
		return $this->BaseUrl();
	}
	
	function path_url()
	{
		$dbh = DB_GetConnection();
		$sql = "SELECT * FROM hr_settings WHERE setting_name=:val";
		
		$sth = $dbh->prepare($sql);
		$sth->bindValue(":val", 'path_url', PDO::PARAM_STR);
		$sth->execute();
		$row1 = $sth->fetch();
		
		if(!empty($row1))
		{
			return $row1['setting_value'];
		}
	}
	
	public function GetSettingValue($setting_name)
	{
		$dbh = DB_GetConnection();
		$sql = "SELECT * FROM hr_settings WHERE setting_name=:setting_name";
		$sth = $dbh->prepare($sql);
		$sth->bindValue(':setting_name', $setting_name, PDO::PARAM_STR);
		$sth->execute();
		if($sth->rowCount() == 1)
		{
			$row = $sth->fetch();
			return $row['setting_value'];
		}
	}
	
	public function PathURL()
	{
		$dbh = DB_GetConnection();
		$sql = "SELECT * FROM hr_settings WHERE setting_name='path_url'";
		$sth = $dbh->query($sql);
		if($sth->rowCount() == 1)
		{
			$row = $sth->fetch();
			return $row['setting_value'];
		}
	}
	
	public function BaseURL()
	{
		$dbh = DB_GetConnection();
		$sql = "SELECT * FROM hr_settings WHERE setting_name='prefix_url' OR setting_name='website_url' OR setting_name='path_url'";
		$sth = $dbh->query($sql);
		
		$url_array = array();
		foreach($sth->fetchAll() as $array1)
		{
			$key = $array1['setting_name'];
			$val = $array1['setting_value'];
			$url_array[$key] = $val;
		}		
		$url = $url_array['prefix_url'].$url_array['Website_url'].'/'.$url_array['path_url'];
		return $url;
	}
	
	public function BaseURL_index()
	{
		$dbh = DB_GetConnection();
		$sql = "SELECT * FROM hr_settings WHERE setting_name='prefix_url' OR setting_name='website_url' OR setting_name='path_url' OR setting_name='rewrites_enabled'";
		$sth = $dbh->query($sql);
		
		$url_array = array();
		foreach($sth->fetchAll() as $array1)
		{
			if($array1['setting_name'] == 'rewrites_enabled' && $array1['setting_value'] == 'true')
			{
				$rewrite = 1;
			}
			$key = $array1['setting_name'];
			$val = $array1['setting_value'];
			$url_array[$key] = $val;
		}		
		if(isset($rewrite) && $rewrite == 1)
		{
			$url = $url_array['prefix_url'].$url_array['Website_url'].'/'.$url_array['path_url'];
		}else{
			$url = $url_array['prefix_url'].$url_array['Website_url'].'/'.$url_array['path_url'].'index.php/';
		}
		
		return $url;
	}
}