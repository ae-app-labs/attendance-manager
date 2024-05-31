<?php
/********************************************************/
/* Main App Page										*/
/********************************************************/

/* M1.9 - Staff Management / Report Generator
 * Report Generator
 * Date : 22 April 2008
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

<link rel="shortcut icon" href="../favicon.ico"/>
<link href="../themes/common00.css" type="text/css" rel="stylesheet" />
<link href="../themes/st_style.css" type="text/css" rel="stylesheet" />

<script language="javascript1.2" src="../includes/scripts/customLibrary.js"></script>
<script language="javascript1.2" src="../includes/scripts/popUpWindow.js"></script>
<script language="JavaScript1.2" src="../includes/scripts/overlib_mini.js"></script>
<script language="JavaScript1.2" src="../includes/scripts/date-pick.js"></script>
<script language="javascript1.2">

var reportPage = "atmgr_report.php"; // The report page
var r = Math.round(10000*Math.random()); // A Random number

//	var selectedValue =  r.options[r.selectedIndex].value;

function doStudentReport(f){
	if(f.txtRegno.value == "" || isNaN(f.txtRegno.value))
	{alert("Register number should be a number."); return false;}
	
	var m = f.lstMonth;
	var y = f.lstYear;
	
	m = m.options[m.selectedIndex].value;
	y = y.options[y.selectedIndex].value;
	
	var pageCall = reportPage + "?generate=report&whose=student&regno=" + f.txtRegno.value + "&month=" + m + "&year="+y+"&r="+r;
//	alert(pageCall);
	
	popUpWindow(pageCall, 25, 0, 600, 800);
	
	return false;
}


/* showhideitems
 *
 **/
 var currentItem = "";
</script>

<title>Welcome to Attendance Manager :: Report Generator</title>
</head>

<body>
<div align="center">
<div id="outer-wrapper">
  <?php include("../includes/topnav.php"); ?>
  <div id="header"></div>
  
  <br />
  <div id="content-wrapper">
  
<div style="font-weight:bold; margin-bottom:4px;"></div>
<?php include("ad_navigation.php");?>
	<div id="staff-content">
	
	  <h4>Report Generator </h4>
	  <p>You can generate reports of the attendance manager software using this page. The date format must be strictly followed as it is stored in the database. The format is (DD-MMM-YYYY) or (DD-Mon-YYYY). Please Use the pop up calendar.</p>
	  <h4>Student Report</h4>
	  <p>You can the full attendance report for a student for a month ready to be printed out.  Enter the Student's Register No, and select the Month and Year.Note that the page opens in a new window.</p>
	  
	  <form id="form2" name="form2" method="get" style="background-color:#f4f4f4; padding:6px;">
	    <label>Student Register No: <input name="txtRegno" type="text" id="txtRegno" />  </label>
	    <label>Month :
	    <select name="lstMonth" id="lstMonth">
	      <option value="Jan" selected="selected">January</option>
	      <option value="Feb">February</option>
	      <option value="Mar">March</option>
	      <option value="Apr">April</option>
	      <option value="May">May</option>
	      <option value="Jun">June</option>
	      <option value="Jul">July</option>
	      <option value="Aug">August</option>
	      <option value="Sep">September</option>
	      <option value="Oct">October</option>
	      <option value="Oct">November</option>
	      <option value="Dec">December</option>
	      </select>
		</label>
	    <label> Year :
	    <select name="lstYear" id="lstYear">
	      <option value="2008" selected="selected">2008</option>
	      <option value="2009">2009</option>
	      <option value="2010">2010</option>
	      <option value="2011">2011</option>
	      <option value="2012">2012</option>
	      <option value="2013">2013</option>
	      <option value="2014">2014</option>
	      <option value="2015">2015</option>
	      </select>
		</label>&nbsp;&nbsp;&nbsp;
	    <input type="submit" name="Submit2" value="Get Report" onclick="return doStudentReport(this.form);" />
	  </form>
	  
	  <h4>Class Report  </h4>
	  <p>Generate the report for the attendance of the class for a period of time. </p>
	  <form id="form1" name="form1" method="post" action="ad_viewAttendance.php" onsubmit="retrun true;">
	  <input type="hidden" name="report_type" value="class-date" />
	    <label><p>
		1. Select the Department :
				<select name="lstDept">
		  <!-- Dynamically insert departments -->
		  <?php 
			$sql = "SELECT * FROM department";
			$res = mysql_query($sql,$db);
			if(mysql_num_rows($res))
				while($row = mysql_fetch_row($res))
					echo "<option value=\"$row[0]\">$row[1]</option>\r";
		   ?>
		</select>
		</p>
		<p>
	    2. Select the Class&nbsp; :
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
		 </p>
	    <p>
		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
	      <label>3. Enter Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : </label>
	      <input name="txtDate" type="text" id="txtDate" value="<?php echo date("d-M-Y");?>" />
			<a href="javascript:show_calendar('form1.txtDate');" 
				onMouseOver="window.status='Date Picker'; overlib('Click here to choose a date.'); return true;" 
				onMouseOut="window.status=''; nd(); return true;">
					<img src="../themes/img/calendar_icon.png" width=15 height=16 border="0">			</a>		
		</p>
	    <p><input type="submit" name="Submit" value="View List" /></p>
	  </form>
	</div>
  </div>
</div>
<?php include("../includes/footer.php"); ?>
</div>
</body>
</html>
