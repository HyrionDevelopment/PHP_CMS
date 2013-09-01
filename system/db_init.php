<?php
require_once 'system/hr_config_security.php';
require_once 'system/config.php';

$db_key = 0;

function check_db_auto_connect()
{
	$config = new config();
	if($config->config_db_auto_connect == true)
	{
		define('DB_AUTO_CONNECT', true);
	}
	if(isset($config->config_db_prefix))
	{
		define('DB_PREFIX', $config->config_db_prefix, true);
	}else{
		define('DB_PREFIX', 'hr_', true);
	}
	
}

function db_connect()
{
	$config = new config();
	global $db_key;
	try { 
		$db_key = new PDO('mysql:host='.$config->config_db_host.';dbname='.$config->config_db_name , $config->config_db_user , $config->config_db_pass);
		$db_key->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} 
	catch( PDOException $e ) 
	{ 
		die( $e->getMessage() ); 
	} 
	return $db_key;
}

function db_query()
{
	global $db_key;
	return $db_key;
}

function DB_GetConnection()
{
	global $db_key;
	return $db_key;
}
?>