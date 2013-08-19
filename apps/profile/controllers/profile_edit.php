<?php
class profile_edit extends Controller
{
	
	function __construct()
    {
        parent::construct();
    }
	
	function index()
	{
		$this->load = new load();
		$this->load_template = new Load_Template();
		$model1 = $this->load->model('profile_edit_model');
		$template = new Template_parser();
		
		if(isset($_SESSION['user_id']))
		{
			if($_SERVER['REQUEST_METHOD'] == "POST")
			{
				if($model1->edit_profile($_SESSION['user_id']) == 'success')
				{
					echo $this->load_template->header();
						$data_array = array(1 => array('error_message' => "Profiel Successvol geupdated!", 'color' => 'green'));
						$data['error']= $data_array;
						$data['profile'] = $model1->get_profile_data($_SESSION['user_id']);
						echo $template->parse('styles/default/templates/profile/edit_profile',$data);
					echo $this->load_template->footer();
				}elseif($model1->edit_profile($_SESSION['user_id']) == 'forgot'){
					echo $this->load_template->header();
						$data_array = array(1 => array('error_message' => "Je hebt een verplicht veld niet ingevuld.", 'color' => 'orange'));
						$data['error']= $data_array;
						$data['profile'] = $model1->get_profile_data($_SESSION['user_id']);
						echo $template->parse('styles/default/templates/profile/edit_profile',$data);
					echo $this->load_template->footer();
				}
				//echo $model1->edit_profile($_SESSION['user_id']);
			}else{
				
				$data['profile'] = $model1->get_profile_data($_SESSION['user_id']);
				$data['error']= array();
				//echo $this->load_template->header();
				//echo load_template::header();
				echo HR_header();
					echo $template->parse('styles/default/templates/profile/edit_profile',$data);
				echo $this->load_template->footer();
				
			}
		}else{
			echo $this->load_template->header();
			//echo HR_header();
				echo "Je bent niet ingelogd!";
			echo $this->load_template->footer();
		}
	}
	
	function create()
	{
		$this->load = new load();
		$this->load_template = new Load_Template();
		$model1 = $this->load->model('model_profile_edit');
		$template = new Template_parser();
		
		$data = array();
		if($_SERVER['REQUEST_METHOD'] == "POST")
		{
			if($model1->create_profile($_SESSION['user_id']) == true)
			{
				echo $this->load_template->header();
					echo "Profiel Successvol aangemaakt!";
				echo $this->load_template->footer();
			}else{
				echo $this->load_template->header();
					echo "Er is iets fout gegaan, Ga terug naar de vorige pagina!";
				echo $this->load_template->footer();
			}
			//echo $model1->create_profile($_SESSION['user_id']);
		}else{
			$data['profile'] = $model1->get_profile_data($_SESSION['user_id']);
			echo $this->load_template->header();
				echo $template->parse('styles/default/templates/profile/create_profile',$data);
			echo $this->load_template->footer();
		}
	}
	
	function get_profile_state()
	{
		$model1 = $this->load->model('model_profile_edit');
		echo $model1->check_profile($_SESSION['user_id']);
	}
}