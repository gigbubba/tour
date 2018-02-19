<?
// input:  Event ID
// output: Event Details
$title = "Event Details ";
require_once "_common.php"; 

$eid = $_GET['id'];
$eid = empty($eid) ? $_SESSION['event_id'] : $eid;

//still empty - then go to all events list
//if( empty($eid)) {
//  header("Location:$server/$url/events.php");
//  exit();
//}

require_once "_prolog.php";
$_SESSION['event_id'] = $eid;

if( !Event::exists($eid) ) 
    Diag::abort("No such event $eid exists");

$player = new players();
echo "<br>\n";
############################################################
### Events details
############################################################
$sql = "select * from events,tours where events.id=$eid and events.tour_id = tours.id" ;
$report = new TabSheet( $sql );
$etitle  = $report->get('value',"events.title",0);
$etype   = $report->get('value',"events.type",0);
$report->del_col("events.title");

$report->add_col("faux.winner",0);
$wid  = $report->get('value',"events.winner_id" , 0);
$report->set('value', "faux.winner", $player->shortname($wid),0);
$report->set('link' , "faux.winner", "player.php?id=$wid"   ,0);

$report->add_col("faux.update",0);
$report->add_col("faux.delete",0);
$report->set('value',"faux.update","<img src=_images/update.png alt='update'>" ,0 );
$report->set('link' ,"faux.update","do_event.php?action=mod&id=$eid "          ,0 ); 

if(Event::total_matches($eid) == 0 ) {
  $report->set('value',"faux.delete","<img src=_images/delete.png alt='delete'>" ,0 );
  $report->set('link' ,"faux.delete","do_event.php?action=del&id=$eid "          ,0 );  
}

$report->write($etitle);
if ($privilege == PRIV_ADMIN)
{
  $button0 = draw_button("do_event.php?action=del&id=$eid" ,"Delete event" ,$red=true);
  $button1 = draw_button("do_event.php?action=mod&id=$eid" ,"Modify event"      );
  $button2 = draw_button("do_draw.php?action=add&eid=$eid"  ,"Add Player"        );
  $button3 = draw_button("do_draw.php?action=mod&eid=$eid"  ,"Modify Draw"       );
  $button4 = draw_button("do_match.php?action=new&eid=$eid" ,"Report Match"      );
  echo "<table border=0><tr><td>$button0<td>$button1<td>$button2<td>$button3<td>$button4</table>";
}

############################################################
###  Draw 
############################################################
$sql = "select slot,player_id from draws where event_id = $eid order by slot,player_id";
$players = new TabSheet( $sql );

$matches_sql = "select * from matches where matches.event_id=$eid order by date desc";
$matches= new TabSheet($matches_sql );

$drawgrid = array();
if ( $etype == ET_ROBIN )
{
  $drawgrid[0][0] = new cell( "faux.drawcell","Players"); //header 
  //stuff it up 
  for ($row=0; $row< $players->row_no(); $row++)
  {
    $pid1 = $players->get('value',"draws.player_id",$row); 
    $cell = new cell( "faux.drawcell", $row+1 );
    $cell->type = vs_IMG;
    $cell->link = "player.php?id=$pid1" ;
    $cell->set_caption( $player->fullname($pid1) );
    $drawgrid[0][] = $cell; 

    for ($i=0; $i< $players->row_no(); $i++){
      $pid2=$players->get( 'value',"draws.player_id",$i);
      //if players are equal put blank in the cell
      $drawgrid[$pid1][$pid2] = create_cell($pid1,$pid2,$eid);
    }	
  
    $cell = new cell("faux.fullname",$row+1 . ". ". $player->fullname($pid1));
    $cell->link = "player.php?id=$pid1" ;
    array_unshift( $drawgrid[$pid1] , $cell );
  }
}
elseif ( $etype == ET_LOG 
      or $etype == ET_TREE )  // tree need to be developed yet
{
  $drawgrid[0][0] = new cell( "faux.drawcell","Players"); //header 
  $drawgrid[0][1] = new cell( "faux.drawcell","Won"); //header 
  $drawgrid[0][2] = new cell( "faux.drawcell","Lost"); //header 
  for ($row=0; $row < $players->row_no(); $row++)
  {
    $pid  = $players->get('value',"draws.player_id",$row); 
    $cell = new cell("faux.fullname", $player->fullname($pid));
    $cell->link = "player.php?id=$pid" ;
    $drawgrid[$row+1][0] = $cell ;
    $cell = new cell("faux.matches_won", $player->event_wins($pid,$eid) );
    $drawgrid[$row+1][1] = $cell ;
    $cell = new cell("faux.matches_lost", $player->event_losses($pid,$eid) );
    $drawgrid[$row+1][2] = $cell ;
  }
}
else 
{
   print "Error: Invalid event type:'$etype'\n";
   exit();
}

echo "<table\n";
echo "<tr><th class=result_title colspan=". count($drawgrid[0]) .">Draw($etype)</th></tr>";
foreach ( $drawgrid as $row) {
  echo "<tr>\n";	
  foreach ( $row as $cell) {	print $cell->html(); }
  echo "</tr>\n";	
}	
echo "</table>\n";

