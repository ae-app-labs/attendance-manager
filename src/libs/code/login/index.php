<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link href="../themes/common00.css" type="text/css" rel="stylesheet" />
<link href="../themes/homepage.css" type="text/css" rel="stylesheet" />

<title>Welcome to staff login</title>
</head>

<body>
<div id="outer-wrapper">
  <div id="header"></div>
  
  <div id="contentbox-wrapper">
  	<div id="cb_stud0" class="cb-style">
	  <h3>Message </h3>
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
    </div>
  	<div id="cb_staff" class="cb-style">
	  <h3>Staff Login </h3>
	  <form id="form2" name="form2" method="post" action="manage-check.php">
	    <label>Staff id &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
	    <input type="text" name="textfield2" /></label>
        <p>
          <label>Password :&nbsp;
          <input type="password" name="textfield3" /></label>
        </p>
        <p>&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;
          <input type="submit" name="Submit2" value="Login" />
          <input type="reset" name="Reset" value="Reset">
        </p>
	  </form>
	</div> 
  
  </div>
  <br />
  <div id="content-wrapper">
    <div id="left0-panel">
	  <h4>Left Panel    </h4>
	  <p>asd</p>
	  <p>asd</p>
	  <p>asd</p>
	  <p>&nbsp;</p>
	  <p>asd</p>
	  <p>sd  </p>
    </div>
	<div id="right-panel">
	<img src="../themes/img/fma_bg.jpg" height="160" width="493" />
	Lorem Ipsum dolor sit amet
	
	Lorem Ipsum dolor sit amet Lorem Ipsum dolor sit amet Lorem Ipsum dolor sit ametLorem Ipsum dolor sit amet Lorem Ipsum dolor sit amet Lorem Ipsum dolor sit amet Lorem Ipsum dolor sit amet Lorem Ipsum dolor sit ametLorem Ipsum dolor sit amet</div>
  
  </div>
</div>

  <div id="footer">
  &copy; Mangalam College of Engineering<br />
  Department of Computer Science and Engineering
  
  </div>
  
  
</body>
</html>
