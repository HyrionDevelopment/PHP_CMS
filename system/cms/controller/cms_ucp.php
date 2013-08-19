<?php
require_once "system/cms/class.Controller_CMS.php";
require_once "system/cms/class.model_cms.php";
class CMS_ucp extends Controller_CMS
{
	function home()
	{
		//$login_helper = new login_helper();
		//$login_helper->must_login();
		$this->load_template = new Load_Template();
		
		$settings = new settings();
		$data = array();
		$data['base_url'] = $settings->base_url();
		
			echo $this->load_template->header();
			
			$template = new Template_parser();
			echo $template->parse('styles/default/templates/ucp/home.php',$data);
			
			echo $this->load_template->footer();
	}
	
	function login()
	{
		$settings = new settings();
		if(isset($_SESSION['user_id']))
		{
			header('location: '.$settings->base_url().'index.php/ucp/home/');
		}
		$model_login = $this->load->model2('m_CMS_LOGIN');
		if(empty($_POST)) //Checken of het forumulier niet is opgestuurd?
		{
			//nee
			$this->load_template = new Load_Template();
			echo $this->load_template->header();
			
			$template = new Template_parser();
			echo $template->parse('styles/default/templates/login.php',$data=array());
			
			echo $this->load_template->footer();
		}else{ //Zo wel dan
			$user = $_POST['user'];
			$pass = sha1($_POST['pass']);
			if($user && $pass) //Als de gegevens wel ingevuld zijn
			{
				if($model_login->check_login($user,$pass) == true) // Als de gegevens wel kloppen
				{
					//echo "De gegevens kloppen: ".$user.$_SESSION['user_id'];
					$user_id = $model_login->get_userid($user,$pass);
					$gen_code = md5($model_login->gen_code($user_id));
					$start_session = $model_login->start_session($user_id, $gen_code);
					if(!$start_session == false)
					{
						//$hrf_login = new hrf_login();
						//echo "HALLO:".$hrf_login->secure_login();
						//if($hrf_login->secure_login() == true)
						//{
						
						header('location: '.$settings->base_url().'/index.php/ucp/home/');
						//}
						//echo "er zit ergens een false!";
					}else{
						echo "er zit ergens een false!";
					}
				}else{
					echo "De gegevens kloppen niet";
				}
			}else{
				echo "Iets vergete?";
			}
		}
	}
	
	public function logout()
	{
		$settings = new settings();
		unset($_SESSION['user_id']);
		session_destroy();
		header('location: '.$settings->base_url());
	}

	public function register()
	{
		$this->load_template = new Load_Template();
		$template = new Template_parser();

		echo $this->load_template->header();
		echo $template->parse('styles/default/templates/ucp/register.php',$data=array());
		echo $this->load_template->footer();
	}
	
}