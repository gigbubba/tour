<?
class Common
{
  function epilog()
  {
     self::set_last_request();
     dbclose();
  }
  
  function set_last_request()
  {
    $_SESSION['last_request'] = $_SERVER["REQUEST_URI"];
  }

  function get_last_request()
  {
    return empty($_SESSION['last_request']) ? "$url/events.php" : $_SESSION['last_request'];
  }
}

/**
 * @return <script> tag 
 * @param $title  Title
 * @desc runs JS function  set_tag_text , currently, to change "title" tag
 * @Sample  set_tag_text( "title",$title); 
 **/
function set_tag_text( $id,$text )
{
  return "<script>set_tag_text(\"$id\",\"$text\")</script>\n";  	
}

function draw_button( $url, $title, $red=false)
{
  if ( $red)  $red = '_red';
      
  return "<table border=0> <tr> <td> <a class=action$red href=$url> &nbsp $title &nbsp </a> </table>";
}

?>
