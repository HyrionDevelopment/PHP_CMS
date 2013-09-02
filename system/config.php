<?php
class Config extends hr_config_security
{
	// Database Host (default localhost)
	var $config_db_host='localhost';

	// Database Username
	var $config_db_user='root';

	// Database Password
	var $config_db_pass='Zz90Zkm6';

	// Database Name
	var $config_db_name='beta1';
	
	// Automatic DB Connect (Default is true)
	// This is faster when apps require a database connection.
	// When you are not using apps that require a database connection, it is recommended to disable this(false).
	var $config_db_auto_connect = true;

	// Database type (default MySQL)
	var $config_db_type = 'mysql';
	
	// Database Table Prefix (default is: 'hr_')
	var $config_db_prefix = 'hr_';
	
	// 
	var $config_show_debuginfo = true;

	//Do not delete this!
	function __construct(){parent::__construct(get_called_class());}
}
?>