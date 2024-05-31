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
//	var selectedValue =  r.options[r.selectedIndex].value;

function doStudentReport(f){
	if(f.txtRegno.value == "" || isNaN(f.txtRegno.value))
	{alert("Register number should be a number."); return false;}

	var r = Math.round(10000*Math.random()); // A Random number	
	
/*	var m = f.lstMonth;
	var y = f.lstYear;
	
	m = m.options[m.selectedIndex].value;
	y = y.options[y.selectedIndex].value;
	
	var pageCall = reportPage + "?generate=report&whose=student&regno=" + f.txtRegno.value + "&month=" + m + "&year="+y+"&r="+r;*/
	
	var pageCall = reportPage + "?generate=report&type=student&regno=" + f.txtRegno.value + "&r="+r;
//	alert(pageCall);
	
	popUpWindow(pageCall, 25, 0, 650, 500);
	
	return false;
}
function doPaperWiseReport(f){
	if(f.txtRegno.value == "" || isNaN(f.txtRegno.value))
	{alert("Register number should be a number."); return false;}

	var r = Math.round(10000*Math.random()); // A Random number	
	
	var pageCall = reportPage + "?generate=report&type=paperwise&regno=" + f.txtRegno.value + "&r="+r;
	popUpWindow(pageCall, 25, 0, 650, 500);	
	return false;
}
function doClassReport(f){
	var r = Math.round(10000*Math.random()); // A Random number	

	var dateStart = f.txtDateStart.value;
	var dateEnd   = f.txtDateEnd.value;
	var classId   = f.lstClass.options[f.lstClass.selectedIndex].value;

	var pageCall = reportPage + "?generate=report&type=class&classId=" + classId+ "&dateStart=" + dateStart + "&dateEnd=" +dateEnd + "&r="+r;
//	alert(pageCall);
	popUpWindow(pageCall, 25, 0, 650, 500);
	
	return false;
}
</script>

<title>Welcome to Attendance Manager :: Report Generator</title>
</head>

<body>
<div align="center">
<div id="outer-wrapper">
  <?php include("../includes/topnav.php"); ?>
  <div id="header"></div>
  <?php
 
  
  ?>
  <br />
  <div id="content-wrapper">
  
<div style="font-weight:bold; margin-bottom:4px;"></div>
<?php include("staff_navigation.php");  ?>
	<div id="staff-content">
	
	  <h4>Report Generator </h4>
	  <p>The date format must be strictly followed as it is stored in the database. The format is (DD-MMM-YYYY) or (DD-Mon-YYYY). Please Use the pop up calendar. You can save the generated report page by selecting File -&gt; Save As...</p>
	  <h4>Student Report</h4>
	  <p>You can the full attendance details for a student ready to be printed out.  Enter the Student's Register No. Note that the page opens in a new window.</p>
	  
	  <form id="form2" name="form2" method="get" style="background-color:#f4f4f4; padding:6px;">
	    <label>Student Register No: <input name="txtRegno" type="text" id="txtRegno"
        <?php
		if(isset($_REQUEST["action"])){
			if($_REQUEST["action"] == "view_atten")
			echo " value='".$_REQUEST["regno"]."'";		
		}
		?>
         />  </label>
	    &nbsp;&nbsp;&nbsp;
	    <input type="button" name="Submit2" value="Get Report" onclick="return doStudentReport(this.form);" />
		<!--
	    <input type="button" name="Submit3" value="Paper Wise" onclick="doPaperWiseReport(this.form);" />
		-->
	  </form>
	  
	  <h4>Class Report  </h4>
	  <p>Generate the report for the attendance of the class for a period of time. </p>
	  <form id="form1" name="form1" method="get" onsubmit="retrun true;">
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
	      <label>2. Select Date From&nbsp; : </label>
	      <input name="txtDateStart" type="text" id="txtDateStart" value="<?php echo strtolower(date("d-M-y"));?>" />
			<a href="javascript:show_calendar('form1.txtDateStart');" 
				onMouseOver="window.status='Date Picker'; overlib('Click here to choose start date.'); return true;" 
				onMouseOut="window.status=''; nd(); return true;">
					<img src="../themes/img/calendar_icon.png" width=15 height=16 border="0">			</a>		
		</p>

	      <label>3. Select Date To&nbsp;&nbsp;&nbsp;&nbsp; : </label>
	      <input name="txtDateEnd" type="text" id="txtDateEnd" value="<?php echo strtolower(date("d-M-y"));?>" />
			<a href="javascript:show_calendar('form1.txtDateEnd');" 
				onMouseOver="window.status='Date Picker'; overlib('Click here to choose end date.'); return true;" 
				onMouseOut="window.status=''; nd(); return true;">
					<img src="../themes/img/calendar_icon.png" width=15 height=16 border="0">			</a>		
		</p>
	    <p><input type="button" name="Submit" value="View List" onclick=" return doClassReport(this.form);"  /></p>
	    <p>&nbsp;</p>
	  </form>
	  <p>&nbsp;</p>
	  <p>&nbsp;</p>
	</div>
  </div>
</div>
<?php include("../includes/footer.php"); ?>
</div>
</body>
</html>
