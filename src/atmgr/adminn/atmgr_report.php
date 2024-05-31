<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="shortcut icon" href="../favicon.ico"/>
<link href="../themes/print_style.css" type="text/css" rel="stylesheet" />
<title>Attendance Manager :: Reports</title>
<?php
/*****************************************
 * Report Page
 * 
 * Midhun Harikumar
 * April 2008
 **/

require_once("login/secure.php");
require_once("../includes/db_connect.php");
require_once("../includes/util_funcs.php");

define("ONEDAY",60*60*24);

$showStudent	=	false;
$showClass		=	false;
$showPaperWise	=	false;

$staff_departmentId = 1;

$reportWhat	=	$_REQUEST["type"];
if(isset($reportWhat)){
	if($reportWhat == "student"){
	// Need to generate Report for student
		$showStudent	=	true;
		?>
		<style type="text/css">#content{ width:550px; text-align:left;}</style>		
		<?php
	}
	else if($reportWhat == "class"){
	// report for a class
		$showClass 		=	true;
	// - get  dept
	
		$staff_departmentId = $_REQUEST["deptId"];
		$resD = mysql_query("SELECT * FROM department WHERE dept_id = $staff_departmentId",$db);
		$rowD = mysql_fetch_row($resD);
	
		$staff_departmentName 	= 	$rowD[2];
		$staff_departmentCode	=	$rowD[1];
	}
	else if($reportWhat == "paperwise"){
		$showPaperWise	=	true;
	}
}


?>
</head>

