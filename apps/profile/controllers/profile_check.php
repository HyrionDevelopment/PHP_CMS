<?php
class profile_check extends Controller
{

	function get_data()
	{
		if(isset($_SESSION['user_id']))
		{
		$this->load = new load();
		$noob = $this->load->model('model_profile_check');
		$data = array("loop_profile" => $noob->noobje($_SESSION['user_id']));
		
		$this->load_template = new Load_Template();
		$template = new Template_parser();
		echo $this->load_template->header();
			echo $template->parse('styles/default/templates/get_profile',$data);
		echo $this->load_template->footer();
		}else{
			$this->load_template = new Load_Template();
			$template = new Template_parser();
			echo $this->load_template->header();
				echo $template->parse('styles/default/templates/get_profile',$data=null);
			echo $this->load_template->footer();
		}
	}

}