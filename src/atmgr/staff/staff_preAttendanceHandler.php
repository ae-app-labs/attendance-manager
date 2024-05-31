<?php
/* M1.1 - Staff Management / Mark Attendance Handler
 * Get parameters for marking attendance
 * Date : 18 March 2008
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

<link href="../themes/common00.css" type="text/css" rel="stylesheet" />
<link href="../themes/st_style.css" type="text/css" rel="stylesheet" />


<title>Welcome to Attendance Manager :: Staff Control Panel</title>
</head>

<body>
<div align="center">
<div id="outer-wrapper">
  <?php include("../includes/topnav.php"); ?>
  <div id="header"></div>
  
  <br />
  <div id="content-wrapper">
  
<div style="font-weight:bold; margin-bottom:4px;"></div>
<?php include("staff_navigation.php");  ?>
	<div id="staff-content">
	  <p><img src="../themes/img/fma_staff/fma_740x140_preAtten.jpg" width="739" height="140" alt="Pre Attendance Handler" /></p>
	  <p>Select the department, the class and the hour for marking the attendance. Clicking in the button &quot;Mark Attendance&quot; will give you a new page with the listing of all the students from the specified class. </p>
	  <form id="f_studAttenSelect" name="f_studAttenSelect" method="post" action="staff_markAttendance.php">
  	    <label>1. Select Department :
		<select name="lstDept">
		<!-- Dynamically insert departments -->
		<?php 
			$sql = "SELECT * FROM department";
			$res = mysql_query($sql,$db);
			if(mysql_num_rows($res))
			{
				while($row = mysql_fetch_row($res))
					echo "<option value=\"$row[0]\">$row[1]</option>\r";
			}
		?>
        </select>
	    </label>
		
	    <label><br />
	    <br />
	    2. Select the Class &nbsp;&nbsp;&nbsp; :
	      <select name="lstClass">
		  <!-- Dynamically insert classes -->
		<?php 
			$sql = "SELECT * FROM stud_classes";
			$res = mysql_query($sql,$db);
			if(mysql_num_rows($res))
			{
				while($row = mysql_fetch_row($res))
					echo "<option value=\"$row[0]\">$row[1]</option>";
			}
		?>
          </select>
	      </label>

	    <br />
	    <br />
	    <label>3. Select the Hour &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
        <select name="lstHour">
          <option value="1">1st</option>
          <option value="2">2nd</option>
          <option value="3">3rd</option>
          <option value="4">4th</option>
          <option value="5">5th</option>
          <option value="6">6th</option>
        </select>
	    </label>
	    <p>
	      <input type="submit" name="Submit" value="Mark Attendance" />
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
