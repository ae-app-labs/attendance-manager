<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Welcome to Baker Charitable Trust</title>
<link href="../baker_ss.css" type="text/css" rel="stylesheet" />
<link href="../bci_layout.css" type="text/css" rel="stylesheet" />

<style type="text/css">
<!--
#adminLoginForm {	background-color:#f4f4f4;
	border:1px solid #999999;
	padding:4px;
	width:280px;
	height:110px;
}
-->
</style>
<div align="center"><div id="outer_wrapper">
  <div id="mainNav"><br />
      <br />
      <br />
    <a href="index.php">Home</a> <a href="bci_history.php">History</a> <a href="bci_vision.php">Vision</a> <a href="site_gallery.php">Gallery</a> <a href="site_videos.php">Videos</a> <a href="site_feedback.php">Feedback</a> <a href="site_donate.php">Donate</a> <a href="bci_contact_us.php">Contact Us</a> <a href="bci_about_us.php">About Us</a> </div>
  <div id="fma"> <img src="../img/bci_hdr.jpg" height="157" width="311" alt="Baker Charitable Trust" style="float:left;" /> <img src="../img/bci_hdr_left2.jpg" height="157" width="469" /> </div>
  <div id="homePageLayout">
    <table width="780" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="146" align="left" valign="top"><div id="content_box_small">
          <table width="146" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><img src="../img/content_box_small_top.jpg" width="146" height="32" /></td>
            </tr>
            <tr>
              <td align="left" valign="top" background="../img/content_box_small_bg.jpg"><div id="adminNav" class="contentBoxData">
                <ul>
                  <li><a href="index.php">Home Page</a></li>
                  <li><a href="bci_history.php">History</a></li>
                  <li><a href="bci_vision.php">Vision</a></li>
                  <li><a href="site_gallery.php">Gallery</a></li>
                  <li><a href="site_videos.php">Videos</a></li>
                  <li><a href="site_feedback.php">Feedback</a></li>
                  <li><a href="site_donate.php">Donate</a></li>
                  <li><a href="bci_contact_us.php">Contact Us</a></li>
                  <li><a href="bci_about_us.php">About Us</a></li>
                </ul>
              </div></td>
            </tr>
            <tr>
              <td><img src="../img/content_box_small_btm.jpg" width="146" height="21" /></td>
            </tr>
          </table>
        </div></td>
        <td width="634" align="left" valign="top"><div class="contentBoxData" id="innerPageContent">
          <h3>Administrator Login </h3>
          <p>The administrator can log into the management side of the site using this page. </p>
          <p> <b>
         <?PHP // check for error messages
		echo $msg = "";
		if( isset($_REQUEST["msg"]) )
		{
			switch($_REQUEST["msg"])
			{
				case "logout_complete" : $msg = "You have successfully logged out"; break;
				case "login_failed"   : $msg = "Username and or password is wrong"; break;
				
			}
		}
		echo $msg;

	 ?>
          </b></p>
		  
          <div id="adminLoginForm">
            <form action="manage-check.php" method="post">
			<br />
            <label title="&rdquo;Username&rdquo;">Username :&nbsp;  
            <input name="username" type="text" /></label>
            <br />
            <br />
            <label title="&rdquo;Password&rdquo;">Password :&nbsp;&nbsp;&nbsp;<input type="password" name="password" /></label>
            <br /><br /><input type="submit" name="submit" value="submit" />
            <input type="reset" name="Reset" value="Reset">
            </form>
          </div>
		  
          <br />
        </div></td>
      </tr>
    </table>
  </div></div>
  <div id="footer"><br />
      <br />
    &copy; 2007 Baker Charitable Trust | Powered by <a href="http://www.angelsvista.com" target="_blank">Angelsvista</a></div>
</div>
