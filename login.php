<?
session_start();
require_once "config.php";
require_once "lib/common.php";
require_once "lib/diag.php";
require_once "lib/libdbmysql.php";
require_once "lib/libauth.php";
require_once "lib/api.php";


while ( isset($_POST['login']) )   // one time loop just to use breaks for cleaner code
{
  $sid = session_id();
  $User_Name = $_POST['User_Name'];
  $Password  = $_POST['Password'];

  if(!($User_Name) || ($User_Name == "")){
     Diag::alert("Please, specify user name"); 
     break;
  }

  dbopen();  
  $res = dbexec("select 1 from users where login = '$User_Name'");
  if(dbnum($res) == 0)  
  {
    Diag::alert("Your account does not exist. Please, contact $admin_email ");
    break;
  }
   
  $sql = "select login,password from users where login='$User_Name' AND password=PASSWORD('$Password')";
  $res = dbexec($sql);
  if(dbnum($res) == 0)  
  {
    Diag::alert( "Wrong Password/Login");
    break;
  }
   
  /* success, setup session */
  $row = mysql_fetch_array($res);
  $string = $sid.$row['password'];
  $hash = md5($string);
  $_SESSION['hash']      = $hash;
  $_SESSION['loginname'] = $User_Name;
  $_SESSION['privilege'] = get_user_privilege();

  // find player id for the user 
  $res = dbexec("select id from players,users where players.email1 = '$User_Name'");
  if(dbnum($res))  
  {
     $pid = dbresult($res,0,"id");
     $_SESSION['player_id'] = $pid;
  }

  $jumpto = Common::get_last_request(); empty($_SESSION['last_request']) ? 'events.php' : $_SESSION['last_request'];
  Diag::log("Redirecting to : $jumpto");
  header("Location:$jumpto");
  exit;
}



?>
<form method="post" action="<?=$authloginurl?>?return=" target="_self">
<table border="0">
<tr>
<td>Username:</td>
<td><input type="text" name="User_Name" size="30" maxlength="30"></td>
</tr>
<tr>
<td>Password:</td>
<td><input type="password" name="Password" size="20" maxlength="255"></td>
</tr>
<tr>
<td></td><td> <input type="submit" name="login" size="20" value="Login">
</table>
</form>

