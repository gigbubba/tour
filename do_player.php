<?
$title = "Player: ";

require_once "_common.php";

session_verify();
if ($privilege != PRIV_ADMIN)  Diag::abort('You must be admin to do this!');

//Parameters
//action=mod, modify, only id is mandatory , others optional
//action=new, create, id must not be specified, others optional
//action=del, delete, only id is mandatory
//return=yes, if form was submitted

if( isset ($_GET['action']))
   $action = $_GET['action'];
else
   Diag::abort('action( new |mod | del) must be specified');

$return = isset($_GET['return']);

$table='players';
$players = new players();

switch ($action)
{
  case "del" :
    //TODO: don't let to delete player if his matches still exist
    if ( empty($_GET['id']))
        Diag::abort('Explicit pid is mandatory to delete player');

    $pid = $_GET['id'];

    if ( !$players->exists($pid))
      Diag::abort("No such player with pid=$pid");

    if ( $players->total_matches_played($pid) > 0 )
    {
         Diag::abort("Player ". $players->fullname($pid)
                 . "(pid=$pid) has match records here. Cannot delete the player. ");
    }

    if ( !players::delete($pid) )
      Diag::abort( "Player ". $players->fullname($pid) . " has not been deleted");

    Diag::log("Player $pid had been deleted.");
    $jumpto = Common::get_last_request();
    header("Location:$jumpto");
    break;

  case 'mod':
  {
    if ( empty($_GET['id']))
        Diag::abort('Explicit pid is mandatory to update player info');

    $pid = $_GET['id'];
    if ( ! $players->exists($pid))
      Diag::abort("No such player with pid=$pid exists.");

    $form = new TableForm("$table");
    $form->hidden_field['action'] = $action;

    if ( $return )
    {
      $is_error_found = $form->set_values_from_response();
      if ( $is_error_found == false)
      {
        if ( $form->update('id',$pid) )
           header("Location:$url/player.php?id=$pid");
      }
    }
    else
      $form->set_values_from_table('id',$pid); // where id=$pid

    require_once "_prolog.php";
    $form->html();
    break;
  }
  case 'new':
  {
    $form = new TableForm("$table");
    $form->hidden_field['action'] = $action;
    $form->delete_field(id);  // autoincremental value

    if ( $return )
    {
      $is_error_found = $form->set_values_from_response();

      if ( $is_error_found == false)
      {
        if ( $form->insert())
        {
           #Diag::trace("about to redirect to player.php" );
           header("Location:$url/player.php?id=". mysql_insert_id());
        }
      }
    }

    require_once "_prolog.php";
    $form->html();
    break;
  }
  default :
    Diag::abort("invalid or missing action parameter". var_dump($action) );
}

?>
