<?
$title = "Player'a Profile: ";
require_once "_common.php";

$pid= isset($_GET['id']) ? $_GET['id'] : $_SESSION['player_id'] ;
if( empty($pid) )  header("Location:$server/$url/players.php");
$_SESSION['player_id'] = $pid;   

require_once "_prolog.php";

$players = new players();
if ( !$players->exists($pid))
  Diag::abort("No such player with id=$pid");
##################################################################
# picture
##################################################################
$picture = "players/$pid.jpg";
$picture = file_exists($picture) ? $picture : "players/unknown.jpg";

echo "<table><tr>
      <td rowspan=3><img src=$picture></td>
      <th colspan=2><h3>". $players->fullname($pid) ."</h3></th></tr>
" ;
##################################################################
# player personal data
##################################################################

$sql = "select * from players where id=$pid"; 

$player_data = new TabSheet( $sql );

$player_data->del_col("players.firstname");
$player_data->del_col("players.lastname");
$player_data->del_col("players.type");

$row=0;
$player_data->set('link' ,"players.email1" ,"mailto:".$player_data->get('value', "players.email1",$row)   ,$row) ;  
$player_data->set('value',"players.email1" ,"<img src=_images/email.gif>", $row) ;  
$player_data->set('type' ,"players.email1" ,vs_IMG,$row);  

$player_data->set('link' ,"players.email2" ,"mailto:".$player_data->get('value', "players.email2",$row)   ,$row) ;  
$player_data->set('value',"players.email2" ,"<img src=_images/email.gif>", $row) ;  
$player_data->set('type' ,"players.email2" ,vs_IMG,$row);  


$player_data->add_col("faux.update",0 );
$player_data->set('value',"faux.update","<img src=_images/update.png alt='update'>"   ,0 );
$player_data->set('link' ,"faux.update","do_player.php?action=mod&id=$pid "           ,0 );  

echo "<td >";
$player_data->write( );
echo "</td>";
echo "</tr>";
echo "</tr></table>"; 

##################################################################
# tours statistic
##################################################################
$sql = "select * from tours,roster"
      . "  where roster.tour_id = tours.id"
      . "    and roster.player_id = $pid";
      
$tour_stats = new TabSheet( $sql );

$tour_stats->add_col("faux.matches_stat",2 );
$tour_stats->add_col("faux.rating",2 );

for ($row=0; $row< $tour_stats->row_no(); $row++){
  $tid      = $tour_stats->get('value',"tours.id"          ,$row);
  $desc     = $tour_stats->get('value',"tours.description" ,$row);
  $location = $tour_stats->get('value',"tours.location",$row);
  $tour_stats->set('caption', "tours.title","$desc<br>Location: $location",$row );
  $tour_stats->set('link'   ,"tours.title", "tour.php?tid=$tid",$row);
  $tour_stats->set('value'  ,"faux.matches_stat", $players->tour_wins($pid,$tid)
                                     ."/".$players->tour_losses($pid,$tid)
                                         ,$row); 
  $tour_stats->set('value',"faux.rating", $players->tour_rating($pid,$tid), $row);
}

$tour_stats->del_col("tours.description"  );
$tour_stats->del_col("tours.location"     );
$tour_stats->write("Tours playing");






##################################################################
# events to play
##################################################################
$player_events_title = "Events";
$sql = "select * from tours,events,draws"
      . "  where events.tour_id  = tours.id"
      . "    and events.id       = draws.event_id"
      . "    and draws.player_id = $pid"
      . "  order by events.tour_id"; 
      
$player_events = new TabSheet( $sql );
$player_events->add_col("faux.winner");

for ($row=0; $row< $player_events->row_no(); $row++){
  $tid = $player_events->get ('value',"tours.id",$row);
  $player_events->set('link',"tours.title","tour.php?tid=$tid", $row );  
  
  $desc     = $player_events->get('value',"tours.description", $row );
  $location = $player_events->get('value',"tours.location", $row );
  $player_events->set('caption', "tours.title","$desc<br>Location: $location",$row );
  
  $eid = $player_events->get('value',"events.id",$row);
  $player_events->set('link',"events.title","event.php?eid=$eid",$row);  

  $wid = $player_events->get( 'value',"events.winner_id",$row);
  $player_events->set( 'value',"faux.winner", $players->shortname($wid) , $row );
  $player_events->set( 'link' ,"faux.winner", "player.php?id=$wid", $row );
}


$player_events->del_dups("tours.title");
$player_events->set_col("tours.title" , "class", "category"); 
$player_events->del_col("tours.description");
$player_events->del_col("tours.location");
$player_events->write($player_events_title);


##################################################################
###  List Matches   
##################################################################
$player = new players();

$sql = "select title,player1_id,player2_id,event_id,matches.winner_id, 
        score,date,status 
        from matches,events 
        where   (player1_id = $pid 
                OR player2_id = $pid)
               and matches.event_id = events.id
          order  by starts desc";

$matches= new TabSheet($sql);
$matches->add_col("faux.opponent",1);
$matches->add_col("faux.ball"   ,2);
$matches->add_col("faux.winner" ,3);


for ($row=0; $row< $matches->row_no(); $row++){
  $pid1   = $matches->get( 'value',"matches.player1_id",$row);
  $pid2   = $matches->get( 'value',"matches.player2_id",$row);
  $wid    = $matches->get( 'value',"matches.winner_id" ,$row);
  $status = $matches->get( 'value',"matches.status"    ,$row);

  $opponent_id = ($pid == $pid1 ) ? $pid2 : $pid1;
  $matches->set( 'value', "faux.opponent",$player->shortname($opponent_id) , $row ); ;
  $matches->set( 'link' , "faux.opponent","player.php?id=$opponent_id" , $row ); ;

  if( !empty($wid))
  {
    $matches->set( 'value',"faux.winner", $player->shortname($wid) ,$row );
    $matches->set( 'link' ,"faux.winner", "player.php?id=$wid"    ,$row );
  } 

  $eid = $matches->get( 'value',"matches.event_id",$row);	
  $matches->set( 'link', "events.title", "event.php?id=$eid" , $row);

  switch ($status)
  {
    case "scheduled": 
      $matches->set( 'value'  , "faux.ball", "<img src=_images/ball-blue.gif>",$row); 
      $matches->set( 'caption', "faux.ball", "scheduled",$row);
      break;

   case "due" : 	
      $matches->set( 'value'  , "faux.ball", "<img src=_images/ball-yellow.gif>",$row);
      $matches->set( 'caption', "faux.ball", "not scheduled",$row);
      break;

   case "void" : 	
      $matches->set( 'value',"faux.winner", "void match" ,$row );
      break;

   case "complete" : 	
     if ( is_null($wid) )    // there is a winner ?
       die ("Error: Match marked as complete, while no winner set.");  

     if( $wid == $pid ) {  // is it first player ?
       $matches->set( 'value'  , "faux.ball", "<img src=_images/ball-green.gif>",$row); 
       $matches->set( 'caption', "faux.ball", "won",$row);
     }
     else{
       $matches->set( 'value'  , "faux.ball", "<img src=_images/ball-red.gif>",$row); 
       $matches->set( 'caption', "faux.ball", "lost",$row);
     }
          
     break;

     default:
       die ("Error: Invalid value of matches.status field ($status)");
  }
}

echo "<br>";
$matches->del_dups("events.title");
$matches->set_col ("events.title" , "class", "category"); 
$matches->del_col ("matches.status");
$matches->write("Matches");

Common::epilog();
?>
</html>

