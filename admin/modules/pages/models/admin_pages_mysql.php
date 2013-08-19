<?php
class admin_pages_mysql extends cw_admin_model
{

	public function __construct()
    {
        parent::construct();
    }
	
	public function numrow_add1()
	{
		if(isset($_POST['title']) && isset($_POST['alias']) && isset($_POST['content']))
		{
			return true;
		}else{
			return false;
		}
	}

	public function add_page($title, $alias, $user_id, $content)
	{
		$sql = "INSERT INTO hr_pages (
			page_title,
			page_alias,
			page_create_user_id,
			page_date,
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
		$sth->bindValue(':title', $title, PDO::PARAM_STR);
		$sth->bindValue(':alias', $alias, PDO::PARAM_STR);
		$sth->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		$sth->bindValue(':cdate', date("Y-m-d H:i:s"), PDO::PARAM_STR);
		$sth->bindValue(':content', $content, PDO::PARAM_STR);
		$sth->execute();
	}
}