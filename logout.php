<?
  require_once "config.php";
  require_once "lib/common.php";
  session_start();
  $jumpto = Common::get_last_request(); 
  session_destroy();
  header("Location:$jumpto");
?>
