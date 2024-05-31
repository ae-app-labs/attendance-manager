<?php
/* BackEndHandler 
 * Implementation on Serevr for the AJAX remote update application
 *
 * Author : Midhun Harikumar
 * Centrum inc Software Solutions
 * Date : April 2008
 *
 * $ Version : 1.0
 **/
require_once("../includes/db_connect.php");
require_once("../includes/util_funcs.php");
 
 if(isset($_REQUEST["action"])){
 	// Do some job requested by AJAX Client
 	if($_REQUEST["action"] == "add"){
		// Add a user most propably a student
		$stuName 	=	$_REQUEST["name"];
		$stuDept	=	$_REQUEST["dept"];
		$stuClass	=	$_REQUEST["class"];
		$stuRegno	=	$_REQUEST["reg"];
		
		// Insert the data into the database	
$sql="INSERT INTO `user_student` (`dept`,`stud_name`,`class_id`,`reg_no`) VALUES ('$stuDept','$stuName','$stuClass','$stuRegno')";
		executeQuery($sql,$db);
	
	}
 
 }

?>