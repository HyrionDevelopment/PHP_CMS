<?php
class BlogArtikelModel extends Model
{
	var $Title = '';
	var $Alias = '';
	var $Timestamp = 0;
	var $UserID = 0;
	var $Content = '';
	
	public function __construct()
    {
        parent::__construct();
    }
	
	public function checkArtikelByID($id)
	{
		$dbh = DB_GetConnection();
		$SQL = "SELECT * FROM ".DB_PREFIX."blog WHERE blog_id=:id";
		$sth = $dbh->prepare($SQL);
		$sth->bindValue(':id', $id, PDO::PARAM_INT);
		$sth->execute();
		if($sth->rowCount() > 1 || $sth->rowCount() == 1)
		{
			return true;
		}
		return false;
	}
	
	public function getArtikelByID($id)
	{
		$dbh = DB_GetConnection();
		$SQL = "SELECT * FROM ".DB_PREFIX."blog WHERE blog_id=:id";
		$sth = $dbh->prepare($SQL);
		$sth->bindValue(':id', $id, PDO::PARAM_INT);
		$sth->execute();
		if($sth->rowCount() > 1 || $sth->rowCount() == 1)
		{
			$row1 = $sth->fetchAll();
			$this->Title = $row1[0]['title'];
			$this->Alias = $row1[0]['title_alias'];
			$this->Timestamp = $row1[0]['timestamp'];
			$this->Content = $row1[0]['content'];
			return true;
		}
		return false;
	}
	
	public function getArtikelAlias()
	{
		return $this->Alias;
	}
	
	public function getArtikelTitle()
	{
		return $this->Title;
	}
	
	public function getArtikelTimestamp()
	{
		return $this->Timestamp;
	}
	
	public function getArtikelUserID()
	{
		return $this->UserID;
	}
	
	public function getArtikelContent()
	{
		return $this->Content;
	}
	
}