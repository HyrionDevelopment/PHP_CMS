<?php
class CW_admin_Loadstyle
{	
	//var $check_style;
	
	function __construct()
	{
		//$this->settings = new settings();
		// -----------------------
		//require_once('system/style/class.check_style.php');
		//$this->check_style = new check_style();
		
		//require_once('../system/framework/class.mysql.php');
		//require_once('../system/class.mysql_config.php');
		//require_once('../system/style/class.template_parser.php');
		//require_once('../system/class.settings.php');
	}
	
	function header2()
	{
		$this->check_style = new check_style();
		if(file_exists("header.php"))
		{
			require_once("header.php");
		}else{
			throw new Exception('Can not header found on: '.$this->check_style->default_style().'(default style)');
		}
	}
	
	function header()
	{
		$setting = new settings();
		$file = "style/header.php";
		if(file_exists($file))
		{
			$file_content = file_get_contents($file);
			$key = "{WEBSITE-NAME}";
			//if(strpos($file_content, $key))
			//{
				$val = $setting->get_setting_value("website_name");
				//$val = "CMSWire.nl";
				$file_content = str_replace($key, $val, $file_content);
				
				$menu = $this->menu();
				$file_content = str_replace("{menu}", $menu, $file_content);
				
				
				$val2 = $setting->BaseUrl();
				$file_content = str_replace("{BaseUrl}", $val2, $file_content);
				$file_content = str_replace("{CSS_LAYOUT}", $val2.'admin/style/layout.css', $file_content);
				$file_content = str_replace("{CSS_MENU}", $val2.'admin/style/menu.css', $file_content);
			//}
			return $file_content;
			//require_once($file);
		}else{
			throw new Exception('Can not found header on admin');
		}
	}
	
	private function menu2()
	{

		$mysql = new Mysql();
		$template = new Template_parser();
		
		$file = "styles/".$this->check_style->load()."/menu.php";
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
			throw new Exception('Can not found menu.php on: '.$this->check_style->load().'(default style)');
		}
	}
	
	private function menu()
	{

		//$mysql = new Mysql();
		$template = new Template_parser();
		$setting = new settings();
		$dbh = DB_GetConnection();
		
		$file = "style/menu.php";
		if(file_exists($file))
		{
			$jp = "";
			for ($i = 1; $i <= 10; $i++) 
			{
				$file_content = file_get_contents($file);
				$m_cat = "SELECT * FROM ".DB_prefix."admin_menu_category WHERE order_by=:orderBy";
				$cat_sth = $dbh->prepare($m_cat);
				$cat_sth->bindValue(":orderBy", $i, PDO::PARAM_INT);
				$cat_sth->execute();
				if($cat_sth->rowCount() == 1)
				{
					$data = array();
					$row1 = $cat_sth->fetchAll();
					//$m_item = "SELECT * FROM admin_menu_items WHERE menu_category_id=".$mysql->escape($row1['menu_category_id']);
					$mItemSQL = "SELECT * FROM ".DB_prefix."admin_menu_items WHERE menu_category_id=:category_id ORDER BY order_by";
					$item_sth = $dbh->prepare($mItemSQL);
					$item_sth->bindValue("category_id", $row1[0]['menu_category_id'], PDO::PARAM_STR);
					$item_sth->execute();
					
					if($item_sth->rowCount() > 0)
					{
						//$baseurl = $setting->BaseUrl();
						//$array = array();
						//$result1 = mysql_query($m_item);
						/*while($row = mysql_fetch_assoc($result1))
						{
							$row['item_link'] = str_replace('{BaseUrli_admin}', $setting->base_url()."admin/index.php/", $row['item_link']);
							array_push($array, $row);
						}*/					
						
						$item = $item_sth->fetchAll();
						$item_new = array();
						foreach ($item as $key1 => $value1) {
							$value1['item_link'] = $setting->BaseURL_index().'admin/'.$value1['item_link'];
							array_push($item_new, $value1);
						}

						$data['item'] = $item_new;

						$data['category'] = $row1;
						$data['ul'] = '<ul>';
						$data['/ul'] = '</ul>';
						$jp .= $template->parse('style/menu.php',$data);
					}else{
						$data['item'] = array();
						$data['category'] = $row1;
						$data['ul'] = '';
						$data['/ul'] = '';
						$jp .= $template->parse('style/menu.php',$data);
					}
				}
			}
			return $jp;
		}else{
			throw new Exception('Can not found menu.php on: '.$this->check_style->load().'(default style)');
		}
	}
	
	function footer()
	{
		$file = "style/footer.php";
		if(file_exists($file))
		{
			
			$file_content = file_get_contents($file);
			$key = "{copyright}";
			if(strpos($file_content, $key))
			{
				$val = "&copy;".$this->settings->get_setting_value("website_name")." - 2010-2011";
				$file_content = str_replace($key, $val, $file_content);
			}
			$setting = new settings();
			$val2 = $setting->BaseUrl();
			$file_content = str_replace("{BaseUrl}", $val2, $file_content);
			return $file_content;
			
			//require_once($file);
		}else{
			throw new Exception('Can not found footer on admin style');
		}
	}
	
	function footer2()
	{
		$this->check_style = new check_style();
		if(file_exists("footer.php"))
		{
			require_once("footer.php");
		}else{
			throw new Exception('Can not footer found on: '.$this->check_style->default_style().'(default style)');
		}
	}
}