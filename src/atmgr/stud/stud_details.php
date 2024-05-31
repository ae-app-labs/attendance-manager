<?php
/* M3 - Student Pages / Details
 * Support Pages
 * Date : 20 March 2008
 * @Author : Midhun hk
 **/
 
error_reporting(0);
require_once("../includes/db_connect.php"); // Database connectivity
require_once("../includes/util_funcs.php");  // Utility Functions

$studData 		 = "";
$stud_id		 = "";
$stud_department = "";
$stud_deptCode   = "";
$stud_deptId	 = "";
$stud_class		 = "";
$stud_classId	 = "";
$errorMessage	 = "";
$hasErrors		 = false;

if(isset($_REQUEST["stud_regno"]))
{
	$studRegno = $_REQUEST["stud_regno"];
	if($studRegno != "")
	{
		$sql = "SELECT * FROM user_student WHERE reg_no = $studRegno";
		$res = mysql_query($sql,$db);
		if($res)
		{
			$studData 	= mysql_fetch_row($res);
			$studId		=	$studData[0];
			
			// get stud dept
			$sql2 = "SELECT * FROM department WHERE dept_id = (SELECT dept FROM user_student WHERE stud_id = '$studId')";
			$res2 = mysql_query($sql2,$db);
			$row2 = mysql_fetch_row($res2);
			$stud_department = $row2[2];
			$stud_deptCode   = $row2[1];
			$stud_deptId	 = $row2[0];
			
			// get stud class
			$sql2 = "SELECT * FROM stud_classes WHERE class_id = (SELECT class_id FROM user_student WHERE stud_id = '$studId')";
			$res2 = mysql_query($sql2,$db);
			$row2 = mysql_fetch_row($res2);
			$stud_classId = $row2[0];
			$stud_class   = $row2[1];
			
			// get student details
			$sqlD = "SELECT * FROM user_student WHERE stud_id = $studId";
			$resD = mysql_query($sqlD,$db);
			if($resD)
				$rowD = mysql_fetch_row($resD);
			else{
				$hasErrors = true;
				$errorMessage = "Student with register no '$studRegno' does not exist. Please enter proper register number.";	
			}
		}
		else{
			$hasErrors = true;
			$errorMessage = "Student with register no '$studRegno' does not exist. Please enter proper register number.";	
		}
	}
	else{
		$errorMessage = "The page recieved invalid data and or parameters...";
		$hasErrors =true; // bad data
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="shortcut icon" href="../favicon.ico"/>
<link href="../themes/common00.css" type="text/css" rel="stylesheet" />
<link href="../themes/homepage.css" type="text/css" rel="stylesheet" />

<title>Student Details ::  Attendance Manager</title>
</head>

<body>
<div align="center">
<div id="outer-wrapper">
  <?php include("../includes/topnav.php");?>
  <div id="header"></div>
  
  <div id="content-wrapper">
  <?php 
  if($hasErrors)
  {
  	echo "<span class='error00'><div id='error-icon'></div>An Error has occured<br><br>$errorMessage</span>";
  }
  else
  {/*start noerror block*/
  ?>
  <div class="blockButton" align="left">
  	<a href="../index.php">Home</a>
	<a href="../support/su_developers.php">Developers</a>
    <a href="stud_attenDetailed.php<?php echo "?stud_id=$studId&stud_regno=$studRegno&stud_name=$studData[2]"; ?>">Detailed Attendance</a>
  </div>
    <h4>Student Details</h4>
    <table width="600" border="0" cellspacing="4" cellpadding="4">
      <tr>
        <td width="183" class="emphasise">Department</td>
        <td width="417"><?php echo $stud_department; ?></td>
      </tr>
      <tr>
        <td class="emphasise">Class</td>
        <td><?php echo $stud_deptCode." - ".$stud_class; ?></td>
      </tr>
      <tr>
        <td class="emphasise">Name</td>
        <td><?php echo $studData[2]; ?></td>
      </tr>
      <tr>
        <td class="emphasise">Register No </td>
        <td><?php echo $studRegno; ?></td>
      </tr>
    </table>
    <p>&nbsp;</p>
	<h4>Aggregate Attendance Details</h4>
    <?php
		// get all rows for the particular student. the number of rows will be the total number of working days for that dept.class
		$totalClasses	= getNumRows("SELECT * FROM stud_attendance WHERE stud_id = $studId",$db);
		$status_a		= getNumRows("SELECT * FROM stud_attendance WHERE stud_id = $studId AND status = 'A'",$db);
		$status_h		= getNumRows("SELECT * FROM stud_attendance WHERE stud_id = $studId AND status = 'H'",$db);
		$status_p		= getNumRows("SELECT * FROM stud_attendance WHERE stud_id = $studId AND status = 'P'",$db);
		
		$halfDayCarry = $status_h*0.5;
		$totalAtten   = $status_p + $halfDayCarry;

//		echo "total classes : $totalClasses<br>$status_a<br>$status_h<br>$status_p";
	?>
	
	<table width="350" border="0" cellspacing="4" cellpadding="4">
      <tr>
        <td width="250" class="emphasise">Total no of classes : </td>
        <td width="100"><div align="center"><?php echo $totalClasses ?></div></td>
      </tr>
      <tr>
        <td class="emphasise">Absent : </td>
        <td><div align="center"><?php echo $status_a; ?></div></td>
      </tr>
      <tr>
        <td class="emphasise">Half Days : </td>
        <td><div align="center"><?php echo $status_h; ?></div></td>
      </tr>
      <tr>
        <td class="emphasise">Present Days : </td>
        <td><div align="center"><?php echo $status_p; ?></div></td>
      </tr>
      <tr>
        <td class="emphasise">Total Attendance : </td>
        <td><div align="center"><?php echo $totalAtten; ?></div></td>
      </tr>
	  <tr class="row1">
		  <td class="emphasise">Attendance % : </td>
        <td><div align="center"><?php echo ($totalAtten/$totalClasses)*100; ?></div></td>
      </tr>
    </table>
	
	<p>For Detailed Attendance Information, click 
		<a href="stud_attenDetailed.php<?php echo "?stud_regno=$studRegno"; ?>">here</a>.	</p>
		
	<!-- Section :: Attendance for separate subjects / papers -->
	<h4>Attendance for Subjects</h4>
	<?php
	/*********************************/
	/** AttendanceForPapers :: Start**/
	
	// Get all papers for dept.class
	$sqlPapers = "SELECT * FROM staff_paper WHERE dept_id = '$stud_deptId' AND class_id = '$stud_classId'";
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
			echo "<td>Paper Name</td>";
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
	
	}/*end no error block*/
	?>
   
  </div>
</div>

 <?php include("../includes/footer.php"); ?>
  </div>
  
</body>
</html>
