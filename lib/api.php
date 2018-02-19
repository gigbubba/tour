<?
// TODO: Rename into api.inc
// TODO: Create 'diag' class and put log,trace,errors in there
//===================================================
//User privilege, must be identical to users.privilege field
define ( "PRIV_GUEST" , "guest" );
define ( "PRIV_ADMIN" , "admin" );
define ( "PRIV_MEMBER", "member" );
define ( "PRIV_DEVEL" , "developer" );

//===================================================

define ( "S_NOBODY"      , "NOBODY" );  // don't show anybody
define ( "S_ADMIN"       , "ADMIN"  );
define ( "S_MEMBER"      , "MEMBER" );
define ( "S_DEVEL"       , "DEVELOPER" );
define ( "S_ALL"         , "ALL"    );
$show_level = array ( S_NOBODY,S_ADMIN,S_MEMBER,S_ALL );

#event type :  
define ( "ET_ROBIN" , "robin"    );   // robin + playoff(2 semi and final )
define ( "ET_TREE"  , "tree"     );   // elimination, or olympic 
define ( "ET_LOG"   , "log"      );   // just accumulating matches
$event_type = array ( ET_ROBIN,ET_TREE,ET_LOG );

define ( "SHOW_NONE"     , "SHOW_NONE"    );
define ( "SHOW_VALUE"    , "SHOW_VALUE"    );
define ( "SHOW_LOCK"     , "SHOW_LOCK"    );

//attributes of table field
define ( "title"         , "title"   );
define ( "show"          , "show"   );
define ( "desc"          , "desc"   );
define ( "type"          , "type"   );
define ( "ifnull"        , "ifnull" );

//cell value type
define ( "vs_INT"         , "int"    );
define ( "vs_IMG"         , "img"    );
define ( "vs_DATE"        , "date"   );
define ( "vs_STRING"      , "string" );

#Return code :  
define ( "ERROR"        , false    );
define ( "SUCCESS"      , true     );

$Rounds = array
(
  1 => 'Final'
 ,2 => 'Semifinal'
 ,3 => 'Quarters'
 ,4 => 'Fourth Round'
 ,5 => 'Third Round'
 ,6 => 'Second Round'
 ,7 => 'Fourth Round'
 ,8 => 'Fifth  Round'
);

