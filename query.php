<?
$title = "Table fields ";

require_once "_common.php"; 
require_once "_prolog.php"; 

$table=$_GET['table'];
if ( empty($table) ) Diag::abort('No table parameter specified');

$sql = "show fields from $table";
$show = new TabSheet( $sql );
$show->write();

//$tinfo = new TableForm("$table");
//$tinfo->html();

?>

