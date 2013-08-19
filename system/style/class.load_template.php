<?php
class Load_Template
{	
	//var $check_style;
	
	function __construct()
	{
		$this->settings = new settings();
		// -----------------------
	}
		
	public function header($mode=null)
	{
		if(isset($mode) && $mode == "admin")
		{
			require_once('../system/style/class.check_style.php');
			$check_style = new check_style();
			$file = "../styles/".$check_style->load()."/header.php";
			$menu = $this->menu('admin');
		}else{
			require_once('system/style/class.check_style.php');
			$check_style = new check_style();
			$check_style->refreshCache();
			$file = "styles/".$check_style->load()."/header.php";
			$menu = $this->menu();
			
		}
		if(file_exists($file))
		{
			$file_content = file_get_contents($file);
			$key = "{WEBSITE-NAME}";
			if(strpos($file_content, $key))
			{
				$val = $this->settings->get_setting_value("website_name");
				$file_content = str_replace($key, $val, $file_content);				
			}
			
			
			$file_content = str_replace("{menu}", $menu, $file_content);
			
			
				
			$setting = new settings();
			$base_url = $setting->BaseURL_index();
			$file_content = str_replace("{setting.base_url}", $setting->BaseURL(), $file_content);
			$file_content = str_replace("{setting.BaseUrl}", $setting->BaseURL(), $file_content);
			$file_content = str_replace("{setting.BaseURL}", $setting->BaseURL(), $file_content);
			$file_content = str_replace("{setting.BaseUrl_index}", $setting->BaseURL_index(), $file_content);
			$file_content = str_replace("{setting.BaseURL_index}", $setting->BaseURL_index(), $file_content);
			$file_content = str_replace("{setting.BaseURL_Index}", $setting->BaseURL_index(), $file_content);
			$file_content = str_replace("{setting.BaseUrl_Index}", $setting->BaseURL_index(), $file_content);
			$file_content = str_replace("{setting.BaseUrlIndex}", $setting->BaseURL_index(), $file_content);
			$file_content = str_replace("{setting.BaseURLIndex}", $setting->BaseURL_index(), $file_content);
			
			//Load Page V1.1
			if(preg_match_all("|{load_page:(.+?)}|s", $file_content, $match1))
			{
				//require_once('system/cms/model/m_cms_load_page.php');
				//$model_cms1 = new m_cms_load_page();
						
					//var_dump($match1[1]);	
					
					
				foreach($match1[1] as $key=>$val)
				{
					//echo $val;
					if(preg_match("# ".preg_quote("[")."(.+?)".preg_quote("]")." WHERE id=([0-9]{1,10})#", $val, $match2))
					{
						//echo "<br />";
						//var_dump($match2);
						
						$sql1 = "SELECT * FROM hr_pages WHERE page_is='".mysql_real_escape_string(intval($match2[2]))."'";
						$result1 = mysql_query($sql1);
						
						if(mysql_num_rows($result1) == 1)
						{		
							$replacement1 = mysql_fetch_assoc($result1);
							if($match2[1] == "content")
							{
								//$replacement1 = $model_cms1->load_page(intval($match2[2]));
								$file_content = preg_replace("#{load_page: ".preg_quote("[")."content".preg_quote("]")." WHERE id=".$match2[2]."}#", $replacement1['page_content'], $file_content, 1);
							}
							if($match2[1] == "title")
							{
								//$replacement1 = $model_cms1->load_page(intval($match2[2]));
								$file_content = preg_replace("#{load_page: ".preg_quote("[")."title".preg_quote("]")." WHERE id=".$match2[2]."}#", $replacement1['page_title'], $file_content, 1);
							}
						}
					}
				}
			}
			//END LOAD PAGE
			
			if(isset($mode) && $mode == "admin")
			{
				$file_content = str_replace("{jquery}", '', $file_content);
			}else{
				$file_content = str_replace("{jquery}", '<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>', $file_content);
			}
			
			return $file_content;
		}else{
			throw new Exception('Can not header found on: '.$check_style->load().'(default style)');
		}
	}
	
	private function menu2()
	{
		$mysql = new Mysql();
		$template = new Template_parser();
		
		$file = "styles/".$check_style->load()."/menu.php";
		if(file_exists($file))
		{
			$jp = "";
			for ($i = 1; $i <= 10; $i++) 
			{
				$file_content = file_get_contents($file);
				$m_cat = "SELECT * FROM menu_category WHERE menu_category_id=".$mysql->escape($i);
				$m_item = "SELECT * FROM menu_items WHERE menu_category_id=".$mysql->escape($i);
				
				$m_cat2 = "SELECT * FROM menu_category WHERE menu_category_id=".$mysql->escape($i);
				$m_item2 = "SELECT * FROM menu_items WHERE menu_category_id=".$mysql->escape($i)." ORDER BY order_by";
				
				$item_num = "";
				
				if($mysql->num_row($m_cat))
				{
					$data = array();
					if($mysql->num_row($m_item))
					{
						$data['item'] = $mysql->select_query($m_item2);
					}else{
						$data['item'] = array(array("item_name" => null));
					}
					$data['category'] = $mysql->select_query($m_cat2);
					$jp .= $template->parse('styles/default/menu',$data);
				}
			}
			return $jp;
		}else{
			throw new Exception('Can not found menu.php on: '.$check_style->load().'(default style)');
		}
	}
	
