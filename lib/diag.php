<?
class Diag
{

  function dump ( $variable )
  {
     echo "<pre>";
     var_dump($variable);
     echo "</pre>";
  }

  function trace ( $msg )
  {
    echo "<font color=\"green\">Trace: $msg</font><br>";
  }
  
  function log ( $msg )
  {
    //error_log( $msg."\n", 3, TRACELOG );  //goes to file TRACELOG  does not reall work
    //error_log( $msg, 0 );  //goes to PHP system logger, though does not work at 110md.com, they barf
  }
  
  function error($msg) 
  {
     echo "<font color=\"red\">Error: $msg</font><br>";
  }
  
  function abort($msg) 
  {
     self::alert("$msg");
     echo "<center><font color=\"red\">Error: $msg</font></center>";
     exit;
  } 

  function alert($msg) 
  {
     echo "<script language='JavaScript'>alert('$msg');</script>";
  } 
}
?>
