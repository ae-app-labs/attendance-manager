<?php
/* M5 - Administrator Module
 * Project administrator page
 * Date : 18 April 2008
 * @Author : Midhun hk
 * 
 **/

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

	<div id="staff-content">
	  <p><img src="../themes/img/fma_740x140_adminn.jpg" alt="Admin Control panel" width="739" height="140" /></p>
	  <form id="frm_staffLogin" name="frm_staffLogin" method="post" action="login/manage-check.php"
	  style="background-color:#f4f4f4; border-right:#333333 1px solid;border-bottom:#333333 1px solid; width:250px; padding:10px; padding-top:2px !important;">
		<h4>Admin Login</h4>
        <label>
        Staff id &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
          <input type="text" name="username" />
          </label>
        <br />
        <br />
        <label>Password :&nbsp;
        <input type="password" name="password" />
          </label>
  &nbsp;&nbsp;&nbsp; <br />
  <br />
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;
  &nbsp;&nbsp;
  <input type="submit" name="submit" value="Login" />
            <input type="reset" name="Reset" value="Reset" />
            <div style=" font-size:11px;">
              <?php if($msg) echo "<br>".$msg;?>
            </div>
	    </form>
	  <p>&nbsp;</p>
	  </div>	
  </div>
</div>

 <?php include("../includes/footer.php"); ?>
  
</div>
</body>
</html>
