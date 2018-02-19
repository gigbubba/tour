<?
$title = "Event";

require_once "_common.php"; 

session_verify();

if ($privilege != PRIV_ADMIN) 
  Diag::abort('You must be admin to do this!');

$action = $_GET['action'];
if (empty($action))
  Diag::abort('action( new |mod | del) must be specified');

$table='events';

switch ($action)
{
  case "del" : 
    if ( empty($_GET['id'])) 
        Diag::abort('Explicit id is mandatory to delete event');

    $eid = $_GET['id']; 

    $count = dbcount("select count(*) from $table where id=$eid");
    if ( $count == 0  )
      Diag::abort("No such event with id=$eid");

    if ( !isset($_GET['return']))
    {
      Diag::alert("Warning: All associated matches will be also deleted.");
      echo "<a class=alert href=do_event.php?return=&action=del&id=$eid>
            Please,confirm the deleting of event=$eid
           </a>";

      break;
    } 

    $tid = Event::get_tour_id($eid);
    Diag::log("Deleting event $eid.");
    $is_ok  = Event::delete_cascade($eid); 

    if ( $is_ok )
      header("Location:tour.php?id=$tid");
    else 
      Diag::abort( "Event has not been deleted");

    break;
  
  case 'mod':
  {
    if ( empty($_GET['id'])) 
      Diag::abort('Explicit id is mandatory to update event');

    $eid = $_GET['id']; 
    $events_no = dbcount("select count(*) from events where id=$eid");
    if ( $events_no != 1 )
      Diag::abort("No such event with id=$eid");

    $form = new TableForm("$table");
    $form->hidden_field['action'] = $action;  

    $players = Draw::players($eid); 
    $players[''] = '' ;    // added  id=null to let erase winner_id
    $form->field['winner_id']->set_options($players,'');
    $form->set_readonly('tour_id',true); // protect the field 
    $form->set_readonly('id',true);      // protect the field 

    if ( isset($_GET['return']))
    {
      $is_error_found = $form->set_values_from_response();
      if ( $is_error_found == false)
      {
        if ( $form->update('id',$eid) )
           header("Location:$url/event.php?id=$eid"); 
      }
    }
    else
      $form->set_values_from_table('id',$eid); // where id=$eid


    break;
  }
  case 'new':
  {
    $form = new TableForm("$table");

    if ( isset($_GET['return']))
    {
      $is_error = $form->set_values_from_response();
      if ( $is_error == false)
      {
        if ( $form->insert())
             header("Location:$url/event.php?id=".mysql_insert_id()); 

        break;
      }
    }

    if ( empty($_GET['tid'])) 
       Diag::abort('Explicit tour id (tid) is mandatory to create event');
    else 
       $tid = $_GET['tid'];

    $form->hidden_field['action'] = $action;
    $form->delete_field('id');  // autoincremental value
    $form->delete_field('winner_id');  // too early to have winner 
    $form->set_value('tour_id',$tid); 
    $form->set_readonly('tour_id',true); // protect the field 
    break;
  }  

  default :
    Diag::abort("invalid or missing action parameter". var_dump($action) );
}

require_once "_prolog.php"; 
$form->html();
?>

