<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="shortcut icon" href="favicon.ico"/>

<!-- Load StyleSheets -->
<link href="themes/common00.css" type="text/css" rel="stylesheet" />
<link href="themes/homepage.css" type="text/css" rel="stylesheet" />

<!-- Load js files -->
<script language="javascript1.2" src="includes/scripts/customLibrary.js"></script>
<script language="javascript1.2" src="includes/scripts/validateLogin.js"></script>
<script language="javascript1.2" src="includes/scripts/swfobject.js"></script>
<title>Welcome to Attendance Manager</title>

<?php
/* M0 - CommonInterface
 * Common Usability Interfac + login forms
 * Date : 18 March 2008
 * @Author : Midhun hk
 **/

include("includes/db_connect.php");

// check for error messages from the login script
$msg = false;
if( isset($_REQUEST["msg"]) )
{
 	switch($_REQUEST["msg"])
	{
		case "logout_complete": $msg = "<span class='success'><br>You have successfully logged out</span>"; break;
		case "login_failed"   : $msg = "<span class='error00'><br>Username and or password is wrong</span>"; break;
		case "invalid_session": $msg = "<span class='error00'>The current session seems to be invalid.</span>"; break;
 	}
}
?>
</head>

<body>
<div align="center">
<div id="outer-wrapper">
  <?php include("includes/topnav.php");?>
  <div id="header"></div>

  <div id="contentbox-wrapper">
  	<div id="cb_stud0" class="cb-style">
	  <h3>Check Attendance </h3>
	  <!-- Student Show Attendance -->
	  <form id="frm_studCheck" name="frm_studCheck" method="get" action="stud/stud_details.php"
	  		onsubmit="return validateStudentLogin(document.frm_studCheck);">
	    <label>Student Regno: <input type="text" name="stud_regno" /> </label>
        <p><!-- validateStudentLogin(this.form) -->
		<input type="submit" name="Submit" value="Check" />
<!--		<input type="hidden" name="studCheck_submit" value="true" /> -->
		</p>
	  </form>
  	</div>

	<div id="cb_staff" class="cb-style">
	  <h3>Staff Login </h3>
	  <!-- new login with session-->
	  <form id="frm_staffLogin" name="frm_staffLogin" method="post"
	  		action="staff/login/manage-check.php" 	onsubmit="return validateStaffLogin(document.frm_staffLogin);">
        <label>Staff id &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type="text" name="username" /></label>
        <br />
        <br />
        <label>Password :&nbsp;
        <input type="password" name="password" /></label>
	    &nbsp;&nbsp;&nbsp;
	      <br />
	      <br />
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      &nbsp;
              <input type="submit" name="submit" value="Login" />
              <input type="reset" name="Reset" value="Reset" />
			  <div style=" font-size:11px;">
				<?php if($msg) echo "<br>".$msg;?>
  			  </div>
	    </form>

	</div>
	<div id="cb_column3" class="cb-style">
	  <img src="themes/img/cb_divider.jpg" width="2" height="154" style="float:left" />
	  <div style="padding-left:10px;" class="cb-help-links">
		<h3>Quick Help</h3>
	    <p><a href="support/su_login_help.php?case=general">Login Problems?</a> </p>
	    <p><a href="support/su_login_help.php?case=forgot_pass">Forgot Password? </a></p>
	    <p><a href="support/su_report_bug.php">Report a Bug </a></p>
	    <p><a href="adminn">Administrator Login</a></p>
	  </div>
	</div>

  </div>
  <div id="content-wrapper">
    <table width="740" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top" id="left0-panel"><h4>Latest News </h4>
            <ul style="line-height:180%;">
              <li>Revising staff, admin and report generation modules for final implementation. [7:23 PM 9/26/2008] </li>
              <li>Installed custom date picker for staff module. [6:20 PM 4/17/2008] </li>
              <li>Staff login uses <strong>MD5  encryption algorithm</strong> to store and process passwords for better security. [2:40 PM 3/31/2008] </li>
              <li>Completed the Student Attendance Display module. [11:52 PM 3/29/2008] </li>
              <li>Completed base sections for Staff Management [11:58 PM 3/22/2008] </li>
              <li>AJAX based Students list retriever [10:10 AM 1/3/2009]</li>
              <li>Some Major bug fixes fixed in login section, marking attendance and report generation. [5:18 PM 1/9/2009] </li>
            </ul>
          <p>&nbsp;</p>
		</td>
        <td valign="top">
        <div id="right-panel">
			
            <div align="right" id="fma">
				<img src="themes/img/fma_bg.jpg" height="160" width="493" />
			</div>
            
	<script type="text/javascript">
	   var so = new SWFObject("includes/active/fma_home_en.swf", "home_fma", "494", "160", "6");
	   so.write("fma");
	</script>

          <p align="justify" style="line-height:160%;">&nbsp;&nbsp;&nbsp;&nbsp;Attendance Manager is a database driven application for keeping track of the attendance for all the studenst of the colege. It has been done in a very module oriented and scalable format and also with an eye out for future developments. </p>
          <p align="justify" style="line-height:160%;">&nbsp;&nbsp;&nbsp;&nbsp;The program is structured around the following types of users.</p>
          <ul style="line-height:150%;">
            <li>Administartor</li>
            <li>Staff Member</li>
            <li>Student </li>
          </ul>
          <p align="justify" style="line-height:160%;">&nbsp;&nbsp;&nbsp;&nbsp;The interface provided by this software is very user friendly. Though this project is still in Beta state, we have worked hard to incorporate the latest technologies for maximum productivity. </p>
          <p align="justify" style="line-height:160%;">&nbsp;&nbsp;&nbsp;&nbsp;Manging of students, entering the attendance and retrieving the reports in a number of ways are provided. Also included is the state of the art Students List retriever using the AJAX technology. Please report any bugs or modifications that you may want to incorporate in the future releases of the software.</p>
        </div></td>
      </tr>
    </table>
  </div>
</div>

  <div id="footer">
  &copy; Mangalam College of Engineering<br />
  Department of Computer Science and Engineering

  </div>
  </div>

</body>
</html>