	private function menu($mode=null)
	{
		$dbh = DB_GetConnection();
		$settings = new Settings();
		$template = new Template_parser();
		
		if(isset($mode) && $mode == "admin")
		{
			require_once('../system/style/class.check_style.php');
			$check_style = new check_style();
			$file = "../styles/".$check_style->load()."/menu.php";
		}else{
			require_once('system/style/class.check_style.php');
			$check_style = new check_style();
			$file = "styles/".$check_style->load()."/menu.php";
		} 
		
		if(file_exists($file))
		{
			$jp = "";
			for ($i = 1; $i <= 10; $i++) 
			{
				$file_content = file_get_contents($file);
				$McatSQL = "SELECT * FROM ".DB_PREFIX."menu_category WHERE order_by=:orderBy";	
				$cat_sth = $dbh->prepare($McatSQL);
				$cat_sth->bindValue(":orderBy", $i, PDO::PARAM_INT);
				$cat_sth->execute();
				
				if($cat_sth->rowCount() == 1)
				{
					$data = array();
					$row1 = $cat_sth->fetchAll();
					
					
					//$m_item = "SELECT * FROM ".DB_prefix."menu_items WHERE menu_category_id=".$mysql->escape($row1['menu_category_id']);
					$mItemSQL = "SELECT * FROM ".DB_prefix."menu_items WHERE menu_category_id=:category_id";
					$item_sth = $dbh->prepare($mItemSQL);
					$item_sth->bindValue("category_id", $row1[0]['menu_category_id'], PDO::PARAM_STR);
					$item_sth->execute();
					
					if($item_sth->rowCount() > 0)
					{
						//$item = $mysql->select_query($m_item);
						$item = $item_sth->fetchAll();
						$data['item'] = $item;
						//$data['category'] = $mysql->select_query($m_cat);
						$data['category'] = $row1;
						
						$data['base_url'] = $settings->base_url();
						$data['BaseUrl_index'] = $settings->BaseUrl_index();
						$jp .= $template->parse('styles/default/menu.php',$data);
					}
				}
			}
			return $jp;
		}else{
			throw new Exception('Can not found menu.php on: '.$check_style->load().'(default style)');
		}
	}
	
	function footer($mode=null)
	{	
		if(isset($mode) && $mode == "admin")
		{
			require_once('../system/style/class.check_style.php');
			$check_style = new check_style();
			$file = "../styles/".$check_style->load()."/footer.php";
			//require_once('../system/cms/model/m_cms_load_page.php');
		}else{
			require_once('system/style/class.check_style.php');
			$check_style = new check_style();
			$file = "styles/".$check_style->load()."/footer.php";
			require_once('system/cms/model/m_cms_load_page.php');
		}
		if(file_exists($file))
		{
			$file_content = file_get_contents($file);
			$key = "{copyright}";
			if(strpos($file_content, $key))
			{
				$val = "&copy;".$this->settings->get_setting_value("website_name")." - 2010-2011";
				$file_content = str_replace($key, $val, $file_content);
			}
			
			//Load Page V1.1
			if(preg_match_all("|{load_page:(.+?)}|s", $file_content, $match1))
			{
				//require_once('system/cms/model/m_cms_load_page.php');
				//$model_cms1 = new m_cms_load_page();
						
					//var_dump($match1[1]);	
					
					
				foreach($match1[1] as $key=>$val)
				{
					//echo $val;
					if(preg_match("# ".preg_quote("[")."(.+?)".preg_quote("]")." WHERE id=([0-9]{1,10})#", $val, $match2))
					{
						/*echo "<pre>";
						print_r($match2);
						echo "</pre>";*/
						
						$sql1 = "SELECT * FROM hr_pages WHERE page_id=".mysql_real_escape_string(intval($match2[2]));
						
						$result1 = mysql_query($sql1);
												
						if(mysql_num_rows($result1) == 1)
						{		
							$replacement1 = mysql_fetch_assoc($result1);
							if($match2[1] == "content")
							{
								//$replacement1 = $model_cms1->load_page(intval($match2[2]));
								$file_content = preg_replace("#{load_page: ".preg_quote("[")."content".preg_quote("]")." WHERE id=".$match2[2]."}#", $replacement1['page_content'], $file_content, 1);
							}
							if($match2[1] == "title")
							{
								//$replacement1 = $model_cms1->load_page(intval($match2[2]));
								$file_content = preg_replace("#{load_page: ".preg_quote("[")."title".preg_quote("]")." WHERE id=".$match2[2]."}#", $replacement1['page_title'], $file_content, 1);
							}
						}
					}
				}
			}
			//
			return $file_content;
		}else{
			throw new Exception('Can not footer found on: '.$check_style->default_style().'(default style)');
		}
	}
	
}