<?php
/* M0 - SupportPages / Developers
 * Support Pages
 * Date : 18 March 2008
 * @Author : Midhun hk
 **/
 
// error_reporting(0);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="shortcut icon" href="../favicon.ico"/>
<link href="../themes/common00.css" type="text/css" rel="stylesheet" />
<link href="../themes/homepage.css" type="text/css" rel="stylesheet" />

<title>Login Help ::  Attendance Manager</title>
</head>

<body>
<div align="center">
<div id="outer-wrapper">
  <?php include("../includes/topnav.php");?>
  <div id="header"></div>
  
  <div id="content-wrapper" style="line-height:150%;">
    <div class="blockButton" align="left" style="padding-bottom:3px;"> 
		<a href="../index.php">Home</a> 
		<a href="su_developers.php">Developers</a> 
		<a href="su_help.php">Help</a> 
		<a href="su_login_help.php?case=general">Login Problems</a> 
		<a href="su_report_bug.php">Report Bug</a> 
		<a href="su_about.php">About</a>
	</div>
    <h4>Login Help </h4>
    <p>
	<?php if($_REQUEST["case"] == "general"){ ?>
	<h4>Login Problems?</h4>
	<p>If you are unable to login to the software,</p>
	<ul>
	  <li>The password and or username specified may be wrong</li>
	  <li>The Server may be down for some reason  </li>
	  <li>The program is updated and or maintained</li>
	  </ul>
	<p>Please try to login using the correct username + password combination else wait for some time and try again. </p>
	<?php } ?>
	
	<?php if($_REQUEST["case"] == "forgot_pass"){ ?>
	<h4>Forgot Password?</h4>
	<p>It is important to keep notice that the login system uses MD5 Encryption algorithm to protect the passwords. Since MD5 is a one way encryption method, there is no way your password can be retrieved.</p>
	<p>If you have forgotten you password, please request the administrator to reset your password. After the password is reset, you may login using the default password and immediately change it to a new one.</p>
	<p>
	  <?php }	?>
	  </p>
    </p>
	<p>For further queries, contact the developers.</p>
    </div>
</div>

  <div id="footer">
  &copy; Mangalam College of Engineering<br />
  Department of Computer Science and Engineering
  
  </div>
  </div>
  
</body>
</html>