//class DBMap    will work for PHP5 only
//{
  $field_attribute = array ( title,show,desc,type,ifnull );	

  $foreign_keys = array 
  (  
     'events.tour_id'      => 'tours.id'      
    ,'events.winner_id'    => 'draws.player_id'    
    ,'roster.tour_id'      => 'tours.id'       
    ,'matches.tour_id'     => 'tours.id'        
    ,'matches.event_id'    => 'events.id'      
    ,'matches.reporter_id' => 'players.id'    
    ,'doubles.id'          => 'players.id'    
    ,'doubles.player1_id'  => 'players.id'    
    ,'doubles.player2_id'  => 'players.id'    
    ,'matches.player1_id'  => 'players.id'    
    ,'matches.player2_id'  => 'players.id'    
    ,'matches.player1_id'  => 'roster.player_id'    
    ,'matches.player2_id'  => 'roster.player_id'    
    ,'matches.winner_id'   => 'players.id'    
    ,'roster.player_id'    => 'players.id'    
    ,'draws.event_id'      => 'events.id'     
    ,'draws.player_id'     => 'players.id'    
    ,'draws.player_id'     => 'players.id'    
    ,'users.login'         => 'players.email1'    
  );
	
  $tabmap = array 
  ( 
    "faux" => array
    ( 
      ### "show fields from table" query ######################################3
       "Field"     =>array ()
      ,"Type"      =>array ()
      ,"Null"      =>array ()
      ,"Key"       =>array ()
      ,"Default"   =>array ()
      ,"Extra"     =>array ()
      ,"values"    =>array ()   

      #########################################3
      ,"position"       =>array ( title => "Tour Position"       , type=> vs_INT)
      ,"rating"         =>array ( title => "Rating"              , type=> vs_INT
                                                                 , ifnull =>"n/a"
                                                                 , desc  => "points based on results" )
      ,"matches_stat"   =>array ( title => "Matches Won/Lost"    , type=> vs_IMG)
      ,"matches_won"    =>array ( title => "Matches Won"         , type=> vs_INT)
      ,"matches_lost"   =>array ( title => "Matches Lost"        , type=> vs_INT)
      ,"fullname"       =>array ( title => "Player"                             )
      ,"opponent"       =>array ( title => "Opponent"                           )
      ,"players"        =>array ( title => "Players"                            )
      ,"player1"        =>array ( title => "Player 1"                           )
      ,"player2"        =>array ( title => "Player 2"                           )
      ,"winner"         =>array ( title => "Winner"                             )
      ,"tours_signed"   =>array ( title => "Tours Signed"        , type=> vs_INT)
      ,"events_signed"  =>array ( title => "Events Signed"       , type=> vs_INT)
      ,"drawcell"       =>array ( desc => "generic cell to draw tables")
      ,"ball"           =>array ( title => "&nbsp;"              , desc=>"ball image")
      ,"delete"         =>array ( show => S_ADMIN, title => "&nbsp;"  , desc=>"del_image")
      ,"update"         =>array ( show => S_ADMIN, title => "&nbsp;"  , desc=>"mod_image")
      ,"checkbox"       =>array ( show => S_ADMIN, title => "&nbsp;"  , desc=>"Forms Check Box")
    ),  
      
      
    "tours" => array
    ( 
       "id"       =>array ( show  => S_DEVEL )
      ,"sex"      =>array ( ) 
      ,"level"    =>array ( )
      ,"type"     =>array ( )
      ,"email"    =>array ( show  => S_ADMIN      , desc=>"Email of tour admin", )
      ,"title"    =>array ( title => "Tour Title" , desc=>"i.e Men Major"  )
      ,"location" =>array ( title => "Location"   , desc=>"Location of the tour, i.e club name or association")
      ,"description"=>array(title => "Desc"       , desc=>"Description of the tour, i.e who's eligible " )
    ),
     
    "doubles" => array
    ( 
       "id"           =>array ( show  => S_DEVEL )
      ,"player1_id"   =>array ( show  => S_ADMIN )
      ,"player2_id"   =>array ( show  => S_ADMIN )
    ),
    
   
    "players" => array
    ( 
       "type"       =>array ( title => "Type" , desc => "Singles / Doubles"  )
      ,"firstname"  =>array ( title => "First Name"    ) 
      ,"lastname"   =>array ( title => "Last Name"     )
      ,"phone_w"    =>array ( title => "Work Phone"    , show => S_MEMBER  )
      ,"phone_m"    =>array ( title => "Mobile Phone"  , show => S_MEMBER  )
      ,"phone_h"    =>array ( title => "Home Phone"    , show => S_MEMBER  )
      ,"email1"     =>array ( title => "Primary e-mail", show => S_MEMBER  )
      ,"email2"     =>array ( title => "Second. e-mail", show => S_MEMBER  )
      ,"sex"        =>array ( title => "Sex"           , show => S_ADMIN   )
      ,"id"         =>array ( title => "Player ID"     , show => S_DEVEL   , desc => "player id, unique" )
      ,"password"   =>array ( title => "Password"      , show => S_NOBODY  )
    ),
  
 
    "events" => array 
    (
       "id"            =>array (show => S_DEVEL )
      ,"winner_id"     =>array (show => S_DEVEL , title => 'Event Winner')
      ,"tour_id"       =>array (show => S_DEVEL )
      ,"type"          =>array (show => S_ADMIN )    # 'robin','tree','log'
      ,"title"         =>array (title => "Event"     , ifnull=>"not available yet" , desc => "i.e Top Dogs Showdown" )  
      ,"starts"        =>array (title => "Starts"    , ifnull=>"&nbsp"   , type => vs_DATE  )
      ,"ends"          =>array (title => "Ends"      , ifnull=>"&nbsp"   , type => vs_DATE  )
      ,"fee"           =>array (title => "Prize Fee" , ifnull=>"No Prize", show  => S_MEMBER)
      ,"note"          =>array (title => "Note"      , show  => S_ALL            )
    ),
   
    
    //to assign players to  their tours
    "roster" => array 
    (
       "player_id"    =>array ( show => S_DEVEL  )
      ,"tour_id"      =>array ( show => S_DEVEL  )
      ,"handicap"     =>array ( title => "Handicap"  , ifnull=>"-"    , type=> vs_INT, desc => "0,1,2,3" )
    ), 
     
    //to assign player to event
    "draws" => array 
    (
       "player_id"    =>array ( show => S_DEVEL  )
      ,"event_id"     =>array ( show => S_DEVEL  )
      ,"slot"         =>array ( show => S_DEVEL  )  # seq number  of player from top of the draw (tree only)
      ,"seed"         =>array ( title => "Seed" , ifnull=>"&nbsp"  )

    ),
     
    "matches" => array 
    (
       "id"          =>array ( show => S_DEVEL  )
      ,"tour_id"     =>array ( show => S_DEVEL  )
      ,"event_id"    =>array ( show => S_DEVEL  )
      ,"player1_id"  =>array ( show => S_DEVEL  )
      ,"player2_id"  =>array ( show => S_DEVEL  )
      ,"winner_id"   =>array ( show => S_DEVEL  )
      ,"reporter_id" =>array ( show => S_DEVEL  ) 
      ,"slot"        =>array ( show => S_DEVEL   , type=> vs_INT )     # seq number of match for given round from top of the draw (tree only)
      ,"round"       =>array ( show => S_DEVEL   , type=> vs_INT )     # 0- final , 1 - semi , 2 - quarters ( tree only )
      ,"score"       =>array ( title => "Score"  , ifnull=>"&nbsp")
      ,"date"        =>array ( title => "Date"   , ifnull=>"&nbsp" )
      ,"status"      =>array ( title => "Status" , ifnull=>"&nbsp")
      ,"note"        =>array ( title => "Note"   , ifnull=>"&nbsp")
    )
  );


  
  function field_attr ( $fname, $attribute )
  //*********************************************************
  // input :  field name ( table.field ),  attribute key such as  "title" , "show" , "desc"  
  // output : Attribute value, if exists , otherwise returns field name
  //*********************************************************
  {
    list ( $table, $field) = explode( ".", $fname); 
  
    global $field_attribute,$tabmap; 
    if ( ! in_array( $attribute , $field_attribute ) )
    {
      echo "Invalid field attribute($attribute) for field='$fname' )";
      exit;
    }
    
    if ( ! isset( $tabmap[$table]) )
    {
      echo "Invalid table name for field='$fname' )";
      exit;
    }
      
    if ( ! isset( $tabmap[$table][$field] ) )
    {
      echo "Invalid field name for field='$fname' )";
      exit;
    }
     
    if ( ! isset( $tabmap[$table][$field][$attribute] ) )
      $attr_value = null; 
    else      
      $attr_value = $tabmap[$table][$field][$attribute] ;
    
    global $privilege;
                     
    switch ( $attribute)
    {
    	case title : return  ( $attr_value == NULL ) ? $field : $attr_value;
    	case show  : 
    	             switch ( $attr_value )
                   {
     	               case S_NOBODY : return SHOW_NONE; 
                     case S_MEMBER : if ($privilege == PRIV_MEMBER 
                                      || $privilege == PRIV_ADMIN 
                                      || $privilege == PRIV_DEVEL) 
                                      return SHOW_VALUE;
                                     else
                                      return SHOW_LOCK;   
                     case S_ADMIN  : if (   $privilege == PRIV_ADMIN 
                                         || $privilege == PRIV_DEVEL ) 
                                         return SHOW_VALUE;
                                     else
                                         return SHOW_NONE; 
                     case S_DEVEL  : if ($privilege == PRIV_DEVEL) 
                                         return SHOW_VALUE;
                                     else
                                         return SHOW_NONE;                                 
                     default       : return  SHOW_VALUE ; // if we dont have show attr set up 
                   }
      case type  : 
      case desc  :  return  $attr_value;   
      case ifnull:  return ($attr_value == NULL ) ? "&nbsp" : $attr_value;   
    }
       	
    echo "Invalid field attribute($attribute) for field='$fname' )";
    return $attr_value;             
  }
