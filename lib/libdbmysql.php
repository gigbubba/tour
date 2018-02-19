<?
/* Connects to a database */
function dbopen()
{
	global $conn, $db_base, $db_server, $db_port, $db_user, $db_pass;
	$conn = mysql_connect("$db_server:$db_port", "$db_user", "$db_pass");
	if (!$conn) { echo "Database opening error $db_base\n"; exit; }
}

/*  *	Close the link with database  */
function dbclose()
{
	global $conn;
	mysql_close($conn);
}

/*
 *	Sends a SQL request to the database
 *	Returns the array-structured answer
 */
function dbexec($req)
{
	global $conn,$db_base;	
    $res = mysql_db_query($db_base, $req, $conn);
    if (!$res) 
	{ 
	  Diag::error("Database read/write error :".  mysql_errno());
	  Diag::error(mysql_error()); 
	  Diag::error("Request: $req"); 
	  exit; 
	}
	return $res;
}

//For queries of this kind  "select count(*) ...... "
function dbcount($sql)
{
   $res = dbexec($sql);
   return dbresult($res, 0, 0) ;
}

//returns next increment number of auto_increment field
function db_next_increment_number($table)
{
  $sql = "show table status like '$table'";
  $res=dbexec($sql) ;
  $row = mysql_fetch_assoc($res);
  return $row['Auto_increment'];
}

// used for inserts,deletes and modifies
// it does not exit in case of error
//returns TRUE/FALSE for INSERT/UPDATE/DELETE queries to indicate success/failure. 
function dbexecDML($req)
{
  global $conn,$db_base;
  $res = mysql_db_query($db_base, $req, $conn);

  if (!$res) 
	{ 
	  Diag::error("Database read/write error :".  mysql_errno());
	  Diag::error(mysql_error()); 
	  Diag::error("Request: $req"); 
	}
	
	//Diag::log("dbexecDML: $req");
	return $res;  
}


/* * Parses the answer array to retrieve a specific value of a specific record
 * field:  offset / field name/  table.name */
function dbresult($res, $row_idx, $field)
{
  return mysql_result($res, $row_idx, $field);
}

/*
 *	Returns the number of records in the answer
 */
function dbnum($res)
{
  return mysql_num_rows($res);
}

/* Returns the OID from the last request */
function db_last_id($res)
{
	global $conn;
	return mysql_insert_id($conn);
}
?>
