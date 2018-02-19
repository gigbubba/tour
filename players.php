<?
$title = "All Players";
require_once "_common.php"; 
require_once "_prolog.php";

$sql = "select id,type from players order by type"; 
$player = new players();
$report = new TabSheet( $sql );


$report->add_col ( "faux.delete" );
$report->add_col ( "faux.fullname" );
$report->add_col ( "faux.tours_signed"  );
$report->add_col ( "faux.events_signed" );
$report->add_col ( "faux.matches_won"   );
$report->add_col ( "faux.matches_lost"  );


for ($row=0; $row< $report->row_no(); $row++)
{
   //make url to player profile 
   $player_id = $report->get('value',"players.id",$row );

   if ( $player->total_matches_played($player_id) == 0 )
   {
     $report->set('value' ,"faux.delete"    , "<img src=_images/delete.png alt='delete'>"   ,$row )  ;  
     $report->set('link' ,"faux.delete"     , "do_player.php?action=del&id=$player_id "   ,$row )  ;  
   }

   $report->set('value',"faux.fullname"     , $player->fullname($player_id) ,$row )  ;         
   $report->set('link' ,"faux.fullname"    , "player.php?id=$player_id"   ,$row )  ;  
   $report->set('value',"faux.events_signed", events_signed($player_id)     ,$row )  ;
   $report->set('value',"faux.matches_won"  , matches_won($player_id)       ,$row )  ;  
   $report->set('value',"faux.matches_lost" , matches_lost($player_id)      ,$row )  ;  
   $report->set('value',"faux.tours_signed" , tours_signed($player_id)      ,$row )  ;  
}

$report->del_dups("players.type");
$report->set_col ("players.type" , "class", "category");
$report->write();

Common::epilog();

//******************************************************************
//  Returns number of tours player signed for
//******************************************************************
function tours_signed ($player_id)
{
  $res=dbexec("select count(*) from roster where player_id = $player_id " ); 
  return dbresult($res, 0, 0) ;
}


//******************************************************************
//  Returns number of matches lost by player 
//******************************************************************
function events_signed ($player_id)
{
  $res=dbexec("select count(*) from draws where player_id=$player_id " ); 
  return dbresult($res, 0, 0) ;
}

//******************************************************************
//  Returns number of matches won by player 
//******************************************************************
function matches_won ($player_id)
{
  $res=dbexec("select * from matches where winner_id = $player_id");
  return dbnum($res); 
}


//******************************************************************
//  Returns number of matches lost by player 
//******************************************************************
function matches_lost ($player_id)
{
  $res=dbexec("select * from matches where 
               (    player1_id = $player_id 
                 OR player2_id = $player_id  
               )
               AND winner_id != $player_id ");

  return dbnum($res); 
}

?>
</html>


