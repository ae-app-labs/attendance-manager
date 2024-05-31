<?php

$db = mysql_connect("localhost","admin","pass");

if(!db) 
	echo "no db connect";
else
	$dbsel = mysql_select_db("db_atmgr",$db);	
	

?>