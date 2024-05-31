<?php
/* M5 - Administrator Module
 * Project administrator page
 * Date : 18 April 2008
 * @Author : Midhun hk
 * 
 **/

include("login/secure.php");
require_once("../includes/db_connect.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="shortcut icon" href="../favicon.ico"/>
<link href="../themes/common00.css" type="text/css" rel="stylesheet" />
<link href="../themes/st_style.css" type="text/css" rel="stylesheet" />
<script language="javascript1.2" src="../includes/scripts/customLibrary.js"></script>

<title>Welcome to Attendance Manager :: Staff Control Panel</title>
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
	  <p><img src="../themes/img/fma_staff/fma_740x140_help.jpg" alt="Help" width="739" height="140" /></p>
	  <h4>How to use</h4>
	  <div id="overviewBlock">
        <p class="small-heading">Section Overview </p>
	    <ul>
          <li>Manage Staff </li>
	      <li>Change Password</li>
	      <li>Logout </li>
	      </ul>
	    </div>
	  <h4>Manage Staff</h4>
	  <p align="justify">This page allows you to add a new staff or to delete an existing member. By default, all the staff members are listed on the page. The Delete button next to each user enables you to delete that user from the table. The program will prompt you whether you really want to remove this entry. If you want to proceed, press the Yes at the next prompt.</p>
	  <h4 align="justify">Change Password</h4>
	  <p align="justify">You can change your  password at any time by clicking on the <strong>Change Password</strong> tab on the navigation bar . </p>
	  <h4 align="justify">Logout</h4>
	  <p align="justify">Pressing this button will end your session and log you out from   the Attendance Manager Software. </p>
	</div>	
  </div>
</div>

 <?php include("../includes/footer.php"); ?>
  
</div>
</body>
</html>
