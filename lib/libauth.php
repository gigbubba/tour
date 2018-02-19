<?
//Checks session 
// Send to login if no session
// verifies session hash if there is one
function session_verify()
{
  global $authloginurl;
  if( !isset($_SESSION['hash']) or !isset($_SESSION['loginname'])) 
  {
    Diag::trace ( "No Session hash or Login name" );
    Common::set_last_request();
    header("Location:$authloginurl");
    exit;
  }
    
  $hash      = $_SESSION['hash'] ; 
  $loginname = $_SESSION['loginname'] ; 

  $sql = "select * from users where login = '$loginname'";
  $res = dbexec($sql);

  if(dbnum($res) == 0)
  {
    tracelog ( "No such user exists");
    Common::set_last_request();
    header("Location:$authloginurl");
  }
  
  // user exists
  $row = mysql_fetch_array($res);
  $sid=session_id();
  $string = $sid.$row['password'];
  $localhash = md5($string);

  if($_SESSION['hash'] != $localhash)   // faked session ?
  {
     session_destroy();
     Diag::trace ( "Session destroy");
     header("Location:$authloginurl");
  }

  return ;
}

function get_user_privilege()
{
  if ( !isset($_SESSION['loginname']) )
    return PRIV_GUEST;

  $loginname =  $_SESSION['loginname'];
  $sql = "select privilege from users where login = '$loginname'";
  $res = dbexec($sql);
  if(dbnum($res) == 0) 
  {
    return PRIV_GUEST;
  }

  $row = mysql_fetch_array($res);
  return $row['privilege'];
}

?>
