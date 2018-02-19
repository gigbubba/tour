<html>
<link href="<?echo $url?>/default.css" rel="stylesheet" type="text/css">

<?  $who = $loginname ? "User: $loginname ($privilege)" : 'guest'; ?>

<table cellpadding="0" cellspacing="0" border=0 width=100%>
<tr>
  <td colspan=2 height=20 width=200></td>
  <td align=right>         <?echo "$who@$db_server" ?> </td>
</tr>
<tr>
  <td colspan=3 height=1  class=shade_top></td>
</tr>
<tr>
 <td id=title class=toc-hdr height=20 class=toc-hdr><? echo $title ?></td>
</tr>
</table>

<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<script language="JavaScript" src="<?echo $url?>/js/overlib/overlib.js"> </script>

<script language="JavaScript">
//Dynamically Changes title of main page
function set_tag_text(id,val)
{
 document.getElementById(id).innerHTML = "&nbsp;" + val;
 return false;
}
</script>


<!-- menu script itself. you should not modify this file -->
<link rel="stylesheet" href="<?echo $url?>/js/tigra_menu/menu.css">
<script language="JavaScript" src="<?echo $url?>/js/tigra_menu/menu.js">      </script>
<script language="JavaScript" src="<?echo $url?>/js/tigra_menu/menu_items.js"></script>
<script language="JavaScript" src="<?echo $url?>/js/tigra_menu/menu_tpl.js">  </script>
<script language="JavaScript">
	<!--//
	// Note where menu initialization block is located in HTML document.
	// Don't try to position menu locating menu initialization block in
	// some table cell or other HTML element. Always put it before </body>

	// each menu gets two parameters (see demo files)
	// 1. items structure
	// 2. geometry structure

	new menu (MENU_ITEMS, MENU_POS);
	// make sure files containing definitions for these variables are linked to the document
	// if you got some javascript error like "MENU_POS is not defined", then you've made syntax
	// error in menu_tpl.js file or that file isn't linked properly.
	// also take a look at stylesheets loaded in header in order to set styles
	//-->
</script>

<? if ( isset($_GET['debug'])) 
     {
       echo '<pre>';
       echo '_SESSION ' ;
       echo var_dump($_SESSION);
       echo '_GET '; 
       echo var_dump($_GET);
       echo '</pre>';
     }
?> 



