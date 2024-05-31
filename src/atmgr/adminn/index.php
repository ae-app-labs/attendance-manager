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
	  <p><img src="../themes/img/fma_740x140_adminn.jpg" alt="Admin Control panel" width="739" height="140" /></p>
	  <p>Welcome to the Administrator's control panel of The Attendance Manager Software. The following operations can be done from here. Use the navigation above. Some advanced features are available via the Advanced Settings. </p>
	  <ul>
	    <li>Change  Password</li>
	    <li>List add edit staff members  </li>
	    <li>Add Students </li>
	    <li>List Students</li>
	    <li>View Bug Reports</li>
	    <li>Promote a class at the end of a semester</li>
	    <li>Reset the attendance at the end of a semester    </li>
	  </ul>
	  </div>	
  </div>
</div>

 <?php include("../includes/footer.php"); ?>
  
</div>
</body>
</html>
