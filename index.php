<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
	/**
	* Hyrion CMS
	* Copyright (C) 2013 Hyrion.com
	*
	* This program is free software; you can redistribute it and/or modify
	* it under the terms of the GNU General Public License as published by
	* the Free Software Foundation; either version 2 of the License, or
	* (at your option) any later version.
	* 
	* This program is distributed in the hope that it will be useful,
	* but WITHOUT ANY WARRANTY; without even the implied warranty of
	* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	* GNU General Public License for more details.
	*
	* You should have received a copy of the GNU General Public License along
	* with this program; if not, write to the Free Software Foundation, Inc.,
	* 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
	*/

//Benchmark meter
$GLOBALS['x'] = microtime(true);

class index
{
	/**
	 * This variable is for checking the uri for reservations
	 *
	 * @since 2.0 beta build 1
	 * @access private
	 * @author Maarten Oosting
	 */
	var $reservation_uri = false;
	var $reservation_cmsuri = false;
	var $passUriCheck = false;
	var $source_uri = '';
	var $dest_uri = '';

	/**
	 * This variable is for set the app/controller/function to load
	 *
	 * @since 2.0 beta build 1
	 * @access private
	 * @author Maarten Oosting
	 */
	var $appToLoad = '';
	var $controllerToLoad = '';
	var $functionToLoad = '';

	/**
	 * This function start the cms
	 *
	 * @since 2.0 beta build 1
	 * @access private
	 * @author Maarten Oosting
	 */
	public function begin()
	{
		try
		{
			//Stuff for in debug mode
			//ini_set('error_reporting', 'E_all');
			//ini_set('display_errors', 'On');
			//

			//Starting session
			session_name("Hyrion_Session");
			session_start();
			//

			//Include system and framework files
			//This need really a cleanup

			//framework
			require_once 'system/framework/hrf_AppFolders.php';
			require_once 'system/framework/hrf_URI_Index.php';
			require_once 'system/framework/hrf_LoadControllerClass.php';
			require_once 'system/framework/hrf_Controller.php';
			require_once 'system/framework/hrf_Model.php';
			require_once 'system/framework/hrf_Load.php';
			require_once 'system/settings.php';

			require_once 'system/framework/hrf_Login.php';

			//style
			require_once 'system/style/class.template_parser.php';
			require_once 'system/style/class.load_template.php';
			require_once 'system/library/hrl_style_loader.php';
			require_once 'system/library/hrl_Template_parser.php';


			//cms
			require_once 'system/cms/controller/cms_login.php';
			require_once 'system/cms/controller/cms_ucp.php';
			require_once 'system/cms/model/m_cms_login.php';
			require_once 'system/cms/model/m_cms_load_page.php';
			require_once 'system/cms/controller/cms_load_page.php';

			//helpers
			//require_once 'system/framework/helpers/hrf_mysql_helper.php';
			//require_once 'system/framework/helpers/hrf_login_helper.php';
			require_once 'system/framework/helpers/helper_uri.php';

			//system
			require_once 'system/hr_permissions.php';
			require_once 'system/settings.php';

			require_once 'system/style/hyrionParser.php';
			require_once 'system/style/parser_functions.php';

			$app_folders = new app_folders;
			//$app_folders->begin();

			$URI_index = new URI_index;
			//$URI_index->begin();

			//PDO
			require_once 'system/db_init.php';
			require_once 'system/style_init.php';
			require_once 'system/framework_init.php';
			//


			$GLOBALS['redirect'] = false;
			check_db_auto_connect();
			if(DEFINED('DB_AUTO_CONNECT') && DB_AUTO_CONNECT == true)
			{
				db_connect();
			}

			//Experimental
			/*if(!DEFINED('DB_AUTO_CONNECT'))
			{
				$db = db_connect();
			}*/

			$setting = new settings();
			$GLOBALS['root'] = $setting->path_url();
			
			$app_folders = new app_folders();
			$URI_index = new URI_index();
			$URI_a = $URI_index->begin();
			
			$hrf_login = new hrf_login();
			$hrf_login->secure_login();
			
			$this->include_app();
			$GLOBALS['app'] = $this->appToLoad;
			
			$permission_class = new hr_permissions();
			$rank_id = $permission_class->get_rank_id();

			$lc = new Load_controller_class($this->appToLoad, $this->controllerToLoad, $this->functionToLoad);
			//Check app exist
			if($lc->checkActionExist() == true) {
				//Checking permissions
				if($permission_class->HR_Check_function_permissions($this->appToLoad, $this->controllerToLoad, $this->functionToLoad) == true)
					return $lc->load_function();
				else
					return "error! No Access!2";
				//
			}else{
				die('Error! Not Exist');
			}
			//
			
			
		}
		catch (Exception $ex)
		{
			//Laad error class en geef foutmelding mee aan class.
			//$error = new Error($ex);
			//Voer fout afhandel functie uit.
			//$error->handel_exception_af();
			///////////////////////
			echo '<pre>';
			print_r($ex);
			echo '</pre>'; 
			//////////////////////
			
			$pos = strpos($ex->getMessage(), '#404');
			if ($pos != false) {
				$error_num = '404';
				$error_name = 'Page not found.';
				$this->load_template = new Load_Template();
				echo $this->load_template->header();
				
				$template = new Template_parser();
				$data = array('error_num'  => $error_num,
							  'error_name' => $error_name);
				echo $template->parse('styles/default/templates/error',$data);
				
				echo $this->load_template->footer();
			}else{
				echo "unknown error!";
			}
		}
		catch (Error $ex)
		{
			echo 'foutje!';
		}
	}
	
