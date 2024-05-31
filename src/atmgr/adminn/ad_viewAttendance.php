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

require_once("login/secure.php");				// Login check
require_once("../includes/util_funcs.php");  	// Utility Functions
require_once("../includes/db_connect.php");		// Datbase connectivity

// Posted variables
$classId	=	$_POST["lstClass"];
$attenDate	=	$_POST["txtDate"];
$deptId	  	=	$_POST["lstDept"];

// get class details
$sql = "SELECT * FROM stud_classes WHERE class_id = '$classId'";
$res = mysql_query($sql,$db);
$row = mysql_fetch_row($res);

$className = $row[1];
$numStudents;

///////////////////////////////////////////////
// Get Attendance Details for the specified day
///////////////////////////////////////////////

// $resStudentsList - List of Students of dept.class
$sqlStudentsList = "SELECT * FROM user_student WHERE class_id = '$classId' AND dept = '$deptId'";
$resStudentsList = mysql_query($sqlStudentsList,$db);
$numStudents	 = mysql_num_rows($resStudentsList); // number of students in the class


////////////////////////////////////////////////
// Check date fotmat
// Added : 31 - Mar - 2008
////////////////////////////////////////////////

$tDateString = $_POST["txtDate"];			// get the posted date
$tCheckString = explode("-",$tDateString);	// explode it into components

/*
// convert month into a numerical value and check if its a valid date
if(checkdate($tCheckString[1]+0,getMonthValue($tCheckString[0]),$tCheckString[2])+0)
{// date is in valid format
}
else
	$resStudentsList = false; // invalid date format
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="shortcut icon" href="../favicon.ico"/>
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
<?php include("ad_navigation.php");  ?>
	<div id="staff-content">
	
	  <p>Listing attendance for <span class="emphasise"><?php echo $deptCode." ".$className;?></span> for date : <span class="emphasise"><?php echo $attenDate; ?>.</span></p>
	  
	  <?php
	  
	  // 1. name h1 - h6 status
//	    echo $_POST["lstClass"]."<br>".$_POST["txtDate"];
	  $i = 1;
	  $noData = false;
	  if($resStudentsList)
	  {
	  	// -- write out header for
		echo "<table width='700' border='0'>";
//		if($numStudents)
		while($i<=$numStudents)
		{
			$stuRow 		= mysql_fetch_row($resStudentsList); // read a row from dept.class
			$currStudId		= $stuRow[0];
			$s				= getRowStyle($i);

			$sqlAttenList	= "SELECT * FROM stud_attendance WHERE stud_id = '$currStudId' AND date = '$attenDate'";
			$resAttenList	= mysql_query($sqlAttenList,$db);
			if($i == 1) {
				if(mysql_num_rows($resAttenList) == 0)
				{
				  	echo "<span class='error00'><div id='error-icon'></div>There is no attendance listed for this date.</span>";
					break;
				}
			}
			$attenRow		= mysql_fetch_row($resAttenList);
			echo "<tr class='$s'>";
				echo "<td>$i.</td>";			// class roll num
				echo "<td>$stuRow[2]</td>"; // student's name
				
				// Print attendance status for hour 1 to hour 6
				for($j = 2; $j<=7;$j++)
				{
					echo "<td><div align='center'>";
					echo getAttenStatus($attenRow[$j]);
					echo "</div></td>";
				}					
					// print total attendance status for the day.
					echo "<td  class='attenColumn'><div align='center'>$attenRow[8]</div></td>";
				echo "</tr>";
			$i++; // increment roll number		
		}  
		echo "</table>";
	  }	
	  ?>
	  <p>&nbsp;</p>
	</div>
  </div>
</div>
<?php include("../includes/footer.php"); ?>
</div>
</body>
</html>
