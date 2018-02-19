<?
$title = "Database Integrity Check ";
require_once "_common.php"; 

echo "<UL>\n";

$err_count = 0;

##################################################################
echo "<li style='font-weight: bold'>Checking for loose Foreign Keys ....\n"; 
################################################################## 
echo " <UL>\n";
foreach ( $foreign_keys as $fkey => $pkey )
{
   list ( $fk_table , $fk_field ) = split ( "\." , $fkey);
   list ( $pk_table , $pk_field ) = split ( "\." , $pkey);

   print "<li style='color: green;'>$fkey -> $pkey </li>\n";

   $sql = "select $fkey  from $fk_table LEFT JOIN $pk_table ON $fkey =$pkey where $fkey is not NULL AND $pkey IS NULL" ;
   $res = dbexec($sql);
   while( $row = mysql_fetch_row($res) )
   {
     $err_count ++;
     if ( $fkey == 'users.login'  and  $row[0] == 'admin') 
     {
       continue;
     }
     print "<li style='color: red;'>$fkey('$row[0]')->$pkey(NULL) </li>\n";
   }
}	
echo " </ul>\n";

######################################################################################
echo " <li style='font-weight: bold'>Checking 'matches' table ....</li>\n";
echo "  <ul>\n";  
######################################################################################


echo "   <li>Validate winner ID (must be player1 or player2) \n";
$sql = "select id,winner_id,player1_id,player2_id from matches where winner_id != player1_id AND winner_id != player2_id";
$res = dbexec($sql);
echo "    <ul>\n";  
while( $row = mysql_fetch_row($res) )
{
  $err_count ++;
  print "<li style='color: red;'>Invalid winner_id($row[1]) for match id:$row[0] , neither $row[2] nor $row[3]</li>\n";
}
echo "    </ul>\n";  

####### reporter id
echo "   <li>Validate reporter ID (must be player1 or player2) \n";
$sql = "select id,reporter_id,player1_id,player2_id 
        from matches 
        where 
        reporter_id != player1_id AND reporter_id != player2_id";
$res = dbexec($sql);
echo "    <ul>\n";  
while( $row = mysql_fetch_row($res) )
{
  $err_count ++;
  print "<li style='color: red;'>Invalid reporter_id($row[1]) for match id:$row[0] , neither $row[2] nor $row[3]</li>\n";
}

echo "    </ul>\n";  

#### status
echo  "<li>Validate status\n";
$sql = "select * from matches";
$res = dbexec($sql);
echo "    <ul>\n";  
while( $row = mysql_fetch_assoc($res) )
{
  switch ( $row['status'] )
  {
    case 'complete':
         if ( empty( $row['winner_id'] ))   {
           $err_count ++;
           print "<li style='color: red;'>id=". $row['id'] .": winner_id is NULL when match status is 'complete'</li>\n";
         }

         if ( empty( $row['score'] ))   {
           $err_count ++;
           print "<li style='color: red;'>id=". $row['id'] .": score is NULL when match status is 'complete'</li>\n";
         }
        
         break;

    case 'void':
         if ( !empty( $row['winner_id'] ))   {
           $err_count ++;
           print "<li style='color: red;'>id=". $row['id'] .": winner_id is not NULL when match status is 'void'</li>\n";
         }

         break; 

    case 'scheduled':
         if ( empty( $row['date'] ))   {
           $err_count ++;
           print "<li style='color: red;'>id=". $row['id'] .": scheduled date is NULL when match status is 'scheduled'</li>\n";
         }
         break;

    case 'due':
         if ( !empty( $row['date'] ))   {
           $err_count ++;
           print "<li style='color: red;'>id=". $row['id'] .": scheduled date is not NULL when match status is 'due'</li>\n";
         }
         break;

    default:
      print "<li style='color: red;'>id=". $row['id'] .": invalid status value ". $row['status'] ."</li>\n";
  }
}
echo "    </ul>\n";  




echo   "</ul>\n";
######################################################################################
echo "<li style='font-weight: bold'>Checking Event Table .... \n";
######################################################################################
echo "</ul>\n";  

if ( $err_count == 0)
  echo "<h3 style='color: green;'>No DB Integrity Problems Detected<h2>\n";
else
  echo "<h3 style='color: red;'>DB Integrity is compromised !<h2>\n";

dbclose();
?>
</html>

