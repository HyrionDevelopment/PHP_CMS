<?php
class admin_webshop_orders extends CW_Admin_Controller
{

	public function __construct()
    {
        parent::construct();
    }
		
	public function index()
	{
		$load_style = new CW_admin_loadstyle();
		$template = new Template_parser();
		$data = array();
		
		echo $load_style->header();
		
		echo $template->parse('style/templates/webshop/load_showorders',$data);
			
		echo $load_style->footer();
	}
	
	public function geheim()
	{
		$seg1 = new CW_admin_segments();
		$seg = $seg1->get_segments();
		$load_style = new CW_admin_loadstyle();
		$template = new Template_parser();
		
		if(isset($seg[4]))
		{
			$data = array();
			$model_orders = new model_admin_webshop_orders();
			$data['orders'] = $model_orders->get_all_orders(0, $seg[4]);
			echo $template->parse('style/templates/webshop/show_orders',$data);
			$model_orders->get_pages($seg[4]);
		}
	}
	
	public function processing()
	{
		$seg1 = new CW_admin_segments();
		$seg = $seg1->get_segments();
		
		if(isset($seg[4]))
		{
			$data = json_decode($_POST['data']);
			print_r($data);
			echo "success";
		}else{
			$load_style = new CW_admin_loadstyle();
			$template = new Template_parser();
			
			echo $load_style->header();
		
			echo $template->parse('style/templates/webshop/order_processing',$data=null);
			
			echo $load_style->footer();
			
		}
	}
}