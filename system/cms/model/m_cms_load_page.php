<?php
class m_cms_load_page extends Model_CMS
{

	function load_home()
	{
		$dbh = DB_GetConnection();
		$sql = "SELECT * FROM ".DB_PREFIX."pages WHERE page_is_homepage=1";
		
		$sth = $dbh->query($sql);
		$row1 = $sth->fetchAll();
		
		if(!empty($row1))
		{
			if(count($row1) == 1)
			{
				$row1[0]['page_content'] = stripslashes($row1[0]['page_content']);
				return $row1[0];
			}else{
				//ERROR REPORT
			}
		}else{
			//Error 404??
		}
		return false;
	}
	
	function load_home2()
	{
		$sql = "SELECT * FROM pages WHERE page_is_homepage=1";
		if($this->mysql->num_row($sql) == 1)
		{
			$row = $this->mysql->assoc($sql);
			$row['page_content'] = stripslashes($row['page_content']);
			return $row;
		}
		return false;
	}
	
	function load_page2($page_id)
	{
		$sql = "SELECT * FROM pages WHERE page_id=".$this->mysql->escape($page_id);
		if($this->mysql->num_row($sql) == 1)
		{
			$row = $this->mysql->assoc($sql);
			$row['page_content'] = stripslashes($row['page_content']);
			return $row;
		}
		return false;
	}
	
	function LoadPageFromID($page_id)
	{
		$dbh = DB_GetConnection();
		$sql = "SELECT * FROM ".DB_PREFIX."pages WHERE page_id=:page_id";
		
		$sth = $dbh->prepare($sql);
		$sth->bindValue(":page_id", $page_id, PDO::PARAM_STR);
		$sth->execute();
		
		$row1 = $sth->fetchAll();
		
		if(!empty($row1))
		{
			if(count($row1) == 1)
			{
				$row1[0]['page_content'] = stripslashes($row1[0]['page_content']);
				return $row1[0];
			}else{
				//ERROR REPORT
			}
		}else{
			//Error 404??
		}
	}
	
	function LoadPageFromAlias($alias)
	{
		$dbh = DB_GetConnection();
		$sql = "SELECT * FROM ".DB_PREFIX."pages WHERE page_alias=:page_alias";
		
		$sth = $dbh->prepare($sql);
		$sth->bindValue(":page_alias", $alias, PDO::PARAM_STR);
		$sth->execute();
		
		$row1 = $sth->fetchAll();
		
		if(!empty($row1))
		{
			if(count($row1) == 1)
			{
				$row1[0]['page_content'] = stripslashes($row1[0]['page_content']);
				return $row1[0];
			}else{
				//ERROR REPORT
			}
		}else{
			//Error 404??
		}
	}
}