//}

class TabSheet 
##############################################################################
// converts query result to html table
/*usage: 
   players.add_col( $fieldname, $idx )
   players.del_col( "feildname", )
*/
##############################################################################
{
  var $fieldname  = array();  // keeps indexes key:idx 
  var $matrix     = array (); // contains values cells
  var $header     = array (); // contains header cells
  
  // returns number of columns
  function col_no ()   {    return count($this->fieldname); }	
  function row_no ()   {    return count($this->matrix);    }	
  //################################################################
  // returns index of field 
  //################################################################
  function field_idx ( $name)
  {
    for ( $i=0; $i < $this->col_no() ; $i++) 
    {
      $fname = $this->fieldname[$i];
      if ( $fname == $name ) 
        return $i;
    }  
  }
  //################################################################
  //###                      constructor                         ###
  //################################################################
  function TabSheet ($sql)
  {
  	$res=dbexec($sql) ;

    $col_no = mysql_num_fields($res);         // number of fields

    // create header 
    for ($i=0; $i < $col_no; $i++) 
    {
       $fname = mysql_field_name($res,$i);   
       $meta  = mysql_fetch_field($res, $i);
       $tname = !empty($meta->table) ? $meta->table : "faux"; //set to faux if its composite name
       
       $fname = "$tname.$fname"; 
       $this->fieldname[$i]     = $fname; 
                   
       $this->header[$fname] =  new cell($fname);
       $this->header[$fname]->set_th();
       
    }

    // create matrix 
    $row_idx=0;
    while( $row = mysql_fetch_row($res) )
    {
      foreach ( $row as $col_idx => $value ) 
      {
      	$fname = $this->fieldname[$col_idx];
        $meta  = mysql_fetch_field($res, $col_idx);
        
        $cell = new cell( $fname, $value, $meta->type );       // create cell
        $this->matrix[$row_idx][$fname] = $cell;
      }
      
      $row_idx++;
    }
  }//end of constructor


  ////################################################################
  // returns cell value
  ////################################################################
  function get ( $prop,$fname, $row=0 ) 
  {
     return $this->matrix[$row][$fname]->{$prop};	
  }

  ////################################################################
  // returns cell value
  ////################################################################
  function set ( $prop, $fname, $value , $row=0 ) 
  {
     if ( $prop == "caption" )
       $this->matrix[$row][$fname]->set_caption($value);
     else
       $this->matrix[$row][$fname]->{$prop} = $value;	
  }

  ////################################################################
  // returns whole table  
  ////################################################################
  function write ( $title = null) 
  {
    print "<table class=result cellspacing=0 >";
    
    print "<tr><th class=result_title colspan=". $this->col_no() .">$title</th></tr>";
    
    print "<tr>";
    foreach ( $this->fieldname as $fname ) {
      $cell = $this->header[$fname];
      print $cell->html(). "\n";
    } 
    print "</tr>\n";

    // print matrix guided by fieldname
    foreach ( $this->matrix as $row)
    {
      print "<tr>\n";
      foreach ( $this->fieldname as $fname ) {
       	$html = $row[$fname]->html();
      	if ( !is_null($html) )
          print "$html \n";
      }  
      print "</tr>\n";
    } 
    print "</table> <br>" ;
  }

  //################################################################
  //###  writes row , no headers
  //################################################################
  function write_row ( $row) 
  {
    // print matrix guided by fieldname
    print "<tr>";
    foreach ( $this->fieldname as $fname ) {
      	$cell = $this->matrix[$row][$fname];
        print $cell->html() ."\n";
    }  
    print "</tr>\n";
  }
  
  
  //################################################################  
  //prints rows vertically, cols horisontally
  //################################################################
  function write_inverted ( $title = null) 
  {
    print "<table  cellpadding=1 cellspacing=0 border=1 >";
    print "<tr><th></th><th class=result colspan=".$this->row_no().">$title</th></tr>";
            
    foreach ( $this->fieldname as $fname ) 
    {
      print "<tr>";	
      $cell = $this->header[$fname];
      print $cell->html(). "\n";
      
      foreach ( $this->matrix as $row)
      {
      	$cell = $row[$fname];
        print $cell->html() ."\n";
      }
      
      print "</tr>\n";
    } 
    print "</table>" ;
  }

  
  //################################################################
  //deletes column from matrix including field names   
  //Input:  column name
  //################################################################
  function del_col ( $col) 
  {
    // get field name if parameter is index
    $fname =  is_numeric( $col ) ?  $this->fieldname[$col] : $col;

    for ( $row=0; $row < $this->row_no() ; $row++ ) {
       unset ( $this->matrix[$row][$fname] );
    }

    $i = $this->field_idx($fname);
    unset ( $this->fieldname[$i] );  
    
    $i=0;
    foreach ( $this->fieldname as $name) {
      $new[$i++] = $name;
    }
    $this->fieldname = $new;
    
    unset ( $this->header[$fname] );  
  }


  //################################################################
  //removes duplicate column values, leaving only the first one
  //################################################################
  function del_dups ( $fname) 
  {
    if ( $this->row_no() == 0 )
      return;

    $prev_val = null;
    $span = 0; 
    for ( $i=0; $i< $this->row_no() ; $i++ )
    {
      $curr_val = $this->matrix[$i][$fname]->value;
      if ( $curr_val == $prev_val )	{
        $this->matrix[$i][$fname]->value   = null; 
        $this->matrix[$i][$fname]->link    = null; 
        $this->matrix[$i][$fname]->caption = null; 
        $this->matrix[$i][$fname]->show =  SHOW_NONE; 
        $span++;
      }  
      else 
      {
        if ($i !=0) 
           $this->matrix[$row][$fname]->rowspan = $span; 

        $prev_val = $curr_val ;
        $span=1; 
        $row=$i;
      } 
    }  

    $this->matrix[$row][$fname]->rowspan = $span; 
  }
  
  //################################################################
  //sets cell property value for the whole column
  //################################################################
  function set_col ( $fname, $prop, $value) 
  {
    for ( $i=0; $i< $this->row_no(); $i++ )
      $this->matrix[$i][$fname]->{$prop} = $value;
  }
  
  
  //################################################################
  // if $idx is null , then add column to the end 
  // table is "faux" by default
  //################################################################
  function add_col ( $fname , $idx = null ) 
  { 
    $this->header[$fname] = new cell($fname);
    $this->header[$fname]->set_th();
        
    // create cell for every row
    for ( $i=0; $i< $this->row_no() ; $i++ )
    {
      $this->matrix[$i][$fname] = new cell( $fname );
    }  
    
    //add this to the end
    if ( is_null( $idx) )
    {
      $this->fieldname[] = $fname;  //add the last
      return;
    } 
     
    //insert and renumber the fieldnames   
    $i=0;
    foreach ( $this->fieldname as $name) 
    {
      if ( $idx == $i ) 
        $new[$i++] = $fname;
       
      $new[$i++] = $name;
    }
    $this->fieldname = $new;
  }
}// End of TabSheet Class

