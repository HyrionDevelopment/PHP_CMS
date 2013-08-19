<?php
class model_profile_check extends Model
{
	function __construct()
    {
        parent::construct();
    }
	
	function noobje($user_id)
	{
		$sql = "SELECT * FROM profile WHERE user_id='".$this->mysql->escape($user_id)."'";
		if($this->mysql->num_row($sql) > 0)
		{
			return $this->mysql->select_query($sql);
		}
	}
}