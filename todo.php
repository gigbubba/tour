<?
$title = "New Tour: ";
require_once "_common.php"; 
require_once "_prolog.php";
?>

<script language="JavaScript"> title("To do"); </script>
<TABLE  border=0>
<TR><Td>
  <ul class=h1>

    <li> Current
      <UL >
       <li> complete do_draw ... should have seeding and sloting
       <li> draws tables should have new column playoff_eid. it stores events.id of playoff event. For playoff event this field is the same as events.id . Otherwise, must be always be null. 
       <li> create new table db_comments, to keep all comments for tables and columns. Should have columns:   table,column,comment
     </ul>

    <li>Data Integrity
     <UL class=h2>
      <li>  When deleting player from draw - make sure he does not have matches played. Otherwise - barf.
     </ul>

    <li>Refactoring 
     <ul> 
        <li>refactor libmysql - create class DB::
        <li>mysql_db_query is deprecated, do not use this function. Use mysql_select_db() and mysql_query() instead.
        <li>make privilege and loginname global   $CLOBAL[privilege];
        <li class=urgent> player.php when player is doubles,then make names as links to real players 
        <li> player.php - if doubles - pictures of both players to be shown 
     </ul>

    <li>Security
     <UL class=h2>
      <li> Let some messages to be printed only for admin and developer, such as "sql statements" 
      <li> Create a flag for login ( activate/deactivate ), It deactivated user can only view his/others data
      <li> Let user change the password 
    </ul>

    <li>General
     <UL class=h2>
      <li>  configuration: move all variable from config.php to $cfg[]
     </ul>

   <li> Modifications
   <UL class=h2>
    <li> member : create,modify/delete
    <li> member application form
    <li> player : create, deactivate, modify/delete
    <li> double player : create, deactivate, modify/delete
   </ul>

   <li> match
   <ul>
    <li> arrange match
    <li> contact player
    <li> report score:
   </ul>

   <li> player
   <ul>
   </ul>

  <li>DB validation check : other tables to check
  <ul>
   <li> when match is not complete, note should be made
  </ul>

  <ul>  Done
      <li>move to PHP5 on cyrilcanada
      <li> Make primary email a user login name
      <li>should calculate new rating for the player
      <li>  get rid of all matrix refs in app.sripts ( should be replaced with  set and get )
<hr>
