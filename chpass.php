<? 
// TODO: Test it

$title = "Change Password";
require_once "_common.php"; 
session_verify();

if($_POST[change]) 
{
  if($_POST[curpass] == "") 
  {
	$errmsg = "Invalid Current Password.";
  } 
  else if($_POST[newpass1] != $_POST[newpass2]) 
  {
	$errmsg = "New Passwords do not match.";
  } 
  else if(strlen($_POST[newpass1]) < 4) 
  {
	$errmsg = "New Password is too short.";
  } 
  else 
  {
	$sql = "Select 1 from $db_table_preferences where login = '$_SESSION[loginname]' ";
	$sql .= "AND password = PASSWORD('$_POST[curpass]')";
	$result=dbexec($sql);
	if(dbnum($result) == 0) 
	{
		$errmsg = "Invalid Current Password";
	} else 
	{
	  /* ok they are successful, change their pass */
	  $sql = "Update $db_table_preferences set ";
	  $sql .= "password = PASSWORD('$_POST[newpass1]') ";
	  $sql .= "WHERE login = '$_SESSION[loginname]'";
	  dbexec($sql);
	  
	  $string = session_id() . $_POST[newpass1]; 
	  $hash = md5($string);
	  $_SESSION['hash'] = $hash;
	  header("Location:$url/index.php");
	}
  }
}	
?>

<?
	if($errmsg) {
		printf("<center><font color=\"red\">Error: %s</font></center>", $errmsg);
	}
?>
<table border="0">
<tr><td><h2>Changing Password for <? $_SESSION[loginname]?></h2></td><td></td></tr>
<tr><td></td><td></td></tr>

<form method="POST" action="<?=$url?>/chpass.php">
<tr><td>Current password</td><td><input type="password" size="16" maxlength="16" name="curpass"></td></tr>
<tr><td>New password    </td><td><input type="password" size="16" maxlength="16" name="newpass1"></td></tr>
<tr><td>Repeat Password </td><td><input type="password" size="16" maxlength="16" name="newpass2"></td></tr>
<tr><td><input type="submit" name="change" value="Modify"></td>
<td><input type="reset"></td>
</tr>
</form>