	private function checkURI()
	{
		$URI_index = new URI_index();
		$seg = $URI_index->get_segments();
		$dbh = DB_GetConnection();

		unset($seg[0]);
		$seg2 = implode('/', $seg);
		$path = $seg2.'/';
		$path2 = $seg[1].'/*';
		$sql = "SELECT * FROM hr_uri_redirects WHERE source_path=".$dbh->quote($path)." OR source_path=".$dbh->quote($path2);
		$sth = $dbh->prepare($sql);
		$sth->execute();
		$fetch = $sth->fetch();
		if (empty($fetch)) {
			$this->reservation_uri = false;
		}else{
			$a = explode('/', $fetch['dest_path']);
			if ($a[0] !== 'cms') {
				$this->dest_uri = $fetch[2];
				$this->reservation_uri = true;
			}else{
				$this->reservation_uri = true;
				$this->reservation_cmsuri = true;
				$this->dest_uri = $fetch[2];
			}
		}
	}

	private function include_app()
	{
		$URI_index = new URI_index();
		$URI_a = $URI_index->begin();
		$uri_helper = new helper_uri();
		$app = $URI_a['app'];
		$controller = $URI_a['controller'];
		$actie = $URI_a['actie'];
		
		$this->checkURI();
		if($this->reservation_uri == false)
		{
			$path = "apps/$app/controllers/".$app."_$controller.php";
			if(file_exists($path))
			{
				$this->passUriCheck = true;
				$this->appToLoad = $app;
				$this->controllerToLoad = $controller;
				$this->functionToLoad= $URI_a['actie'];
				require_once $path;
			}
			//else
				//throw new Exception("Error including controller", 237);
		}else{
			$GLOBALS['redirect'] = true;
			$ex = explode('/', $this->dest_uri);
			//echo $this->dump($ex);
			
			if ($this->reservation_cmsuri == true) {
				$path = 'system/cms/controller/'.$ex[0].'_'.$ex[1].'.php';
			}else{
				if(!empty($ex[0]) && !empty($ex[1]))
				{
					$path = 'apps/'.$ex[0].'/controllers/'.$ex[0].'_'.$ex[1].'.php';
				}else{
					throw new Exception("Error unknown", 239);
				}
			}

			if(!empty($ex[2]))
			{
				if($ex[2] == '*')
				{
					$this->functionToLoad=$uri_helper->uri_segment(2);
				}else
					$this->functionToLoad=$ex[2];
			}
			else
				$this->functionToLoad='index';

			if(file_exists($path))
			{
				$this->passUriCheck = true;
				$this->appToLoad = $ex[0];
				$this->controllerToLoad = $ex[1];
				require_once $path;
			}
			else
				throw new Exception("Error including controller", 238);
		}
	}
	
	public function dump($in) 
	{
		ob_start();
		$out= "<pre>";
		print_r($in);
		$out.= ob_get_contents();
		ob_end_clean();
		$out.= "</pre>";
		return $out;
	}
}
$start_index = new index;
echo $start_index->begin();

$temp = microtime(true) - $GLOBALS['x'];
echo PHP_EOL.'<!-- Page load time: $temp -->';
echo PHP_EOL.'<!-- ';
//print_r($GLOBALS);
echo ' -->';
?>