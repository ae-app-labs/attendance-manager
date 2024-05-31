<?php
/********************************************************/
/* Main App Page										*/
/********************************************************/

/* M1.8 - Staff Management / View Attendance /
 * Mark attendance 
 * Date : 25 March 2008
 * @Author : Midhun hk
 * 
 **/
 

 /********************************************************************
  * Readme :
  * --------
  * View the attendance register for a dept.class for a specific date
  ********************************************************************/

include("login/secure.php");
require_once("../includes/db_connect.php");

// viewAttendanceHandler
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="shortcut icon" href="../favicon.ico"/>
<link href="../themes/common00.css" type="text/css" rel="stylesheet" />
<link href="../themes/st_style.css" type="text/css" rel="stylesheet" />

<script language="javascript1.2" src="../includes/scripts/customLibrary.js"></script>
<script language="javascript1.2">
function validateForm(f)
{
	// check for the correct syntax for the input date string
	//
	var isValid = true; // dd-mmm-yyyy
	var inp_date = f.txtDate.value;
	
	if(isEmpty(inp_date)){alert(MSG_EMPTY_FIELD); return false;}	

	return false;
}
</script>

<script language="JavaScript" src="../includes/scripts/date-pick.js"></script>
<script language="JavaScript" src="../includes/scripts/overlib_mini.js"></script>

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
	
	  <p><img src="../themes/img/fma_staff/fma_740x140_attendanceList.jpg" alt="Attendance List" width="739" height="140" /></p>
	  <form id="form1" name="form1" method="post" action="staff_viewAttendance.php" onsubmit="retrun true;">
	    <label><br />		
	    1. Select the Class&nbsp; :
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
	    <p>
		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
	      <label>2. Enter Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : </label>
	      <input name="txtDate" type="text" id="txtDate" value="<?php echo date("d-M-Y");?>" />
			<a href="javascript:show_calendar('form1.txtDate');" 
				onMouseOver="window.status='Date Picker'; overlib('Click here to choose a date.'); return true;" 
				onMouseOut="window.status=''; nd(); return true;">
					<img src="../themes/img/calendar_icon.png" width=15 height=16 border="0">			</a>		
		</p>
	    <p><input type="submit" name="Submit" value="View List" /></p>
	    <p>&nbsp;</p>
	  </form>
	  <p>The date format must be strictly followed as it is stored in the database. The format is (DD-MMM-YYYY) or (DD-Mon-YYYY). Please Use the pop up calendar or the current date to view the attendance for the day.</p>
	  <p>&nbsp;</p>
	</div>
  </div>
</div>
<?php include("../includes/footer.php"); ?>
</div>
</body>
</html>
