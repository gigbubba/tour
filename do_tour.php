<?
$title = "Tour";

require_once "_common.php"; 

session_verify();

if ($privilege != PRIV_ADMIN) {
  Diag::abort('You must be admin to do this!');
}

//Parameters
//action=mod, modify, only id is mandatory , others optional
//action=new, id must not be specified, others optional
//action=del, delete, only id is mandatory
//return=yes, if form was submitted

$action = $_GET['action'];
if (empty($action))
  Diag::abort('action( new |mod | del) must be specified');

$table='tours';

$tours = new tours();
switch ($action)
{
  case "del" : 
    if ( empty($_GET['id'])) 
        Diag::abort('Explicit id is mandatory to delete tour');

    $tid = $_GET['id']; 
        
    if ( !$tours->exists($tid))
      Diag::abort("No such tour with id=$tid");

    $events_no = dbcount("select count(*) from events where tour_id=$tid");
    if ( $events_no > 0 )
      Diag::abort("This tour($tid) has events records here. Cannot delete the tour. ");

    $is_ok  = dbexecDML("delete from $table where id=$tid");
    if ( $is_ok )
    {
      header("Location:tours.php");
      exit;
    }
    else 
      Diag::abort( "Tour has not been deleted");

    break;
  
  case 'mod':
  {
    if ( empty($_GET['id'])) 
        Diag::abort('Explicit tid is mandatory to modify tour');

    $tid = $_GET['id']; 
        
    $count = dbcount("select count(*) from tours where id=$tid");
    if ( $count == 0  )
      Diag::abort("No such tour with id=$tid");

    $form = new TableForm("$table");
    $form->hidden_field['action'] = $action;  
    $form->set_readonly('id',true); // protect the field 
    
    if ( isset($_GET['return']))
    {
      $is_error_found = $form->set_values_from_response();
      if ( $is_error_found == false)
      {
        if ( $form->update('id',$tid) ) { 
           header("Location:$url/tour.php?id=$tid"); 
           exit;
        }
      }
    }
    else
      $form->set_values_from_table('id',$tid); // where id=$tid

    break;
  }
  case 'new':
  {
    $form = new TableForm("$table");
    $form->hidden_field['action'] = $action;
    $form->delete_field('id');  // autoincremental value

    if ( isset($_GET['return']))
    {
      $is_error_found = $form->set_values_from_response();

      if ( $is_error_found == false) {
        if ( $form->insert())
          header("Location:$url/tour.php?id=". mysql_insert_id()); 
          exit;
      }
    }

    break;
  }  
  default :
    Diag::abort("invalid or missing action parameter". var_dump($action) );
}

require_once "_prolog.php"; 
$form->html();

?>
