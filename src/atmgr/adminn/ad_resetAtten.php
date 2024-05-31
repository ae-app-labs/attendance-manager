<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="shortcut icon" href="../favicon.ico"/>
<link href="../themes/common00.css" type="text/css" rel="stylesheet" />
<link href="../themes/st_style.css" type="text/css" rel="stylesheet" />

<script language="javascript1.2" src="../includes/scripts/customLibrary.js"></script>
<title>Welcome to Attendance Manager :: Staff Control Panel</title>

<?php
/* M1.3 - Staff Management / Help on using
 * Help on using the software
 * Date : 18 March 2008
 * @Author : Midhun hk
 * 
 **/

require_once("../includes/db_connect.php");
require_once("../includes/util_funcs.php");
include("login/secure.php");


$message	=	"";
$hasErrors	=	false;
$showForm   = true;


/***********************
do reset and backup database
***********************/
if(isset($_POST["resetAtten"]))
{
	// Put the total hours for each subjects taken to 0
	executeQuery("UPDATE staff_paper SET total_hours = 0",$db);
	executeQuery("TRUNCATE TABLE stud_attendance",$db);

	$showForm = false;
	$message = "Deleted the contents of the table and reset the no of papers taught to 0....";
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
	  <h4>Reset Attendance </h4>
	  <p>This page can be used to reset the attendance. The following events will take place</p>
	  <ul>
	    <li>student_attendance table will be truncated (emptied). </li>
	    <li>total hours of all papers will be reset to 0</li>
	    </ul>
		<?php
		echo "<b>".$message."</b>";
		if($showForm){
		?>
	  <p>Are you sure you want to reset the attendance details?</p>
 	   <div style="background-color:#f7f7f7; padding:5px; padding-top:14px;">
	  <form id="form1" name="form1" method="post" action="ad_resetAtten.php">
	    <label>Reset :
	      <input type="submit" name="resetAtten" value="Yes" />
	      </label>
	    </form>
		</div>
		<?php } ?>
	  <p>&nbsp;</p>
	  <p>&nbsp;</p>
	</div>
	
	
  </div>
</div>

 <?php include("../includes/footer.php"); ?>
  
</div>
</body>
</html>
