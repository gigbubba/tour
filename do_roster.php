<?
$title = "Event";

require_once "_common.php"; 

session_verify();

if ($privilege != PRIV_ADMIN)
{
  Diag::abort('You must be admin to do this!');
}

if ( ! isset($_GET['action']) ) Diag::abort('action( add | del) must be specified');
if ( ! isset($_GET['tid'])    ) Diag::abort('tid is missing, aborting ... ');

$action = $_GET['action'];
$tid    = $_GET['tid'];
$return = isset($_GET['return']);


$players = new players();
switch ($action)
{
  case "del" : 
  {
     if ( !isset($_GET['pid'])) 
        Diag::abort('player id is missing , cannot delete');

     $pid = $_GET['pid']; 
     if ( !$players->exists($pid))
       Diag::abort("No such player with pid=$pid");
      
    if ( !tours::delete_player($tid,$pid))
      Diag::abort( "Player ". $players->fullname($pid) . " has not been deleted");

    $jumpto = Common::get_last_request(); 
    header("Location:$jumpto");
    exit;
  } 
  case "add" : 
  {
    if ( $return )
    {
       //Diag::dump ( $_GET);
       $pids = $_GET['pid'];   // list of player id 
       foreach ( $pids as $pid) {
          if ( ! tours::add_player($tid,$pid) )
            Diag::abort( "Player ". $players->fullname($pid) . " has not been added to tour $tid");
       }

       $jumpto = Common::get_last_request(); 
       header("Location:$jumpto");
       exit;
    }

    $sql = "SELECT players.id FROM players , tours 
              WHERE tours.id = $tid AND
                    players.sex  = tours.sex AND 
                    players.type = tours.type AND 
                    players.id NOT IN ( SELECT player_id FROM roster WHERE tour_id = $tid)";

     $form = new TabSheet( $sql );
     $form->add_col("faux.fullname",0 );
     $form->add_col("faux.checkbox",0 );
     for ($row=0; $row< $form->row_no(); $row++)
     {
       $pid = $form->get('value',"players.id",$row);	
       $form->set('link' ,"faux.fullname","player.php?id=$pid",$row);
       $form->set('value',"faux.fullname",$players->fullname($pid),$row);
       $form->set('value',"faux.checkbox", "<input type=checkbox name='pid[]' value=$pid >"  , $row )  ;  
     }
     break;
   }
   default : Diag::abort("invalid or missing action parameter". var_dump($action) );
}

require_once "_prolog.php"; 
?>

<form type=POST>
<?  $form->write(); ?>
<input type=hidden name=tid value=<?echo $tid?> >
<input type=hidden name=action value=add >
<input type=submit name=return value='Add Selected Players to tour'>
<form> 
