<?php
/* M1 - Staff Management
 * Manage Usability for Staff Members
 * Date : 18 March 2008
 * @Author : Midhun hk
 * 
 * [6:35 PM 3/18/2008] Sucessfully added session to the Staff Interface
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
	  <p><img src="../themes/img/fma_staff/fma_740x140_main.jpg" alt="Staff FMA" width="739" height="140" /></p>
  	  <p><span style="font-weight:bold; margin-bottom:4px;"><?php echo "Welcome ".$_SESSION['staff_name']; ?></span></p>
	  <p>Welcome to the main page for the Staff. The navigation above will allow you to do the following :</p>
	  <ul class="item-list">
	    <li>Mark Attendance</li>
	    <li>Change your Password</li>
	    <li>View and Edit Students List</li>
	    <li>View Reports</li>
	    <li>Access Help</li>
	    <li>Logout  </li>
	  </ul>
	  </div>
	
	
  </div>
</div>

 <?php include("../includes/footer.php"); ?>
  
</div>
</body>
</html>