class cell{
//***************************************************************************
// represents a table cell to print
// could be  td or th type
//***************************************************************************
  var $type      = vs_STRING;  
  var $show      = SHOW_VALUE;    
  var $tag       = "td";       
  var $value     = null;          /* title for th */              
  var $link      = null;          /* to make the value to be a link*/
  var $class     = "result";      /* css class , could be set by user , or taken from tabmap */
  var $caption   = null;          // overlib 
  var $colspan   = null;          
  var $rowspan   = null;          
  var $fieldname = null;          //fully qualified field name

  //constructor
  function cell ( $fname ,$value=null , $type=null ) 
  {
  	$this->fieldname = $fname;
    $this->show  = field_attr( $fname , show );
    $this->value =  $value;
    $this->type  = empty($type)  ? field_attr( $fname, type)                : $type;
  }

  /* th/td , set by  set_th/td */
  function set_class ($class) { $this->class = "class=$class"; }
  function set_td () { $this->tag = "td"; }
  function set_th ()
  {
    $this->tag   = "th"; 
    $this->value = field_attr( $this->fieldname , title);
  }


  //sets caption for cell
  function set_caption ( $caption )
  {
    if ( empty($this->link) )
       $this->link = "javascript://";   //dummy href

    $this->caption   = "onmouseover=\"return overlib('$caption');\""
                       ."onmouseout=\"return nd();\"";
  }

