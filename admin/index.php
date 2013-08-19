<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_name("Hyrion_Session");
session_start();

require_once "system/admin_segments.php";
require_once "system/style/admin_loadstyle.php";

require_once "system/framework/cw_admin_controller.php";
require_once "system/framework/cw_admin_model.php";
require_once "system/framework/cw_admin_load.php";

require_once '../system/style/class.template_parser.php';
require_once '../system/settings.php';
require_once '../system/hr_permissions.php';


require_once "system/admin_login.php";
require_once "system/admin_dashboard.php";
require_once "system/admin_home.php";
require_once "system/system_class.php";
require_once "system/cw_load.php";

require_once "modules/test/admin_test1_test2.php";
//require_once "modules/pages/controllers/admin_pages_home.php";
//require_once "modules/pages/controllers/admin_pages_add.php";
//require_once "modules/pages/models/admin_pages_loaddata.php";
//require_once "modules/pages/models/admin_pages_mysql.php";

require_once "modules/miniupdater/controllers/admin_miniupdater_home.php";

require_once "modules/styles/controllers/admin_styles_manage.php";

//PDO
require_once 'system/db_init.php';

//Hyrion Parser
require_once '../system/style/hyrionParser.php';
require_once '../system/style/parser_functions.php';

class CW_Admin
{
	function start()
	{
		check_db_auto_connect();
		if(DEFINED('DB_AUTO_CONNECT') && DB_AUTO_CONNECT == true)
		{
			db_connect();
		}
	
		$this->load = new cw_load();
		$load_style = new CW_admin_loadstyle();
		$seg1 = new CW_admin_segments();
		$seg = $seg1->get_segments();
		
		//start
		if(empty($seg[1]))
		{
			$seg[1] = "test1";
			$seg[2] = "test2";
			$seg[3] = "test3";
		}else{
			if(empty($seg[2]))
			{
				$seg[2] = "test2";
				$seg[3] = "index";
			}else{
				if(empty($seg[3]))
				{
					$seg[3] = "index";
				}
			}
		}
		//end
		
		
		$prefix=NULL;
		
		if($seg[1] == "dashboard")
		{
			$prefix="CW";
			$seg[1]="admin";
			$seg[2]="dashboard";
			$seg[3]="index";
		}
		
		if($seg[1] == "home")
		{
			$prefix="CW";
			$seg[1]="admin";
			$seg[2]="home";
			$seg[3]="index";
		}
		
		$this->include_apps($seg);
		
		
		//echo $load_style->header();
		if(isset($_SESSION['user_id']))
		{
			$this->load_classes($seg[1],$seg[2],$seg[3],$prefix);
		}else{
			$settings = new Settings();
			$base_url = $settings->base_url();
			header('location: '.$base_url.'ucp/login/');
		}
		//echo $load_style->footer();
	}
	
	function load_classes($module, $class, $function,$prefix=NULL)
	{
		if($prefix == NULL)
		{
			$prefix = "Admin";
		}
		$class = $prefix.'_'.$module.'_'.$class; 
		if (class_exists($class))
		{
			$class_obj = new $class();
			
			if(method_exists($class_obj, $function))
			{
				$class_obj->$function();
			}
			else
			{
				throw new Exception('Opgeroepen actie "' . $class . '->' . $function . '" bestaat niet.');
			}
		}
		else
		{
			throw new Exception('Class onbekend: ' . $class);
		}
	}
	
	function include_apps($seg)
	{

				//include controllers
				$glob1 = glob("modules/".$seg[1]."/controllers/*.php");
				if(count($glob1) > 0)
				{
					foreach($glob1 as $file_ti)
					{
						require_once $file_ti;
					}
				}
				
				//include models
				$glob1 = glob("modules/".$seg[1]."/models/*.php");
				if(count($glob1) > 0)
				{
					foreach($glob1 as $file_ti)
					{
						require_once $file_ti;
					}
				}
			

	}
	
}
$load = new CW_Admin;
$load->start();
?>