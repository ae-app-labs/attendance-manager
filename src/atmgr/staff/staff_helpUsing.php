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

<link href="../themes/common00.css" type="text/css" rel="stylesheet" />
<link href="../themes/st_style.css" type="text/css" rel="stylesheet" />

<link rel="shortcut icon" href="../favicon.ico"/>
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
		    <li>Mark Attendane</li>
	        <li>Students List </li>
	        <li>Attendance Register </li>
		    <li>Change Password</li>
		    <li>Report Generator </li>
		    <li>Logout </li>
		  </ul>
	    </div>
	  <h4>Mark Attendance</h4>
	  <p>On the navigation bar , click on <strong>Mark Attendance</strong>. Select the corresponding <strong>Department</strong>, <strong>Class</strong> and  <strong>Hour</strong> from the drop down menu listed there. If the class if for more than 1 hour, select the appropriate additional hours that would be required as well. Then click Mark Attendance. You will be redirected to a new page having roll number, name and attendance status  of all the students in that class. Mark attendance status by unticking against each absentees. By default everyone is present. </p>
	  <h4>Students List</h4>
	  <p>This page will allow you to list all the students by specifying the semester. Alternatively, you may use the <strong>Search Student</strong> facility to perform an inline search which updates the search list as you type. </p>
	  <h4>Attendance Register </h4>
	  <p>On the navigation bar, Click on Attendance Register. Select the corresponding class from the dropdown menu and enter the date as in the format DD-MMM-YYYY eg : 24-Mar-2008. Then click <strong>View List. </strong> You will be now redirected to a new page showing the entire attendance status of students on that particular date. </p>
	  <h4>Change Password </h4>
	  <p>Staffs can change their  password at any time by clicking on the <strong>Change Password</strong> tab on the navigation bar . </p>
	  <h4 align="justify">Report Generator </h4>
	  <p align="justify">The <strong>Report generator</strong> provides two types of reports. One is student wise in which the complte details of a particular student against his/her register no is displayed. The other one is the complete listing of the atendance of a particular class. The duration of the days can be varie easily with the date picker. </p>
	  <h4 align="justify">Logout</h4>
	  <p align="justify">Pressing this button will end your session and log you out from   the Attendance Manager Software.</p>
	  </div>
	
	
  </div>
</div>

 <?php include("../includes/footer.php"); ?>
  
</div>
</body>
</html>
