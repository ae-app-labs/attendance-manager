<?php
/* M0 - SupportPages / Report Bug
 * Support Pages
 * Date : 22 april 2008
 * @Author : Midhun hk
 **/
 
 error_reporting(0);
 
require_once("../includes/db_connect.php");
require_once("../includes/util_funcs.php");

$showForm	=	true;
$hasError	=	false;
$message	=	"";

if(isset($_POST["Submit"])){
	$showForm	=	false;
	$date = date("d-M-Y");
	$report = addslashes(trim($_POST["txtReport"]));
	$title 	= stripslashes($_POST["txtTitle"]);
	$uname	= stripslashes($_POST["txtUname"]);

if(executeQuery("INSERT INTO atmgr_bugreports (`title`,`user`,`date`,`report`) VALUES ('$title','$uname','$date','$report')",$db))
		$message = "<span class='success'> The data was posted Successfully. Thank you for your response.</span>";
	else{ $hasErrors = true; 
		$message = "<span class='error00'>An Error has occured while trying to access the database. Please check back after some time.</span>";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="shortcut icon" href="../favicon.ico"/>
<link href="../themes/common00.css" type="text/css" rel="stylesheet" />
<link href="../themes/homepage.css" type="text/css" rel="stylesheet" />

<script language="javascript1.2" src="../includes/scripts/customLibrary.js"></script>
<title>Report Bug ::  Attendance Manager</title>
</head>

<body>
<div align="center">
<div id="outer-wrapper">
  <?php include("../includes/topnav.php");?>
  <div id="header"></div>
  
  <div id="content-wrapper">
    <div class="blockButton" align="left" style="padding-bottom:6px;"> 
		<a href="../index.php">Home</a> 
		<a href="su_developers.php">Developers</a> 
		<a href="su_help.php">Help</a> 
		<a href="su_login_help.php?case=general">Login Problems</a> 
		<a href="su_report_bug.php">Report Bug</a> 
		<a href="su_about.php">About</a>
	</div>
    <h4>Repot a Bug  </h4>
	
	<?php if($showForm){ ?>
    <p>Please take a look at the checklist before reporting the bug. </p>
    <ul style="line-height:150%">
      <li>Can you reproduce the error/bug? In that case please describe the steps to   reproduce the error. </li>
      <li>What OS are you using, Win98, WinXP etc? What service packs are installed   etc? </li>
      <li>What browser you are using with version. </li>
      <li>If there is an error message, please specify its contents. </li>
      </ul>
	  
    <form id="form1" name="form1" method="post" action="su_report_bug.php" 
			style="background-color:#fafafa; padding:5px; padding-left:14px;">
	<label>Title : 
	<input name="txtTitle" type="text" id="txtTitle" maxlength="16" />
	</label>
      <label><br />
      <br />
      Bug Description :<br />
      <br />
	  <textarea name="txtReport" cols="60" rows="10" id="txtReport" onkeydown="updateCharCount(this,'txtCount',2048);"></textarea>
	  </label>
      <p>
        <label>Your Name : 
        <input name="txtUname" type="text" id="txtUname" maxlength="16" /></label></p>
      <p>
        <input type="submit" name="Submit" value="Submit" />
        <input type="reset" name="Submit2" value="Reset" />
      </p>
      Enter a maximum of upto 2048 characters :
	  <div id="txtCount"></div>
    </form>
	<?php } else {echo $message;} ?>
    <p>&nbsp;</p>
    </div>
</div>

  <div id="footer">
  &copy; Mangalam College of Engineering<br />
  Department of Computer Science and Engineering
  
  </div>
  </div>
  
</body>
</html>
