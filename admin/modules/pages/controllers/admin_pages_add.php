<?php
class admin_pages_add extends CW_Admin_Controller
{

	function __construct()
    {
        parent::construct();
    }

	function index()
	{
		$dbh = DB_GetConnection();
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
					//$sql = "INSERT INTO pages (page_title, page_alias, page_create_user_id, page_date, page_content)VALUES('".$mysql->escape($_POST['title'])."', '".$mysql->escape($_POST['alias'])."', '".$mysql->escape($user_id)."', '".$mysql->escape(date("Y-m-d H:i:s"))."', '".$mysql->escape($_POST['content'])."')";
					$sql = "INSERT INTO hr_pages (
						page_title,
						page_alias,
						page_create_user_id,
						page_create_date,
						page_content
						)VALUES(
						:title,
						:alias,
						:user_id,
						:cdate,
						:content
					)";
					//$result = mysql_query($sql) or die(mysql_error());
					$sth = $dbh->prepare($sql);
					$sth->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
					$sth->bindValue(':alias', $_POST['alias'], PDO::PARAM_STR);
					$sth->bindValue(':user_id', $user_id, PDO::PARAM_INT);
					$sth->bindValue(':cdate', time(), PDO::PARAM_STR);
					$sth->bindValue(':content', $_POST['content'], PDO::PARAM_STR);
					$sth->execute();

					print_r($sth->errorInfo());

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
				echo $template->parse('style/templates/pages_add.php',$data);
				echo $load_style->footer();
			}
		}
	}
	
	function edit()
	{
		$dbh = DB_GetConnection();
		$load_style = new CW_admin_loadstyle();
		$template = new Template_parser();
		$this->load = new cw_load();
		
		$seg1 = new CW_admin_segments();
		$seg = $seg1->get_segments();
		$user_id = $_SESSION['user_id'];
		
		if(isset($seg[4]))
		{
			if(isset($_POST['submit']))
			{
				//$sql = "UPDATE pages SET page_title='".$mysql->escape($_POST['title'])."', page_alias='".$mysql->escape($_POST['alias'])."', page_content='".$mysql->escape($_POST['content'])."' WHERE page_id='".$mysql->escape($seg[4])."'";
				$sql = "UPDATE hr_pages SET page_title=:title, page_alias=:alias, page_content=:content WHERE page_id=:page_id";
				$sth = $dbh->prepare($sql);
				$sth->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
				$sth->bindValue(':alias', $_POST['alias'], PDO::PARAM_STR);
				$sth->bindValue(':content', $_POST['content'], PDO::PARAM_STR);
				$sth->bindValue(':page_id', $seg[4], PDO::PARAM_INT);
				$sth->execute();

				print_r($sth->errorInfo());

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
				echo $template->parse('style/templates/pages_edit.php',$data);
				echo $load_style->footer();
			}
		}
	}
	
	function remove()
	{
		$dbh = DB_GetConnection();
		$load_style = new CW_admin_loadstyle();
		$template = new Template_parser();		
		$seg1 = new CW_admin_segments();
		$seg = $seg1->get_segments();
		
		if(isset($seg[4]))
		{
			if(isset($_POST['submit']))
			{
				$sql = "DELETE FROM hr_pages WHERE page_id=:page_id";
				$sth = $dbh->prepare($sql);
				$sth->bindValue(':page_id', $seg[4], PDO::PARAM_INT);
				$sth->execute();

				echo $load_style->header();
				echo "Succesvol verwijderd";
				echo $load_style->footer();
			}else{
				$sql = "SELECT * FROM hr_pages WHERE page_id=:page_id";
				$sth = $dbh->prepare($sql);
				$sth->bindValue(':page_id', $seg[4], PDO::PARAM_INT);
				$sth->execute();
				$row = $sth->fetch();
							
				$data = array();
				$data['remove'] = array($row);
				echo $load_style->header();
				echo $template->parse('style/templates/pages_remove.php',$data);
				echo $load_style->footer();
			}
		}
	}
	
}