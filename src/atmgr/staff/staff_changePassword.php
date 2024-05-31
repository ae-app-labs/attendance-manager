<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="shortcut icon" href="../favicon.ico"/>
<link href="../themes/common00.css" type="text/css" rel="stylesheet" />
<link href="../themes/st_style.css" type="text/css" rel="stylesheet" />

<script language="javascript1.2" src="../includes/scripts/passstr/ajaxforms.js"></script>
<?php
/* M1.2 - Staff Management / Change Password
 * Sub Module for changing password of Staff
 * Date : 18 March 2008
 * @Author : Midhun hk
 * 
 * [7:40 PM 3/18/2008] Completed Sub Module
 * [10:21 PM 11/26/2008] Implementing password strength chechker
 **/

include("login/secure.php");
require_once("../includes/db_connect.php");

$msg = false;
$hasErrors = false;

if(isset($_POST['submit'])){
	if($_POST['pass1'] == $_POST['pass2'])
	{
		$oldPass = md5($_POST['oldPass']);
		$newPass = md5($_POST['pass1']);
	 $sql="SELECT staff_id FROM user_staff WHERE staff_name ='".$_SESSION['staff_name']."' AND password = '$oldPass'";
	 //echo $sql; // debug
	 $res = mysql_query($sql,$db);
	 if(mysql_num_rows($res)!=0)
	 {
		$sql = "UPDATE user_staff SET password ='$newPass' WHERE staff_id = ".$_SESSION['staff_id'];
		//echo $sql;
		$res = mysql_query($sql,$db);
		if($res)
		{
			$msg = "Successfully Changed your password.";
		}
		else {$hasErrors = true; $msg = "An Error has occured";}
	 }
	 else {$hasErrors = true; $msg = "Specified password is incorrect.";}	
   }
   else {$hasErrors = true; $msg = "Passwords do not match.";}
}
?>

<title>Welcome to Attendance Manager :: Staff Control Panel</title>
</head>

<body>
<div align="center">
<div id="outer-wrapper">
  <?php include("../includes/topnav.php");?>
  <div id="header"></div>
  
  <br />

  <div id="content-wrapper">  

	<?php include("staff_navigation.php")  ?>

	<div id="staff-content">
	 <h4 align="left"> <img src="../themes/img/fma_staff/fma_740x140_changePass.jpg" alt="Change Password" width="739" height="140" /></h4>
	  <form id="frm_changePassword" name="frm_changePassword" method="post" action="staff_changePassword.php">
	    <label>Current Password &nbsp;:
	      <input name="oldPass" type="password" class="cleanInputBox" />
	      </label>
	    <p>
	      <label>New Password &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
          <input name="pass1" type="password" class="cleanInputBox"  onKeyUp="alert(this.value);/*javascript:get(this.parentNode);*/" />
	      </label>
	    </p>
	    <p>
	      <label>Retype Password &nbsp;&nbsp;:
          <input name="pass2" type="password" class="cleanInputBox" />
	      </label>
	    </p>
	    <p>
	      <input type="submit" name="submit" value="Submit" />
	      <input type="reset" name="reset" value="Reset" />
	    </p>
		<span id="checkPassStrengthResult"></span>
	  </form>
	  <p>
	  <?php
	  	$c = $hasErrors?"error00":"success";
		if($c == "error00")
			echo "<span class=$c><div id='error-icon'></div>$msg</span>";	  
	  ?>  
	  </p>
	  </div>
	
	
  </div>
</div>

 <?php include("../includes/footer.php"); ?>
  
</div>
</body>
</html>
