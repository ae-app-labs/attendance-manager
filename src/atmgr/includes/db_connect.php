<?php
/* db_connect
 * mySQL database Connectivity page
 *
 * date : 18 March 2008
 **/
 
//$db = mysql_connect("localhost","admin","pass");
$db = mysql_connect("localhost","root","root");

if(!$db) 
	echo "Error : Couldnt connect to MySQL Server";
else
	$dbsel = mysql_select_db("db_atmgr",$db);	// select our database
	
$staffDefaultPasword = "test";
?>