  //##################################################################   
  //### html
  //##################################################################   
  function html()
  {
  	$value = $this->value;
  	
    switch ( $this->type )
    {
      case vs_INT   : $style ="text-align: right; " ; break;
      case vs_IMG   : 
      case vs_DATE  : $style ="text-align: center; "; break;
      case vs_STRING: $style ="text-align: left; "  ; break;
      default      :  $style = null ;
    }
 
    //add keywords if attributes are set up
    $style   = empty($style)        ? null : "style='$style'"       ;
    $class   = empty($this->class)  ? null : "class='$this->class'" ;
    $colspan = empty($this->colspan)? null : "colspan=$this->colspan" ;
    $rowspan = empty($this->rowspan)? null : "rowspan=$this->rowspan" ;
    $value   = empty($value)        ? field_attr( $this->fieldname, 'ifnull' ) : $value;   
    
    $href_start = null;
    $href_end   = null;
    if ( !empty($this->link) || !empty($this->caption) )
    {
      $href_start = "<a $class href=$this->link $this->caption>";
      $href_end   = "</a>";
    }
              

    //replace spaces with line breaks <br> if header longer than 6   
    if ( $this->tag == "th"  and strlen($value) > 6 )
      $value = ereg_replace ( "[ ]+","<br>", $value );  
         
    global $authloginurl;  
    switch ( $this->show )
    {
      case SHOW_NONE  : return null;
      case SHOW_LOCK  : if ( $this->tag == "td" )
                       return 
                      "<td $class style='text-align: center;'>&nbsp;"
                     ."<a href=". $authloginurl
                     ." onmouseover=\"return overlib('Members only:login to view');\""
                     ."onmouseout=\"return nd();\">"
                     ."<img src=_images/lock.jpg></a></td>";
                       //for th tag it should be value ( actually title ) printed
      case SHOW_VALUE : return "<$this->tag $class $style $colspan $rowspan>"
                              ."$href_start $value $href_end "
                              ."</$this->tag>"; 
      default         : print "<td>Error: Invalid show attribute(" . $this->show . ") field($this->fieldname)<td>\n";
                        exit;  
    }
  } 
} // end of class cell 

class Match 
{
  var $match = null;       
  function Match($id)
  {
    if ( !self::exists($id) )
      return;

    $res=dbexec("select * from matches where id=$id"); 
    $row = mysql_fetch_assoc($res); 
    foreach ( $row as $fname => $value ) 
       $this->match[$fname] = $value; 
  }	

  function is_good() { 
     if ($this->match) return true; 
  }

  // static one - could be called as Match::exists($id)
  function exists($id) { 
     return dbcount("select count(*) from matches where id=$id") ? true : false  ;
  }

  function get_tour_id() { 
    return $this->match['tour_id']; 
  }

  function get_event_id() { 
    return $this->match['event_id']; 
  }

  function delete() {
    $id = $this->match['id']; 
    return dbexecDML( "delete from matches where id=$id");
  }	
}

class Event 
{
  function exists($id) { 
     return dbcount("select count(*) from events where id=$id") ? true : false  ;
  }

  function get_tour_id($id) { 
    $res=dbexec("select tour_id from events where id=$id");
    return dbresult($res,0,0); 
  }

  function delete($id) {
    return dbexecDML( "delete from events where id=$id");
  }	

