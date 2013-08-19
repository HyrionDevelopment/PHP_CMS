<?php
class admin_pages_add extends CW_Admin_Controller
{

	function __construct()
    {
        parent::construct();
    }

	function index()
	{
		//$mysql = new Mysql();
		$this->load = new cw_load();
		
		$mysql_model = new admin_pages_mysql();
		$load_style = new CW_admin_loadstyle();
		
		$user_id = $_SESSION['user_id'];
		if(isset($user_id))
		{
			if(isset($_POST['submit']))
			{
				if($mysql_model->numrow_add1() == true)
				{
					$sql = "INSERT INTO pages (page_title, page_alias, page_create_user_id, page_date, page_content)VALUES('".$mysql->escape($_POST['title'])."', '".$mysql->escape($_POST['alias'])."', '".$mysql->escape($user_id)."', '".$mysql->escape(date("Y-m-d H:i:s"))."', '".$mysql->escape($_POST['content'])."')";
					$result = mysql_query($sql) or die(mysql_error());
					echo $load_style->header();
					echo "Succesvol Geplaatst";
					echo $load_style->footer();
				}
			}else{				
				$model2 = $this->load->model('admin_pages_loaddata');
				$row2 = $model2->add_get_username($user_id);
				
				$template = new Template_parser();
				$data = array();
				$data['username'] = $row2['username'];
				echo $load_style->header();
				echo $template->parse('style/templates/pages_add',$data);
				echo $load_style->footer();
			}
		}
	}
	
	function edit()
	{
		$load_style = new CW_admin_loadstyle();
		$template = new Template_parser();
		$mysql = new Mysql();
		$this->load = new cw_load();
		
		$seg1 = new CW_admin_segments();
		$seg = $seg1->get_segments();
		
		if(isset($seg[4]))
		{
			if(isset($_POST['submit']))
			{
				$sql = "UPDATE pages SET page_title='".$mysql->escape($_POST['title'])."', page_alias='".$mysql->escape($_POST['alias'])."', page_content='".$mysql->escape($_POST['content'])."' WHERE page_id='".$mysql->escape($seg[4])."'";
				$result = mysql_query($sql) or die(mysql_error());
				echo $load_style->header();
				echo "Succesvol Gewijzigd";
				echo $load_style->footer();
			}else{
				$model2 = $this->load->model('admin_pages_loaddata');
				$row = $model2->edit_loadpage_data($seg[4]);
				$row2 = $model2->edit_get_username($row['page_create_user_id']);
				$row['page_content2'] = stripslashes($row['page_content']);
								
				$data = array();
				$data['edit'] = array($row);
				$data['page_author'] = $row2['username'];
				
				echo $load_style->header();
				echo $template->parse('style/templates/pages_edit',$data);
				echo $load_style->footer();
			}
		}
	}
	
	function remove()
	{
		$load_style = new CW_admin_loadstyle();
		$template = new Template_parser();
		$mysql = new Mysql();
		
		$seg1 = new CW_admin_segments();
		$seg = $seg1->get_segments();
		
		
		if(isset($seg[4]))
		{
			if(isset($_POST['submit']))
			{
				$sql = "DELETE FROM pages WHERE page_id='".$mysql->escape($seg[4])."'";
				$result = mysql_query($sql) or die(mysql_error());
				echo $load_style->header();
				echo "Succesvol verwijderd";
				echo $load_style->footer();
			}else{
				$sql = "SELECT * FROM pages WHERE page_id='".$mysql->escape($seg[4])."'";
				$result = mysql_query($sql);
				$row = mysql_fetch_assoc($result);
							
				$data = array();
				$data['remove'] = array($row);
				echo $load_style->header();
				echo $template->parse('style/templates/pages_remove',$data);
				echo $load_style->footer();
			}
		}
	}
	
}