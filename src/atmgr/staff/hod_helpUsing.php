<?php
/* M1.3 - Staff Management / Help on using
 * Help on using the software
 * Date : 18 March 2008
 * @Author : Midhun hk
 * 
 **/

require_once("../includes/db_connect.php");
include("login/secure.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="shortcut icon" href="../favicon.ico"/>
<link href="../themes/common00.css" type="text/css" rel="stylesheet" />
<link href="../themes/st_style.css" type="text/css" rel="stylesheet" />


<title>Welcome to Attendance Manager :: Staff Control Panel</title>
</head>

<body>
<div align="center">
<div id="outer-wrapper">
  <?php include("../includes/topnav.php");?>
  <div id="header"></div>
  
  <br />
  <div id="content-wrapper">
  
<div style="font-weight:bold; margin-bottom:4px;"></div>
<?php include("staff_navigation.php")  ?>
	<div id="staff-content">
	  <p><img src="../themes/img/fma_staff/fma_740x140_help.jpg" alt="Help" width="739" height="140" /></p>
	  <div id="overviewBlock">
		  <p class="small-heading">Section Overview </p>
		  <ul>
		    <li>Manage Staff </li>
	        <li>Students List </li>
		    <li>Reset attendance</li>
		    <li>Promote Class  </li>
	      </ul>
	    </div>
	  <h4>Manage Staff </h4>
	  <p align="justify">This section is used to Remove, Edit and Reset the Password of a staff member. The page will list the staff members in your department and the options that you can perform against their names.</p>
	  <h4 align="justify">Students List</h4>
	  <p align="justify">The Students List page lets you select a class from your department and lists the students details of that class. Then you can modify the student details from the same page.</p>
	  <h4 align="justify">Reset Attendance &amp; Promote Class </h4>
	  <p align="justify">At the end of a semester or beginning of a new semester 'Reset Attendance' and 'Promote Class' have to be done. In doing so the attendance listing table will be emptied and students will be promoted to the next higher class. </p>
	</div>
	
	
  </div>
</div>

 <?php include("../includes/footer.php"); ?>
  
</div>
</body>
</html>