  function delete_cascade($id) {
     $ok1 = dbexecDML("delete from events  where       id=$id");
     $ok2 = dbexecDML("delete from draws   where event_id=$id");
     $ok3 = dbexecDML("delete from matches where event_id=$id");

     Diag::log("Event $id cascade deletion: events=$ok1 players=$ok2 matches=$ok3");
     return $ok1 and $ok2 and $ok3; 
  }	

  function total_matches($id) { 
    return dbcount("select count(*) from matches where event_id = $id" );
  }

  #function is_playoff($id) { 
  #   return dbcount("select count(*) from events where id=$id and id=playoff_eid") ? true : false  ;
  #}

}


class Draw 
{
  // returns array    pid->'fullname' 
  function players($eid)
  { 
    $players = array ();       
    $player = new players();
    $res=dbexec("select player_id from draws where event_id = $eid");

    while( $row = mysql_fetch_assoc($res) )
    {
      $pid = $row['player_id'];
      $players[$pid]  = $player->fullname($pid);
    } 

    return $players;
  }

  function total_players ($eid) { 
    return dbcount("select count(*) from draws where event_id = $eid" );
  }

  function remove_player($eid,$pid) {
    return dbexecDML( "delete from draws where event_id=$eid and player_id=$pid");
  }	

  function add_player($id,$pid) {
    return dbexecDML( "insert into draws (event_id,player_id) values ($id,$pid)");
  }	

}



class tours 
{
  var $tour = array ( );       

  function exists($id) { 
    return  empty($this->tour[$id]) ? false : true; 
  }

  //################################################################
  //###                      constructor                         ###
  //################################################################
  function tours()
  {
    $req = "select * from tours"; 
    $res=dbexec($req); 
      
    $row_idx = 0;
    while( $row = mysql_fetch_row($res) )
    {
      $id = dbresult( $res , $row_idx++, "id");	
      foreach ( $row as $col_idx => $value ) 
      {
        $meta  = mysql_fetch_field($res, $col_idx);
        $this->tour[$id][$meta->name] = $value; 
      }
    }
  }	

  function delete($tid) {
    return dbexecDML( "delete from tours where id=$tid");
  }	

  function add_player($tid,$pid) {
    return dbexecDML( "insert into roster (tour_id,player_id) values ($tid,$pid)");
  }	

  function delete_player($tid,$pid) {
    return dbexecDML( "delete from roster where tour_id=$tid and player_id=$pid");
  }	

  function total_events ($tid) { 
    return dbcount("select count(*) from events where tour_id = $tid" );
  }

  function total_players ($tid) { 
    return dbcount("select count(*) from roster where tour_id = $tid" );
  }

  function total_matches ($tid) { 
    return dbcount("select count(*) from matches where tour_id = $tid" );
  }
}



class players 
{
  var $player = array ( );       

  function exists($id)
  { 
    return  empty($this->player[$id]) ? false : true; 
  }
  
  function fullname($id)
  { 
    if (  $this->player[$id]['type'] == 'doubles' )
      return  empty($id) ? null : $this->player[$id]['lastname'] ."/". $this->player[$id]['firstname'];
     else 
      return empty($id) ? null : $this->player[$id]['firstname'] ." ". $this->player[$id]['lastname']; 
  }	

  function shortname($id){ 

     if (empty($id)) return null;

     if ( $this->player[$id]['type'] == 'doubles' )
       return substr($this->player[$id]['lastname' ],0,3) ."/".  substr($this->player[$id]['firstname'],0,3);
     else 
       return substr($this->player[$id]['firstname'],0,1) .".".$this->player[$id]['lastname']; 
  }	

  function type($id){ 
     return $this->player[$id]['type']  ;
  }

  //*****************************************************************
  //  Returns number of matches won by player 
  //******************************************************************
  function tour_wins ($pid, $tid) { 
    $res=dbexec("select count(*) from matches where winner_id = $pid and tour_id=$tid");
    return dbresult($res,0,0); 
  }
  
  
  //*****************************************************************
  //  Returns number of matches won by player 
  //******************************************************************
  function total_matches_played ($pid)
  { 
    $res=dbexec("select count(*) from matches where player1_id = $pid OR player2_id = $pid"  );
    return dbresult($res,0,0); 
  }


