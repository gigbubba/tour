<?
$title = "RHCC Tours and Events";
require_once "_common.php"; 
require_once "_prolog.php";

$player = new players();
//$sql = "select * from tours left join events "
//      ."on tours.id = events.tour_id "
//      ."order by events.tour_id,events.starts"; 

$sql = "select * from tours ,events where events.tour_id = tours.id "
      ." order by tours.id,events.starts desc"; 
      
$report = new TabSheet( $sql );
$report->add_col("faux.winner");

for ($row=0; $row< $report->row_no(); $row++)
{
  $tid = $report->get('value',"tours.id",$row);
  $report->set('link',"tours.title", "tour.php?id=$tid", $row);  
  
  $desc     = $report->get('value',"tours.description",$row);
  $location = $report->get('value',"tours.location",$row);
  $report->set("caption","tours.title","$desc<br>Location: $location" ,$row);
  
  $eid = $report->get('value',"events.id",$row);
  if ( ! is_null($eid )) 	//could be null for the outer join
    $report->set('link',"events.title", "event.php?id=$eid", $row);  

  $wid  = $report->get('value',"events.winner_id" , $row);
  $report->set('value', "faux.winner", $player->shortname($wid),$row);
  $report->set('link' , "faux.winner", "player.php?pid=$wid"   ,$row);
}

$report->set_col("tours.title" , "class", "category"); 
$report->del_dups("tours.title");
$report->del_col("tours.description");
$report->del_col("tours.location");
$report->del_col("tours.email");
$report->del_col("tours.sex");
$report->del_col("tours.type");
$report->del_col("tours.level");

$report->write();
Common::epilog();
?>
