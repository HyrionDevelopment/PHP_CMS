<?php
class admin_styles_manage extends CW_Admin_Controller
{
	public function __construct()
    {
        parent::construct();
    }
	
	public function home()
	{	
		$seg1 = new CW_admin_segments();
		$seg = $seg1->get_segments();
		
		$glob1 = glob('../styles/*', GLOB_ONLYDIR);
		//print_r($glob1);
		
		if(count($glob1) > 0)
		{
			foreach($glob1 as $val)
			{
				$val = str_replace('../styles/', '', $val);
				echo "q1:".$val."<br />";
			}
		}
	}
	
	public function edit()
	{
		$seg1 = new CW_admin_segments();
		$seg = $seg1->get_segments();
		if(isset($seg[4]))
		{
			$glob1 = glob("../styles/".$seg['4']."/*");
			//print_r($glob1);
			if(count($glob1) > 0)
			{
				foreach($glob1 as $val)
				{
					$val = str_replace("../styles/".$seg['4']."/", '', $val);
					//echo "q2:".$val."<br />";
					
					if($val == 'style_info.php')
					{
						//echo $val." Bestaat!! <br />";
						
						
						
						$template = new Template_parser();
						$model_edit = new admin_model_styles_edit();
						
						//$data=array();
						
						$style = $this->read_cfg_file();
						
						echo "<pre>";
						print_r($style);
						echo "</pre>";
						
												
						$data = $model_edit->convert_4parse($style);
						
						
						
						echo $template->parse('style/templates/styles/edit',$data);
					}
				}
			}
		}
	}
	
	private function read_cfg_file2()
	{
		$seg1 = new CW_admin_segments();
		$seg = $seg1->get_segments();
		
		$cfg_file = file_get_contents("../styles/".$seg['4']."/style_info.php");
		$convert = explode("\n", $cfg_file);
		
		$return_array = array();
		
		foreach($convert as $key=>$val)
		{
			$command_check1 = substr($val, 0, 2);
			//echo "1: ".$command_check1."<br />";
			if($command_check1 == '//' || $command_check1 == '\n')
			{
				unset($convert[$key]);
			}
		}
		return $convert;
	}
	
	private function read_cfg_file()
	{
		$seg1 = new CW_admin_segments();
		$seg = $seg1->get_segments();
		
		$style['compatibility'] = array();
		$cfg_file = require_once("../styles/".$seg['4']."/style_info.php");
		return $style;
	}
	
}