  //******************************************************************
  //  Returns number of matches lost by player 
  //******************************************************************
  function tour_losses ($pid,$tid)
  {
    $res=dbexec("select count(*) from matches where 
               (    player1_id = $pid 
                 OR player2_id = $pid  
               )
               AND winner_id != $pid 
               AND tour_id=$tid");

    return dbresult($res,0,0); 
 }

  //******************************************************************
  //  Returns number of matches lost by player 
  //******************************************************************
  function tour_rating($pid,$tid)
  {
    $win_no  = $this->tour_wins($pid,$tid);
    $loss_no = $this->tour_losses($pid,$tid);
    $total_no = $win_no + $loss_no; 
    return sprintf( "%01.2f" , $win_no * $total_no/($loss_no+1));
 }
  
 
 
//*****************************************************************
  //  Returns number of matches won by player 
  //******************************************************************
  function event_wins ($pid, $eid) { 
    return dbcount("select count(*) from matches where winner_id = $pid and event_id=$eid");
  }


  //******************************************************************
  //  Returns number of matches lost by player 
  //******************************************************************
  function event_losses ($pid,$eid)
  {
    $res=dbexec("select count(*) from matches where 
               (    player1_id = $pid 
                 OR player2_id = $pid  
               )
               AND winner_id != $pid 
               AND event_id   =$eid");

    return dbresult($res,0,0); 
 } 
 
  //################################################################
  //###                      constructor                         ###
  //################################################################
  function players()
  {
    $req = "select * from players"; 
    $res=dbexec($req); 
      
    $row_idx = 0;
    while( $row = mysql_fetch_row($res) )
    {
      $pid = dbresult( $res , $row_idx++, "id");	
      foreach ( $row as $col_idx => $value ) 
      {
        $meta  = mysql_fetch_field($res, $col_idx);
        $this->player[$pid][$meta->name] = $value; 
      }
    }
  }	

  
  function delete($pid)
  {
    return dbexecDML( "delete from players where id=$pid");
  }	
}

 

class TableForm
####################################################################################
//contains fields array 
// usage:
// tab->field['player']->type
####################################################################################
{
  var $name="";  
  var $hidden_field = array();  //  ( 'return'=>'yes' , 'action'=>'add' );
  var $field        = array();  // "field"->class field
  var $action_url   ;   

  function TableForm ( $tablename )
  {
    $this->name = $tablename;
    $res = dbexec("show fields from $tablename");
    $this->action_url   = $_SERVER['SCRIPT_NAME'];   
     
    while( $row = mysql_fetch_assoc($res) )
    {
      $fname = $row['Field'];
      $this->field[$fname] = new FormField($row,$tablename); 
    } 
  }      

  function add_hidden_field($fname,$value)  { 
     $this->field[$fname] = $value;
  }

  function delete_field($fname)  { 
     unset( $this->field[$fname]);
  }
  
 function html()
 {

    print "<form name=$this->name action=$this->action_url target=_self>\n";     
    print "<table>\n";    
     
    foreach ( $this->field as $f )
    {
      print "<tr><!--th>$f->name</th--><th align=left>$f->title</th><td>" 
            . $f->html() 
            . "</td><td>$f->message</td></tr>\n";
    } 
    
    foreach ( $this->hidden_field as $name => $value )
    {
      print "<input type=hidden name=$name value='$value'>\n";
    } 

    ?>    
    </table>
      <input type=submit value=submit name=return>
    </form>     
    <?    
  }

  function set_javascript($fname, $script) {
     $this->field[$fname]->set_javascript ($script);
  }


  function set_readonly($fname, $boolean) {
     $this->field[$fname]->set_readonly ($boolean);
  }

  function set_value($fname,$fvalue)  { 
     $this->field[$fname]->set_value ($fvalue);
  }

  function set_values_from_response()
  {  
    $is_error_found = false;

    foreach ( $this->field as $f )
    {
      if( empty( $_GET[ $f->name ] ))
      {  
        if ( $f->is_mandatory() )  
        {
          Diag::error('Field <b>'. $f->title .'</b> is mandatory:'  );
          $f->message = '<font color=red>This field is mandatory</font>';
          $is_error_found = true;
        }
      }
      else
        $this->set_value($f->name,  $_GET[ $f->name ] );
    } 
    
    return $is_error_found;
  }



  //assign values to form's fields from row 
  function set_values_from_table($fname,$fvalue)
  {  
    $res = dbexec("select * from ".$this->name." where $fname = '$fvalue'");
    $row = mysql_fetch_assoc($res); 
    foreach ( $this->field as $f )
    {
        $this->set_value($f->name , $row[$f->name]);
    }
  }

  
  function insert()
  {
    $values = array();    
    $names  = array();
    foreach ( $this->field as $f )
    {
      if ( $f->extra == 'auto_increment')
        continue; //$value = "''"; 

      $value =  empty( $f->value ) ?  'NULL' :     '\''. $f->value .'\'' ;         
      array_push ( $values ,  $value );      
      array_push ( $names  , $f->name);
    } 

    $sql = "insert into ". $this->name 
          ."(".  implode(',',$names)  .")"      
          ."values" ."(".  implode(',', $values )  .")" ;     

    return dbexecDML($sql); 
  }  

  
  // modifies row with all form values. "Where" clause is provided as  $fieldname => $val
  function update($where_key,$where_val)
  {
    $pairs = array();
    foreach ( $this->field as $f )
    {
      if ( $f->extra == 'auto_increment')
        continue; //$value = "''"; 

      $value =  empty( $f->value ) ?  'NULL' :     '\''. $f->value .'\'' ;      
      array_push ( $pairs ,  $f->name . "= $value" );      
    } 

    $sql = "update ". $this->name ." SET ".  implode(',',$pairs). " WHERE $where_key = $where_val";                   
    Diag::log($sql);
    return dbexecDML($sql); 
  }    
}


class FormField
############################################################3
# handles matadata of all db table fields attributes and renders as  form controls
############################################################3
{
  var $name ;
  var $type    = null;    // int,varchar,enum
  var $length  = null;    // number for varchar,int , null for "set" ,"enum" , date
  var $null    = false;   // true(NULL allowed) or  false
  var $key     = null;    // values: PRI(primary)
  var $default = null;    // default value or null
  var $extra   = null;    // auto_increment,
  var $options = array(); // values for enum or set
  var $message = null;    // to provide a diag/err/info message in form
  var $helper = null;     // widgets such as calendar , or calculator  
 
  // HTML attributes 
  var $value;   
  var $readonly = false;   
  var $class;
  var $style;
  var $title;  
  var $javascript;  
  
  
  function FormField ( $row,$table_name )
  {
    $this->name    = $row['Field'];
    $this->null    = $row['Null'] == 'YES' ? true : false;
    $this->default = $row['Default'];
    $this->extra   = $row['Extra'];
    $this->value   = $this->default;
    $this->title   = field_attr( $table_name.'.'.$this->name , title);
    $this->message = $this->is_mandatory() ? '<font color=red>Mandatory</font>' : '';
  
    $type = $row['Type'];
    switch ( $type )
    {
       case 'date'      : $this->type = $type; 
                          $this->length = 10;
                          break;
       case 'datetime'  : $this->type = $type; 
                          $this->length = 20;
                          break;
       default:  
         list( $this->type,$this->length) = split( "[()]",  $type);
         switch ( $this->type )
         {
            case 'enum'      : 
                               eval( "\$values = array($this->length);");
                               $this->length = null; 
                               // this awkward stuff is for cases when we have drop list with pairs of text->values
                               // not the case when we get data from table though. 
                               foreach ( $values as $value)  
                                 $this->options[$value]  = $value; 
                               break;
            case 'int'       :
            case 'varchar'   : break;
            default     :  print "Error: Unsupported field type (" . $this->type . ") field($this->name)<td>\n";
         }
    }
  }

//modifies any field into drop list
//assoc_values=( 1=>'Eugene',2=>'Azril' ... ) 
//default = [ key ]  , where $key belongs to assoc_values
  function set_options($assoc_values=array(),$default=null) 
  {
     $this->options = $assoc_values;
     $this->length  = null; 
     $this->type    = 'enum'; 
     $this->default = $default; 
     if ( is_null($default) )
       $this->options[null] = " ";  // add empty value if default is null

     if ( isset($this->options[$default]) )
        $this->value   = $default; 
     else  
        Diag::abort("Wrong default parameter: it is not a key of first parameter array.");
  }
  
  function is_mandatory() 
  { 
     if (    $this->type == 'enum'             //enum always provides default value
          || $this->extra == 'auto_increment'  //never mandatory, auto stuff
        ) 
        return false;

     return !$this->null;
  }
  
  function get_value($value) {
     $this->value = $value;  
  }

  function set_value($value) {
     $this->default = $value;     // relevant for enum type only 
     $this->value = $value;  
  }

  function set_readonly($boolean) {
     $this->readonly = $boolean;   
  }

  function set_javascript($script) {
     $this->javascript = $script;   
  }

  function is_readonly($boolean) {
     return $this->readonly;   
  }
  
  ############################################################3
  # renders fields as form controls
  ############################################################3
  function html()
  {
    $readonly = $this->readonly ? "readonly=true":"";

    switch ( $this->type )
    {
       case 'int'       :  
       case 'varchar'   :  
       case 'date'      :
       case 'datetime'  : 
         return  "<input $this->class $this->style name=$this->name id=$this->name size=$this->length 
                         maxlength=$this->length value='$this->value' $readonly $this->javascript 
                  > $this->helper $readonly $this->message";
         break;

       case 'enum'      : 
         $out = "<select $this->class $this->style name=$this->name id=$this->name $this->javascript>\n";

         foreach ( $this->options as $value => $text)
         {
           $selected = ( $value == $this->default ) ? "selected" : "";
           $out .= "<option $selected value='$value'>$text </option>\n";
         }
           
         $out .= "</select>\n";

         return $out;
         break;

       default :
         print "Error: Unsupported field type (" . $this->type . ") field($this->name)<td>\n";
         exit; 
    }
  }
}

?>
