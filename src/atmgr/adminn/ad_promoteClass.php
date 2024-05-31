<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="shortcut icon" href="../favicon.ico"/>
<link href="../themes/common00.css" type="text/css" rel="stylesheet" />
<link href="../themes/st_style.css" type="text/css" rel="stylesheet" />

<script language="javascript1.2" src="../includes/scripts/customLibrary.js"></script>
<title>Welcome to Attendance Manager :: Promote Class</title>
<?php
/* Admin / Advanced / Promote Classes
 * Help on using the software
 * Date : 18 March 2008
 * @Author : Midhun hk
 *
 **/

include("login/secure.php");
require_once("../includes/db_connect.php");
require_once("../includes/util_funcs.php");

$message	=	"";
$hasErrors	=	false;
$showUpdateForm = false;
$showPromote234 = true;
$showPromoteS12 = true;

if(isset($_POST["promote432"])){
// Promote 4th years, then 3 and then 2
/* if s7,s5 and s7 exists, change them to s8,s6 and s4
 * if s8,s6 and s4 exists, delete s8 and increment s6 and s4 to s7 and s5
 **/
	// class_id = 7 will be S8 students
	$resS8  = 	executeQuery("SELECT * FROM user_student WHERE class_id = 7",$db);
	if(mysql_num_rows($resS8) > 0 )
		executeQuery("DELETE FROM user_student WHERE class_id = 7",$db);	// delete s8 students
		
	// promote all other semesters except s1s2
	executeQuery("UPDATE user_student SET class_id = 7 WHERE class_id = 6",$db);
	executeQuery("UPDATE user_student SET class_id = 6 WHERE class_id = 5",$db);
	executeQuery("UPDATE user_student SET class_id = 5 WHERE class_id = 4",$db);
	executeQuery("UPDATE user_student SET class_id = 4 WHERE class_id = 3",$db);
	executeQuery("UPDATE user_student SET class_id = 3 WHERE class_id = 2",$db);
	$showPromote234 = false;
	$message = "2nd 3rd and 4th years clases have been updated....";
}

if(isset($_POST["promote1"])){
// Promote S1-S2 / 1st years to the next near
// make sure that no student for s3 exists, in that case
// s1 s2 not to bve made change
	$res1 = executeQuery("SELECT * FROM user_student WHERE class_id = 2",$db);
	if(mysql_num_rows($res1) > 0)
	{
	// hey there are some students in s3
		$hasErrors = true;
		$message   = "Please promote the 2nd 3rd and 4th years first";
	}
	else{
		executeQuery("UPDATE user_student SET class_id = 2 WHERE class_id = 1",$db);
		$message = "1st years have been updated....";
		$showPromoteS12 = false;
	}
}
?>

</head>

<body>
<div align="center">
<div id="outer-wrapper">
  <?php include("../includes/topnav.php");?>
  <div id="header"></div>

  <br />
  <div id="content-wrapper">

	<div style="font-weight:bold; margin-bottom:4px;"><?php include("ad_navigation.php");?></div>
	<div id="staff-content">
	  <h4>Promote Classes</h4>
	  <?php 
	  $s = $hasErrors? "error00":"success";
	  echo "<p class=$s>".$message."</p>";
	  ?>
	  <p>Use this page to promote the students of each class to the next semester. There are separate promotion schemes for S1-S2 and other semesters as S1S2 students have one more semester than other students.</p>
	  <p><div style="background-color:#CCCCCC; padding:5px;">
        Note that the details of the S8 students wil be removed as they will not be part of the attendance manager. Make sure that the Attendance for the department is Reset before you do this operations. </p>
		</div>
		<div style="background-color:#e4e4e4; padding:4px;">
	  <p>By pressing the &quot;<strong>Promote 2,3,4 years</strong>&quot; Button the following changes will be made to the database : </p></div>
	  <ul>
	    <li>Students of S3 will have S4 and so on.</li>
	    <li>The details of the S8 students will be removed </li>
	    </ul>
		<?php
		if($showPromote234)
		{
		?>
		<form id="form1" name="form1" method="post" action="ad_promoteClass.php">
		  <input type="submit" name="Submit" value="Promote 2,3,4 years" />
		  <input type="hidden" name="promote432" value="yes" />
	    </form>
		<?php } ?>
		<p>&nbsp;</p>
		<div style="background-color:#e4e4e4; padding:4px;">
	  <p>By pressing the &quot;<strong>Promote 1st years</strong>&quot; button, you will be able to promote the 1st year students / S1S2 students to S3. The following changes will be made to the databse : </p></div>
	  <ul>
	    <li>Students of S1S2 will be changed to S3. </li>
	    </ul>
		<?php
		if($showPromoteS12)
		{
		?>
	  <form id="form2" name="form2" method="post" action="ad_promoteClass.php">
	    <input type="submit" name="Submit2" value="Promote 1st years" />
		<input type="hidden" name="promote1" value="yes" />
	    </form>
		<?php } ?>
	  <p>&nbsp;</p>
	</div>


  </div>
</div>

 <?php include("../includes/footer.php"); ?>

</div>
</body>
</html>
