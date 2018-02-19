<?
$title = "Tour Details: ";
require_once "_common.php";

$tid= isset($_GET['id']) ? $_GET['id'] : $_SESSION['tour_id'] ;
$_SESSION['tour_id'] = $tid;   // remember pid

require_once "_prolog.php";

if( empty($tid)) 
  Diag::abort("No such tour_id exists: $tid"); 

##################################################################
# Tour desc
##################################################################
$sql = "select * from tours where id=$tid";	
$details = new TabSheet( $sql );
if ( $details->row_no() == 0 )
  Diag::abort("no such tour id ($tid)");

$title .= $details->get('value',"tours.title", 0);
print set_tag_text( "title",$title);

$details->set_col("tours.title","class","category");

##################################################################
# Tours Events
##################################################################
$sql = "select * from events where tour_id=$tid order by starts";	
$report_events = new TabSheet( $sql );
$report_events->add_col("faux.update",0 );
$report_events->add_col("faux.delete",0 );
for ($row=0; $row< $report_events->row_no(); $row++){
  $eid = $report_events->get('value',"events.id",$row);  
  $report_events->set('link',"events.title","event.php?id=$eid" ,$row);  
  $report_events->set('link',"events.title","event.php?id=$eid" ,$row);  
  $report_events->set('value',"faux.update","<img src=_images/update.png alt='update'>" ,$row );
  $report_events->set('link' ,"faux.update","do_event.php?action=mod&id=$eid "          ,$row );  

  if(Event::total_matches($eid) == 0 and
     Draw::total_players($eid) == 0 )
  {
    $report_events->set('value',"faux.delete","<img src=_images/delete.png alt='delete'>" ,$row );
    $report_events->set('link' ,"faux.delete","do_event.php?action=del&id=$eid "          ,$row );  
  }
}


##################################################################
# Tours Players
##################################################################
$sql = "select players.id, CONCAT(firstname,' ',lastname) as fullname , handicap"
      ." from players,roster"
      ." where roster.tour_id = $tid"
      ."   and players.id = roster.player_id";	

$report_players = new TabSheet( $sql );
$report_players->add_col("faux.matches_stat",2 );
$report_players->add_col("faux.rating",3 );
$report_players->add_col("faux.delete",0 );

$players = new players();
for ($row=0; $row< $report_players->row_no(); $row++){
  $pid = $report_players->get('value',"players.id",$row);	
  $report_players->set('link',"faux.fullname","player.php?id=$pid",$row);

  $win_no  = $players->tour_wins($pid,$tid);
  $loss_no = $players->tour_losses($pid,$tid);
  $rating  = $players->tour_rating($pid,$tid);
    
  $report_players->set('value',"faux.matches_stat", "$win_no/$loss_no", $row);                                  
  $report_players->set('value',"faux.rating", $rating, $row);

  $total_no = $players->tour_wins($pid,$tid) 
             +$players->tour_losses($pid,$tid);
  if( $total_no == 0 ) 
  {
    $report_players->set('value',"faux.delete","<img src=_images/delete.png alt='delete'>" ,$row );
    $report_players->set('link' ,"faux.delete","do_roster.php?action=del&tid=$tid&pid=$pid",$row );  
  }
}




####################################################################
# got all pieces, lets draw
####################################################################

$details->add_col("faux.update",0 );
$details->set('value',"faux.update"  , "<img src=_images/update.png alt='update'>"   ,0 )  ;  
$details->set('link' ,"faux.update"  , "do_tour.php?action=mod&id=$tid "             ,0 )  ;  

if (       $report_events->row_no()  == 0 
      and  $report_players->row_no() == 0 )
{
   $details->add_col("faux.delete",0 );
   $details->set('value',"faux.delete"  , "<img src=_images/delete.png alt='delete'>"  ,0 )  ;  
   $details->set('link' ,"faux.delete"  , "do_tour.php?action=del&id=$tid"             ,0 )  ;  
}

$details->write();
if ($privilege == PRIV_ADMIN)
{
  $button1 = draw_button("do_event.php?action=new&tid=$tid","Create new event");
  $button2 = draw_button("do_roster.php?action=add&tid=$tid","Add a player");
  echo "<table><tr><td>$button1<td>$button2</table>";
}

if ($report_events->row_no())
  $report_events->write("Tour Events");

if ($report_players->row_no())
   $report_players->write("Tour Players");

Common::epilog();
?>

</html>