<body>
<div align="center">
<div id="content">
<?php
if($showStudent){
$stud_regno	=	$_REQUEST["regno"];

	$resStu = executeQuery("SELECT * FROM user_student WHERE reg_no = $stud_regno LIMIT 1",$db);
	if($resStu){
		$row = mysql_fetch_row($resStu);
		$stud_id	=	$row[0];	
		

		$sqlR	=	"SELECT * FROM stud_attendance WHERE stud_id = '$stud_id'";
 	   	$resR	=	executeQuery($sqlR,$db);

	   $totalClasses = mysql_num_rows($resR);
	   $totalPresent = mysql_num_rows(executeQuery("SELECT * FROM stud_attendance WHERE stud_id = '$stud_id' AND status='P'",$db));
		
		if($sqlR && mysql_num_rows($resR) > 0){
			// Print some header
//			echo "<div id='reportHeader'>&nbsp;</div><br>\r";
			echo "<div style='float:right;'><input type='button' value='Print this page' onclick='print(document);'/></div>";
			echo "<h3>Student Attendance Report</h3>\r<b>";
			echo $row[2]."</b> ($row[4])<br><br>\r";
			
			echo "<table border=0 width=550 cellpadding=4 cellspacing=4>";
			echo "<tr><td>Date</td><td>h1</td><td>h2</td><td>h3</td><td>h4</td><td>h5</td><td>h6</td><td>Status</td></tr>";
			while($row = mysql_fetch_row($resR)){
				echo "<tr>";
					echo "<td>$row[0]</td>";
					echo "<td>".getAttenStatus($row[2])."</td>";
					echo "<td>".getAttenStatus($row[3])."</td>";
					echo "<td>".getAttenStatus($row[4])."</td>";
					echo "<td>".getAttenStatus($row[5])."</td>";
					echo "<td>".getAttenStatus($row[6])."</td>";
					echo "<td>".getAttenStatus($row[7])."</td>";
					echo "<td style='background-color:#f4f4f4;' align=center>$row[8]</td>";
				echo "</tr>";
			}
			echo "</table>";
			$attendancePerc = 0;
			if($totalClasses != 0){
				$sttedancePerc = ($totalPresent / $totalClasses) * 100;
			}
			echo "<div id='attenSummary'>Total Attendance : $sttedancePerc %</div>";
			echo "<div style='font-size:10px; margin-top:4px;'>H = Half day, P = Present, A = Absent</div>";
		}
		else{
			// No data found
			echo "<br><br>No data found...";
		}
	}
}
if($showClass){
	$validData = true;
	$classId = $_REQUEST["classId"];
	$sql = "SELECT class_name FROM stud_classes WHERE class_id = '$classId'";
	$res = executeQuery($sql,$db);
	$row = mysql_fetch_assoc($res);
	$cls = $row["class_name"];
	
	$dateStart = $_REQUEST["dateStart"];
	$dateEnd   = $_REQUEST["dateEnd"];
	
	// Convert to timestamps for operations
	$timeStampStart = getTimeStamp($dateStart);
//echo "<br>";
// date("d-m-y",$timeStampStart);
	$timeStampEnd   = getTimeStamp($dateEnd); //getTimeStamp($dateEnd);

	$daysSpan = ($timeStampEnd - $timeStampStart) / ONEDAY + 1;
	

	// Check if the date range provided is valid or not
	if($timeStampStart > $timeStampEnd)
	{
		$validData = false;
		echo "Invalid date Range provided ....";
	}
	else
	{
		//-------------------------------------------------------
		// Page Header
		// Show Summary of data
		
		echo "<div id='reportHeader'>&nbsp;</div><br>\r";
		echo "Attendance details for ".$staff_departmentName." - ".$cls;
		echo "<br>From : <b> $dateStart</b> To : <b>$dateEnd</b><br><br>\r";
		
		$sql = "SELECT * FROM `user_student` WHERE dept = '$staff_departmentId' AND class_id = '$classId' ORDER BY 'stud_id'"; 
		$res = executeQuery($sql,$db);
		$numStudents = mysql_num_rows($res);
		
		//--------------------------------------------------------
		// Write list table header
		// This section writes the table header for the attendance
		// list that is to be listed.
		
		$tmpDate = $timeStampStart;
		echo "<table border=1 width=100%>\r<tr class='header'>\r";
			echo "<td>No.</td>\r<td>Name</td>\r";
			for($i=0;$i<$daysSpan;$i++)
			{
				echo "<td>";
				echo date("d-m",$tmpDate);
				$tmpDate += ONEDAY;
				echo "</td>\r";
			}
			echo "<td>%</td>";
			echo "<tr>";
			
		//--------------------------------------------------------
		// Write out details of each student
		// This is where the actual attendance of each student is
		// retireived from the database and displayed
		
		for($iCounter = 0;$iCounter<$numStudents;$iCounter++)
		{
			$currStudent = mysql_fetch_assoc($res);
			$currStudentId = $currStudent["stud_id"];
			$tmpDate = $timeStampStart;
			$fullPresentDays = 0;
			$halfPresentDays = 0;
			$dataAvailDays = 1;
			
			echo "<tr><td width=16px>".($iCounter+1)."</td>";
			echo "<td width=200px>".$currStudent["stud_name"]."</td>";
			for($i=0;$i<$daysSpan;$i++)
			{
				$attenDate = date("d-M-Y",$tmpDate);
				$tmpDate += ONEDAY;
				$sql = "SELECT status FROM `stud_attendance` WHERE `date` LIKE '$attenDate' AND `stud_id` = '$currStudentId'";


			    $attenRes=executeQuery($sql,$db);
				if(1 == mysql_num_rows($attenRes)){
					$attenRow=mysql_fetch_row($attenRes);
					if("P" == $attenRow[0]) $fullPresentDays++;
					if("H" == $attenRow[0]) $halfPresentDays++;
					
					echo "<td>";
					echo $attenRow[0];
					echo "</td>";
					$dataAvailDays++;
				}
				else // no data found
					echo "<td>Nil</td>";

			}
			$totalPresentDays = $fullPresentDays + $halfPresentDays *(0.5);
			if($dataAvailDays>1)	// bugfix for division for zero
				$dataAvailDays--;
			// Calculate the attendance % against the no of days as against data available
			$attendanceSpan   = ($totalPresentDays/$dataAvailDays) * 100;
			echo "<td>$attendanceSpan</td>";
			echo "</tr>";			
		}
		// - end table
		echo "</table>";
		

	}
	
}
if($showPaperWise){
	// Show attendance report on each subject

	/*********************************/
	/** AttendanceForPapers :: Start**/

	$res1 = executeQuery("SELECT * FROM user_student WHERE reg_no = ".$_REQUEST["regno"],$db);
	$row1 = mysql_fetch_assoc($res1);
	$deptId		=	$row1["dept"];
	$classId	=	$row1["class_id"];
	
	/****************************************************************/
	// update for adjusting papers
	// date : october-2008
	// desc : ece a and ece b have same set of syllabus, but treated as different departments in this context
	//			so, no syllabus for a dept with id 4 (ece b)
	//			all departments have the s1s2 papers common, so shud refer to a dept with id 0
	
	$t_classId 	= 	$classId;
	$t_deptId	=	$deptId;
	if($classId == 4) $t_classId = 3; // ecea = eceb
	if($classId == 1) $t_deptId = 0;	// all departments shud point to same set of papers for s1 s2
	
	// Get all papers for dept.class
	$sqlPapers = "SELECT * FROM staff_paper WHERE dept_id = '$t_deptId' AND class_id = '$classId'";
	$resPapers = mysql_query($sqlPapers,$db);
	if($resPapers){
    // first get the total number of papers for the class
    // could be 12 for first years and 8 for other students
		$numPapers	= mysql_num_rows($resPapers);
    
		$ppIds		= ""; // to store the paper ids of papers for the current class
		$ttlPaperHours  = "";
		
		// Loop till limit of papers
		echo "<table border=0 cellspacing=2 cellpadding=4 width=700>";
			echo "<tr class=emphasise>";
				echo "<td>#</td>";
				echo "<td align=left>Paper Name</td>";
				echo "<td>Total Hours</td>";
				echo "<td>Classes Present</td>";
				echo "<td>Percentage</td>";
			echo "</tr>";
			for($i=0;$i<$numPapers;$i++)
			{
				$row = mysql_fetch_row($resPapers);
				$ppId 			= $row[0]; // the paper id
				$ttlPaperHours 	= $row[5]; // total hours taken for this paper
			
				$paper_presentHours = 0;
				$paper_presentHours += getNumRows("SELECT * FROM stud_attendance WHERE stud_id = '$studId' AND h1 = '$ppId'",$db);
				$paper_presentHours += getNumRows("SELECT * FROM stud_attendance WHERE stud_id = '$studId' AND h2 = '$ppId'",$db);
				$paper_presentHours += getNumRows("SELECT * FROM stud_attendance WHERE stud_id = '$studId' AND h3 = '$ppId'",$db);
				$paper_presentHours += getNumRows("SELECT * FROM stud_attendance WHERE stud_id = '$studId' AND h4 = '$ppId'",$db);
				$paper_presentHours += getNumRows("SELECT * FROM stud_attendance WHERE stud_id = '$studId' AND h5 = '$ppId'",$db);
				$paper_presentHours += getNumRows("SELECT * FROM stud_attendance WHERE stud_id = '$studId' AND h6 = '$ppId'",$db);
				
				/////////////////////////////////////////////
				// set attendance percentage for this subject
				/////////////////////////////////////////////
		
				if($ttlPaperHours == 0) // bugfix
					$paper_attendancePerc = 0;
				else
					$paper_attendancePerc = ($paper_presentHours*100 / $ttlPaperHours);
					
				$s = ($i%2)?"row0":"row1";
					
				echo "<tr class=$s align=center>";
					$j=$i+1;
					echo "<td>$j</td>";
					echo "<td>$row[2]</td>";
					echo "<td>$ttlPaperHours</td>";
					echo "<td>$paper_presentHours</td>";
					echo "<td>$paper_attendancePerc</td>";
				echo "</tr>";
		
		// DEBUG		
		//		echo $row[2]."  Presen::"; // echo the paper name
		//		echo $paper_presentHours."( TotalHours::";
		//		echo $row[5]." )<br>"; // total num of hours taught yet
			}/*End the loop*/
	echo "</table><br>";
	
    
    //"SELECT * FROM student_attendance WHERE stud_id = '$stud_id' AND h1 = '".$ppIds[$i]."'"	
	}	
	/** AttendanceForPapers :: End **/
	/*********************************/
}
?>
<div id="footer">
Automatically Generated by Attendance Manager Software

</div>
</div></div>
</body>
</html>
