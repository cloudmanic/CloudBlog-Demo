<?php
error_reporting(E_ALL);
$system_folder = str_replace('application/scripts/run.php', '', $_SERVER['SCRIPT_NAME']);
$tmp = explode('/', $_SERVER['SCRIPT_NAME']);
$tmp = $tmp[3];
$tmp = explode('.', $tmp);
$_SERVER['prefix'] = $tmp[0];
$_SERVER['HTTP_HOST'] = 'CLI';
$_SERVER['iscli'] = 'Yes';
$_SERVER['PATH_INFO'] = '';
$application_folder = "application";

if (strpos($system_folder, '/') === FALSE)
{
	if (function_exists('realpath') AND @realpath(dirname(__FILE__)) !== FALSE)
	{
		$system_folder = realpath(dirname(__FILE__)).'/'.$system_folder;
	}
}
else
{
	// Swap directory separators to Unix style for consistency
	$system_folder = str_replace("\\", "/", $system_folder); 
}

define('EXT', '.'.pathinfo(__FILE__, PATHINFO_EXTENSION));
define('FCPATH', __FILE__);
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('BASEPATH', $system_folder.'/');

if (is_dir($application_folder))
{
	define('APPPATH', $application_folder.'/');
}
else
{
	if ($application_folder == '')
	{
		$application_folder = 'application';
	}

	define('APPPATH', BASEPATH.$application_folder.'/');
}

require_once BASEPATH.'codeigniter/CodeIgniter'.EXT;
?>