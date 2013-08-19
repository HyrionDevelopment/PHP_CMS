<?php
class admin_model_styles_edit extends CW_Admin_Model
{

	public function __construct()
	{
		parent::construct();
	}

	public function convert_4parse($array)
	{
		include("../languages/nl/test.php");
	
		$return_array = array();
		//insert from config file
		$return_array['name'] = $array['name'];
		$return_array['website'] = $array['website'];
		$return_array['author'] = $array['author'];
		$return_array['copyright'] = $array['copyright'];
		$return_array['version'] = $array['version'];
		
		//extras
		$return_array['compatibility_answer'] = $lang['yes'];
		$return_array['thumb'] = 'http://i39.tinypic.com/fbe1y0.png';
		
		//buttons
		$mysql = new mysql();
		$sql1 = "SELECT * FROM styles WHERE style_name='".$mysql->escape($array['name'])."'";
		if($mysql->num_row($sql1) == 0)
		{
			$return_array['install'] = $lang['install'];
			$return_array['activate'] = '';
			$return_array['delete'] = '';
			$return_array['default'] = '';
			$return_array['clean_cache'] = '';
		}else{
			$result1 = mysql_query($sql1);
			while($row_1 = $mysql->fetch_assoc($result1))
			{
				if($row_1['style_activated'] == 0)
				{
					$return_array['activate'] = $lang['activate'];
				}else{
					$return_array['activate'] = $lang['deactivate'];
				}
			}
				$return_array['install'] = $lang['uninstall'];
				$return_array['delete'] = $lang['delete'];
				$return_array['default'] = $lang['MAKE_DEFAULT'];
				$return_array['clean_cache'] = $lang['CLEAN_CACHE'];
			
			
			
			
			
			
		}	
		
		/*echo "<pre>";
		print_r($return_array);
		echo "</pre>"; */
		
		$return_array['COMPATIBLE_HYRION_VERSION'] = $lang['COMPATIBLE_HYRION_VERSION'];
		$return_array['lang_Author'] = $lang['author'];
		$return_array['lang_style_name'] = $lang['style_name'];
		$return_array['lang_website'] = $lang['website'];
		
		return $return_array;
	}
}