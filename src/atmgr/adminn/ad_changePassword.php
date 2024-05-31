<?php
/* M5 - Administrator Module
 * Project administrator page
 * Date : 18 April 2008
 * @Author : Midhun hk
 * 
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
	 $sql="SELECT aid FROM user_adminn WHERE aname ='".$_SESSION['admin_name']."' AND apass = '$oldPass'";
	 //echo $sql; // debug
	 $res = mysql_query($sql,$db);
	 if(mysql_num_rows($res)!=0)
	 {
		$sql = "UPDATE user_adminn SET apass ='$newPass' WHERE aid = ".$_SESSION['admin_id'];
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
<?php echo $msg; ?>
	<div id="staff-content">
	  <p><img src="../themes/img/fma_staff/fma_740x140_changePass.jpg" alt="Admin Control panel" width="739" height="140" /></p>
	  <form id="frm_changePassword" name="frm_changePassword" method="post" action="ad_changePassword.php">
        <label>Current Password &nbsp;:
          <input name="oldPass" type="password" class="cleanInputBox" />
        </label>
        <p>
          <label>New Password &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
            <input name="pass1" type="password" class="cleanInputBox" />
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
	    </form>
	  <p>&nbsp;</p>
	  </div>	
  </div>
</div>

 <?php include("../includes/footer.php"); ?>
  
</div>
</body>
</html>
