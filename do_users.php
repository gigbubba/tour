<?
$title = "Manage Users";
require_once "_common.php";
require_once "_prolog.php";

if (    $privilege != PRIV_ADMIN  && $privilege != PRIV_DEVEL  )
{
   Diag::alert('You have to be logged in as ADMIN or DEVELOPER');  
   Common::set_last_request();
   header("Location:$url/login.php");
   exit;
}

/* we got here via .htaccess, so we're good to go. */
$table = "users";

if( isset($_POST['add']) and $_POST['add']) 
{
  if(strlen($_POST['password1']) < 4)   {
    $errmsg = "Password too short."; 
  } 
  elseif($_POST['password1'] != $_POST['password2']) {
    $errmsg = "Passwords do not match.";
  }
  else if(strlen($_POST['username']) < 3) {
    $errmsg = "Username too short.";
  }
  else {
    $sql = "INSERT INTO $table (login, password) VALUES "
          ."('$_POST[username]', PASSWORD('$_POST[password1]'))";
    $result=dbexec($sql);

    header("Location:$url/do_users.php");
  }
} 
elseif( isset($_POST['delete']) ) {
  $username = $_POST['toDel'];
  $sql = "DELETE FROM $table where login = '$username'";
  $result=dbexec($sql);
  header("Location:$url/do_users.php");
  Diag::log("User $username had been deleted.");
}

$sql = "Select * from $table ORDER BY login";
$result=dbexec($sql);

print "<html><body>";
if( isset($errmsg) ) {
  printf("<center><font color=\"red\">Error: %s</font></center>", $errmsg);
}
?>

<form method="POST" action="<?=$url?>/do_users.php">

<!---- Add User ---->
<table border="0">
<tr>Add User:</td></tr>

<tr>
<td>Username</td>
<td>Password</td>
<td>Password Again</td>
<td></td>
</tr>

<tr>
<td><input type="text" name="username" size="16" maxlength="32"></td>
<td><input type="password" name="password1" size="16" maxlength="16"></td>
<td><input type="password" name="password2" size="16" maxlength="16"></td>
<td><input type="submit" name="add" value="Add User"></td>
</tr>
</table>
<br>

<!---- List Everyone ---->
<table border="0">
<tr>
  <th></th>
  <th>Username</th>
  <th>Privilege</th>
</tr>
<? while($users = mysql_fetch_array($result)) { ?>
<tr>
  <td><input type="radio" name="toDel" value="<?=$users['login']?>"></td> 
  <td><?=$users['login']?></td>
  <td><?=$users['privilege']?></td>
</tr>
<? } ?>

</table>
<input type=submit name=delete value="Delete User">

</form>
<br>
</body>
</html>

