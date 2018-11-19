<?
$title = "Do Match";

require_once "_common.php"; 

session_verify();

if ($privilege != PRIV_ADMIN) {
  Diag::abort('You must be admin to do this!');
}

$action = $_GET['action'];
if (empty($action))
  Diag::abort('action( new |mod | del) must be specified');

$table='matches';

switch ($action)
{
  case "del" : 
    if( isset($_GET['id']) )      
      $mid = $_GET['id']; 
    else 
      Diag::abort('Explicit id is mandatory to update match');

    if ( !Match::exists($mid))
      Diag::abort("No such match with id=$mid");

    $match = new Match($mid);
    $eid = $match->get_event_id();  

    Diag::log("Deleting match $mid.");
    if ( $match->delete() )
      header("Location:".Common::get_last_request()); 
    else 
      Diag::abort( "Match has not been deleted");

    break;
  
  case 'mod':
  {
    if ( isset($_GET['id']))      
      $mid = $_GET['id']; 
    else 
      Diag::abort('Explicit id is mandatory to update match');

    $match = new Match($mid);
    if ( ! $match->is_good())
      Diag::abort("No such match with id=$mid");

    $form = new TableForm("$table");
    $form->hidden_field['action'] = $action;  

    $eid = $match->get_event_id();  
    $players = Draw::players($eid); 
    $form->field['player1_id']->set_options($players);
    $form->field['player2_id']->set_options($players);
    $form->field['winner_id']->set_options($players);
    $form->field['reporter_id']->set_options($players);
    $form->set_readonly('id',true); // protect the field 
    $form->set_readonly('tour_id',true); // protect the field 
    $form->set_readonly('event_id',true); // protect the field 

    if ( isset($_GET['return']))
    {
      $is_error_found = $form->set_values_from_response();
 
      if ( $is_error_found == false)
      {
        if ( $form->update('id',$mid) )
          header("Location:".Common::get_last_request()); 
      }
    }
    else
      $form->set_values_from_table('id',$mid); // where id=$eid

    break;
  }
  case 'new':   //Create new match
  {
    $form = new TableForm("$table");


    if ( isset($_GET['return'] ))
    {
      $is_error = $form->set_values_from_response();

      if ( $is_error == false)
        if ( $form->insert())
          header("Location:".Common::get_last_request()); 
    }

    if ( empty($_GET['eid'])) 
       Diag::abort('Explicit event id (eid) is mandatory to create match');
    else 
       $eid = $_GET['eid'];

    if ( !Event::exists($eid))
      Diag::abort("No such event with id=$eid");

    $tid = Event::get_tour_id($eid);  
    $form->hidden_field['action'] = $action;
    $form->delete_field('id');  // autoincremental value
    $form->set_value('tour_id',$tid); 
    $form->set_value('event_id',$eid); 
    $form->set_readonly('tour_id',true); // protect the field 
    $form->set_readonly('event_id',true); // protect the field 

    $players = Draw::players($eid); 
    $form->field['player1_id']->set_options($players);
    $form->field['player2_id']->set_options($players);
    $form->field['winner_id']->set_options();
    $form->field['reporter_id']->set_options();

    $form->field['player1_id']->set_javascript ('onChange="validate_players()"');
    $form->field['player2_id']->set_javascript ('onChange="validate_players()"');
    $form->field['winner_id']->set_javascript  ('onChange="validate_winner()"');
    $form->field['reporter_id']->set_javascript('onChange="validate_reporter()"');

    $form->set_value('date', '' ); 
    $form->field['date']->helper = '<a href="javascript:Calendar_1.popup();">'
                                  . "<img src=$url/js/tigra_calendar/img/cal.gif" 
                                  . '    width="16" height="16" border="0" 
                                      alt="Click Here to Pick up the date"> 
                                   </a>';
    break;
  }  

  default :
    Diag::abort("invalid or missing action parameter". var_dump($action) );
}

require_once "_prolog.php"; 
?> <script language="JavaScript" src="<?echo $url?>/js/tigra_calendar/calendar2.js"></script> <?
    $form->html();

?>

<!-- American format mm/dd/yyyy -->
<script language="JavaScript">
			<!-- // create calendar object(s) just after form tag closed
				   // specify form element as the only parameter (document.forms['formname'].elements['inputname']);
				   // note: you can have as many calendar objects as you need for your application
				var Calendar_1 = new calendar2(document.forms['matches'].elements['date']);
				Calendar_1.year_scroll = true;
				Calendar_1.time_comp = true;
			//-->
</script>

<script type="text/javascript">

function addOption(select,value,text)
{
  var option=document.createElement('option');
  option.text=text;
  option.value=value;
  try       { select.add(option,null);}   // standards compliant 
  catch(ex) { select.add(option);}        // IE only 
}

function validate_winners(id)
{
  var wid=document.getElementById('winner_id');
  alert ( 'validate winners: wid.size=' + wid.size);
  if (wid.size != 3 )
     alert ( 'Choose players first' );
}

function validate_players()
{
  var p1=document.getElementById('player1_id');
  var p2=document.getElementById('player2_id');
  var wid=document.getElementById('winner_id');
  var rid=document.getElementById('reporter_id');

  var i1 = p1.selectedIndex; 
  var i2 = p2.selectedIndex; 
  var p1_value =  p1.options[i1].value; 
  var p1_text  =  p1.options[i1].text
  var p2_value =  p1.options[i2].value; 
  var p2_text  =  p1.options[i2].text
   
  if ( p1_value == p2_value )  {
    alert( 'Opponents cannot be the same:' + p1.value + ' and ' + p2.value);
    p2.selectedIndex = p2.length-1; 
    return;
  } 

  // if both players are selected - fill in winner choice
  if (  p1_value != '' && p2_value != '' )
  {
    erase_select(wid);
    erase_select(rid);
    addOption(wid ,'' ,'' );
    addOption(wid ,p1_value ,p1_text );
    addOption(wid ,p2_value ,p2_text );
    addOption(rid ,'' ,'' );
    addOption(rid ,p1_value ,p1_text );
    addOption(rid ,p2_value ,p2_text );
  }
}

function erase_select(selectObject)
{
  var option_no = selectObject.length;
  for (i=0;i<option_no;i++) {
    selectObject.remove(0);
  }
}

</script>