##################################################################
###  List Matches   
###################################################################
$matches->add_col("faux.player1",0);
$matches->add_col("faux.player2",1);
$matches->add_col("faux.winner", 2);
$matches->add_col("faux.delete" ,0);
$matches->add_col("faux.update" ,0);

for ($row=0; $row< $matches->row_no(); $row++){
  $mid  = $matches->get('value',"matches.id"        , $row);
  $pid1 = $matches->get('value',"matches.player1_id", $row);
  $pid2 = $matches->get('value',"matches.player2_id", $row);
  $wid  = $matches->get('value',"matches.winner_id" , $row);

  $matches->set('value'  , "faux.player1", $player->shortname($pid1),$row);
  $matches->set('link'   , "faux.player1", "player.php?id=$pid1"  ,$row);
  $matches->set('caption', "faux.player1", $player->fullname($pid1),$row);

  $matches->set('value'  , "faux.player2", $player->shortname($pid2), $row);
  $matches->set('link'   , "faux.player2", "player.php?id=$pid2"  ,$row);
  $matches->set('caption', "faux.player2", $player->fullname($pid2),$row);
  
  $matches->set('value'  ,"faux.delete"  , "<img src=_images/delete.png alt='delete'>" ,$row )  ;  
  $matches->set('link'   ,"faux.delete"  , "do_match.php?action=del&id=$mid "           ,$row )  ;  
  $matches->set('value'  ,"faux.update"  , "<img src=_images/update.png alt='update'>"  ,$row )  ;  
  $matches->set('link'   ,"faux.update"  , "do_match.php?action=mod&id=$mid "           ,$row )  ;  

  if( !is_null($wid))
  {
    $matches->set('value',"faux.winner"  ,$player->shortname($wid),$row);
  } 

  $note = $matches->get('value',"matches.note"   , $row);
  if( !empty($note)) 
  { 
    $matches->set('value'  , "matches.note", "read", $row);
    $matches->set('caption', "matches.note", addslashes($note) ,$row);
  }
}

echo "<br>";
if ( $matches->row_no())
  $matches->write("Matches");

Common::epilog();
##################################################################
// checks match status for two players and returns appropriate value
// - SCORE
// - url to report score
// - url to arrange match
##################################################################

function create_cell ( $pid1, $pid2,$eid )
{
  $cell = new cell( "faux.drawcell","&nbsp;");  

  if ( $pid1 == $pid2 )
    return $cell;

  global $player;
  global $matches;

   $vs = "<center><b>" . $player->shortname($pid1) 
       . "</b> vs <b>" . $player->shortname($pid2) 
       . "</b><hr>";  	  

  for ($row=0; $row < $matches->row_no(); $row++)
  {
    $mid    = $matches->get('value',"matches.id"        , $row);
    $p1     = $matches->get('value',"matches.player1_id", $row);
    $p2     = $matches->get('value',"matches.player2_id", $row);
    $wid    = $matches->get('value',"matches.winner_id" , $row);
    $score  = $matches->get('value',"matches.score"     , $row);
    $status = $matches->get('value',"matches.status"    , $row);
    $date   = $matches->get('value',"matches.date"      , $row);
    $note   = $matches->get('value',"matches.note"      , $row);

    if(    ($p1 == $pid1 && $p2 == $pid2)
        || ($p1 == $pid2 && $p2 == $pid1)) 	
    {
      switch ($status)
    	{
    	  case "complete" : 	
    	    if ( is_null($wid))    // there is a winner ?
            die ("Error: Match marked as complete, while no winner set.");  

          $cell->link = "do_match.php?mid=$mid&action=mod";
          if ( $wid == $pid1 )   // is it first player ?
          {
            $cell->value = "<img src=_images/ball-green.gif>";
            $cell->set_caption( "$vs". $player->fullname($pid1) ." won:<br>$score");
            return $cell; 
          }
          elseif ($wid == $pid2 ) // is it second player ?
          {
            $cell->value = "<img src=_images/ball-red.gif>";
            $cell->set_caption( "$vs". $player->fullname($pid1) ." lost:<br>$score");
            return $cell;  
          } 
          else 
            die ("Error: winner is neither player ($wid)"); 
    	  
    	  case "scheduled":
            $cell->link = "do_match.php?mid=$mid&action=mod";
            $cell->value = "<img src=_images/ball-blue.gif>";
            $cell->set_caption( "$vs scheduled<br>$date ");
            return $cell;  

    	  case "due" : 	
            $cell->link = "do_match.php?mid=$mid&action=mod";
            $cell->value = "<img src=_images/ball-yellow.gif>";
            $cell->set_caption( "$vs Not scheduled");
            return $cell;  

    	  case "void" : 	
            $cell->link = "do_match.php?mid=$mid&action=mod";
            $cell->value = "<img src=_images/ball-blue.gif>";
            $cell->set_caption( "$vs void <br> $note ");
            return $cell;  

    	  default:
    	     die ("Error: Invalid value of matches.status field ($status)");
    	}	
    } 
  }

  $cell->value = "<img src=_images/ball-yellow.gif>";
  $cell->link = "do_match.php?action=new&eid=$eid&pid1=$pid1&pid2=$pid2";
  $cell->set_caption( "$vs  Not set");
  return $cell;  
}	

?>
