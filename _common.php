<?
// Warning: this file MUST NOT produce any HTML
// cause it will mess up with following HTTP headers 
// better put it into _prolog.php 

session_start();
require_once "config.php"; 
require_once "lib/common.php";
require_once "lib/diag.php";
require_once "lib/libdbmysql.php";
require_once "lib/libauth.php";
require_once "lib/api.php";

//TODO: make them global   $CLOBAL[privilege];
$privilege = isset($_SESSION['privilege']) ? $_SESSION['privilege'] : 'guest' ;
$loginname = isset($_SESSION['loginname']) ? $_SESSION['loginname'] : null ;

dbopen();
?>
