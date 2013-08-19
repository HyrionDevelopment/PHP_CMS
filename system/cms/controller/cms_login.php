<?php
require_once "system/cms/class.Controller_CMS.php";
require_once "system/cms/class.model_cms.php";
class CMS_LOGIN extends Controller_CMS
{
	var $salt1;
	var $salt2;
	
	var $gen_code1;
	var $gen_code2;
	
	var $ip;
	var $user_id;
	
	var $session_code;
	var $hash_code;
	
	function __construct()
	{
		$this->salt1 = "40273";
		$this->salt2 = "73639";
		$this->ip = $_SERVER['REMOTE_ADDR'];
		$this->load = new load();
	}
	
	function login2()
	{
		$model_login = $this->load->model('m_CMS_LOGIN');
		$code = $model_login->gen_code(1);
		print_r($code);
		//if("remember me")
		//{
			$this->session_code = $code[0].md5($this->ip.$code[1].date("Y-m-d")).$code[2];
		//}
		$this->hash_code = hash("sha1", $this->session_code);
		echo $this->hash_code;
	}
	
	function loginqq()
	{
		$model_login = $this->load->model('m_CMS_LOGIN');
		if(empty($_POST['submit'])) //Checken of het forumulier niet is opgestuurd?
		{
			//Nee
			require_once 'styles/default/templates/login.php';
		}else{ //Zo wel dan
			$user = $_POST['user'];
			$pass = $_POST['pass'];
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
						$login = new Login_helper();
						if($login->must_login() == true)
						{
							echo "Koe";
						}
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
	
	function login_c()
	{
		echo $_POST['user'];
	}
}