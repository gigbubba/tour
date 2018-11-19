<?
// Move everything to $cfg[]

$server_name=getenv('SERVER_NAME');
$server_name = empty($server_name) ? "localhost" : $server_name;
$server = "http://$server_name";
$root=getenv('DOCUMENT_ROOT');
################################# GENERAL
$url		= "/tour";
$img		= "$url/img";

switch ($server_name)
{
  case "cyrilcanada.com"         : 
  case "www.cyrilcanada.com"     : 
       $db_server	= "localhost"; 
       $psep = ":";   #path separator
       break;

  case "localhost"               :
       $db_server	= "cyrilcanada.com"; 
       $db_server	= "localhost"; 
       $psep = ";";     #path separator
       break;
  default:
       $db_server	= "localhost";
}

$phplib = "$root/$url/phplib";
ini_set('include_path', ini_get('include_path') . $psep . $phplib );
################################# 
################################# GENERAL
$cookie_duration= 60*60*2;  # 2 hours
$phpsessid_name = "PHPSESSID";          # Should be the same name as in the php.ini file
$authloginurl	= $server.$url."/login.php";
################################# 
$version	= "0.1.1";
$homeurl	= "http://CyrilCanada.com";
$homename	= "Tennis Tour&nbsp;$version";
################################# Support
$admin_email="eugene@cyrilcanada.com";
################################# DATABASE
$db_type	= "mysql";	# postgresql or mysql
$db_base	= "tennis";
$db_user	= "eugene";
$db_pass	= "public";
//$db_user	= "root";
//$db_pass	= "";
//$db_port	= "3833";	# Usualy 5432 for postgresql, 3306 for mysql
#################################################
define ( "TRACELOG", "c:\tour.log" );
//define ( "TRACELOG", "/tmp" );
?>
