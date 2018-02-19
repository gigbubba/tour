<?
$title = "RHCC Tours";
require_once "_common.php"; 
require_once "_prolog.php";

if ($privilege == PRIV_ADMIN)
  $sql =  "select * from tours" ;
else 
  $sql = " select distinct tours.id,tours.title, 
                           tours.description, 
                           sex,tours.type,level 
           from tours,events 
           where tours.id = events.tour_id";

$tours = new tours(); 
$report = new TabSheet( $sql );
$report->add_col ( "faux.delete" ,0);
$report->add_col ( "faux.update" ,0);

for ($row=0; $row< $report->row_no(); $row++)
{
  $tid = $report->get('value',"tours.id",$row);
  $report->set('link',"tours.title", "tour.php?id=$tid", $row);  

  if (      $tours->total_events($tid)  == 0  
       and  $tours->total_players($tid) == 0  
       and  $tours->total_matches($tid) == 0  
     )
   {
     $report->set('value' ,"faux.delete"  , "<img src=_images/delete.png alt='delete'>" ,$row )  ;  
     $report->set('link'  ,"faux.delete"  , "do_tour.php?action=del&id=$tid "           ,$row )  ;  
   }

  $report->set('value',"faux.update"  , "<img src=_images/update.png alt='update'>"   ,$row )  ;  
  $report->set('link' ,"faux.update"  , "do_tour.php?action=mod&id=$tid "             ,$row )  ;  
}

$report->write();
Common::epilog();
?>
