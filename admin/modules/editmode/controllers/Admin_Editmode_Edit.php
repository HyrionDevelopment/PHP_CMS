<?php
class Admin_Editmode_Edit extends CW_Admin_Controller
{

	public function __construct()
    {
        parent::construct();
    }

	public function By_ID()
	{
		require_once '../system/style/class.load_template.php';
	
		$seg1 = new CW_admin_segments();
		$seg = $seg1->get_segments();
		$template = new Template_parser();
		$admin_style = new CW_admin_loadstyle();
		$norm_style = new Load_Template();
		
		if(isset($seg[4]))
		{
			$data=array();
			$setting = new settings();
			$val2 = $setting->BaseUrl();
			$data['settings.BaseUrl'] = $val2;
			$data['[HR_Admin]CacheFolder'] = 'cache/';
			
			echo $template->parse('modules/editmode/viewers/header_editmode',$data);
			$header = $norm_style->header('admin');
			echo $header;
			//include('../styles/default/header.php');
			
			echo '<div class="edittext">';
			$data = $this->loadpage_data($seg[4]);
			echo $data['page_content'];
			echo "</div>";
			
			//include('../styles/default/footer.php');
			$footer = $norm_style->footer('admin');
			echo $footer;
		}
	}
	
	private function loadpage_data($page_id)
	{
		$mysql = new Mysql();
		$sql = "SELECT * FROM pages WHERE page_id='".$mysql->escape($page_id)."'";
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		$row['page_content'] = stripslashes($row['page_content']);
		return $row;
	}
}