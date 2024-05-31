<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../themes/common00.css" type="text/css" rel="stylesheet" />
<link href="../themes/st_style.css" type="text/css" rel="stylesheet" />
<title>Welcome to Attendance Manager :: Staff Control Panel</title>
<?php

/********************************************************/
/* Main App Page										*/
/********************************************************/

/* M1.2 - Staff Management / Mark Attendance /
 * Mark attendance
 * Date 	: 18 March 2008
 * @Author 	: Midhun hk
 * $Version	: 1.7.3
 **/


 /*********************************************************************************************************
  * Readme :
  * --------
  * For the 1st hour, a row is created against a dept.class and all students are marked present by default
  * For each hour if the student is absent, it is marked as '0'
  * for a present student, that particular hour will be marked as the 'paper_id' which is a non zero number
  * this will help us keep track of what hours are taught and aslo to calculate individual attendance % for papers
  *********************************************************************************************************/
  
/*
 * BugFixes :
 *
 * [10:35 AM 12/23/2008] 	Bug fix in params to checkdate()
 * [6:10 PM 1/28/2009]		Update to the way rows are created and atten status updated
 */

require_once("login/secure.php");				// Login check
require_once("../includes/util_funcs.php");  	// Utility Functions
require_once("../includes/db_connect.php");		// Datbase connectivity

///////////////////////////////
// Important Variable
///////////////////////////////
$currentDate = date("d-M-Y");//
///////////////////////////////

$showForm = true;
$errorMsg = false;

// Get the variables that are passed from the handler page
$deptId	  =	$_POST['lstDept'];
$classId  =	$_POST['lstClass'];
$hour	  =	$_POST['lstHour'];
$labHours = $_POST['lstMultiple'];

// get Department details
$res = executeQuery("SELECT * FROM department WHERE dept_id = '$deptId'",$db);
$row = mysql_fetch_row($res);

$deptCode = $row[1];
$deptName = $row[2];

// get class details
$res = executeQuery("SELECT * FROM stud_classes WHERE class_id = '$classId'",$db);
$row = mysql_fetch_row($res);

$className = $row[1];
$calcAtten = false;

if(isset($_POST['submit']))
{
	$showForm = false;
	/* If 1st Hour create a row for all the students of this department.class
	 * [10:50 AM 3/19/2008]
	 **/

    if($_POST["txtDate"] == $currentDate){
		// do nothing
	}
	else
	{
		// chechk if date is in correct format
		$tDateString = $_POST["txtDate"];			// get the posted date
		$tCheckString = explode("-",$tDateString);	// explode it into components

		// [10:35 AM 12/23/2008] Bug fix in params to checkdate()
		// convert month into a numerical value
		if(checkdate(getMonthValue($tCheckString[1]),$tCheckString[0],$tCheckString[2]))
			$currentDate = $_POST["txtDate"];
		else
			$errorMsg = "Invalid Date Format...".$_POST["txtDate"];
	}
	
	/****************************************************************************
	 * create a row against each dept.class.student for day if not already done * 
	 ****************************************************************************/

	{
		$sqlStu = "SELECT * FROM user_student WHERE dept = '$deptId' AND class_id = '$classId' ORDER BY 'stud_id'";
		$resStu = mysql_query($sqlStu,$db);
		if(mysql_num_rows($resStu))
		{
			for($i = 0; $i<$_POST["total_students"];$i++)
			{
				$row = mysql_fetch_row($resStu); // fetch each student details from dept.class
				$studId = $row[0];

				// Check if row already created
				if($i == 0)
				{
					$sqlTest = "SELECT * FROM stud_attendance WHERE date ='$currentDate' AND stud_id = '$studId'";
					$resTest = mysql_query($sqlTest,$db);
					if(mysql_num_rows($resTest))
					{
						//$errorMsg = "Attendance for this hour for this class has already been made";
						break; // break out of this loop
					}
				}
				///////////////////////////////////////////////////////////////////////////
				// Create a new row for dept.class.student for current day
				// currentDate, stud_id, h1,h2, h3, h4, h5, h6 attnendance_status
				// 9999 denotes the id for Free Hour if no attendance has been marked, it will be accounted as a free hour
				// [2:39 PM 3/27/2008]
				///////////////////////////////////////////////////////////////////////////
			$da = 9999; // default attendance indicating a free hour
			$sqlSet="INSERT INTO stud_attendance VALUES( '$currentDate','$studId','$da','$da','$da','$da','$da','$da','P')";
			$resSet=executeQuery($sqlSet,$db);
			}
//			echo " - $i - ";
		}
	}/* end processing rows for the class*/


	/* For any hour update the attendance of dept.class
	 * [12:25 AM 3/19/2008]
	 **/
	 {
		$resStu=executeQuery("SELECT * FROM user_student WHERE dept = '$deptId' AND class_id = '$classId' ORDER BY 'stud_id'",$db);
		for($i = 0; $i<$_POST["total_students"];$i++)
		{
			$row = mysql_fetch_row($resStu); // fetch each student details from dept.class
			$studId = $row[0];				// current student s id
			$currHour = "h".$hour;			// this hour eg: h1, h2

			//////////////////////////////////////////
			// Increment the total hours for the paper
			// [8:09 PM 3/20/2008]
			// [1:35 PM 3/31/2008] bug fix for limiting update operation to one time
			// [2:13 PM 3/31/2008] major bug fix while updating the total_hours of paper
			// [11:58 AM 9/28/2008] adding code for marking attendance for more than 1 hour in case of labs etc
			//////////////////////////////////////////
			if($i == 0)
			{
				$ppId = $_POST["lstPaper"];
				$extraProc = $_POST["extraHours"];
				$sqlP = "SELECT * FROM staff_paper WHERE pp_id = $ppId";
				$resP = mysql_query($sqlP,$db);
				$rowP = mysql_fetch_row($resP);
				$numHours = $rowP[5]; // the current total of hours for the paper

				$numHours = $numHours + 1 + $extraProc;	// increment it by 1 and no of additional hours
				$sqlU = "UPDATE staff_paper SET total_hours = $numHours WHERE pp_id = '$ppId'";
				$resU = mysql_query($sqlU,$db);
			}

			//////////////////////////////////////////////////
			// Set Attendance Status for this hour for student
			// [8:02 PM 3/22/2008]
			/////////////////////////////////////////////////

			// If student is present, the attendance status will be the paper_id
			// if student is absent, it will be 0
			$sid = "atten".($i+1);
			$attenStatus = ($_POST[$sid]=="yes")?$ppId:"0"; // [8:02 PM 3/22/2008] bugfix

			// Update the student info
			$sqlAt = "UPDATE stud_attendance SET $currHour = '$attenStatus' WHERE stud_id = '$studId' AND date = '$currentDate'";

			//////////////////////////////////////////////////
			// Set for multiple hours
			// [12:09 PM 9/28/2008]
			//////////////////////////////////////////////////
			
			$extraProc = $_POST["extraHours"];
			
			if($hour + $extraProc == 6)
				$calcAtten = true;		// calc final attendance forcefully
			
			while($extraProc){
			// Process extra hours in case of labs etc.
			  if($hour + $extraProc> 7) break; 	// bugfix
			  $tmpVar = $hour+$extraProc;
			  $extraHour = "h$tmpVar";
	$sqlExtra = "UPDATE stud_attendance SET $extraHour = '$attenStatus' WHERE stud_id = '$studId' AND date = '$currentDate'";
			  executeQuery($sqlExtra,$db);
			  $extraProc--;
			}
			/////////////////////////////////////////////////
			// End of Extra Hour Processing
			/////////////////////////////////////////////////
			
			$resAt = executeQuery($sqlAt,$db);
		}
	 }

	/* For last hour calculate total attendance status for the day for dept.clas.student
	 * [6:28 PM 3/19/2008]
	 **/
//	 if($hour == 6 || $calcAtten)
	 {
	    $sqlStu = "SELECT * FROM user_student WHERE dept = '$deptId' AND class_id = '$classId' ORDER BY 'stud_id'";
		$resStu = mysql_query($sqlStu,$db);

		for($i = 0; $i<$_POST["total_students"];$i++)
		{
			$row = mysql_fetch_row($resStu); // fetch each student details from dept.class
			$studId = $row[0];				 // current student s id

			$sqlRead = "SELECT * FROM stud_attendance WHERE date ='$currentDate' AND stud_id = '$studId'";
			$resRead = mysql_query($sqlRead,$db);
			$row2	 = mysql_fetch_row($resRead);

			// attendance status
			$stuAttenCount  = 0;  // assume absent
			$stuAttenStatus = ""; // Stores stringized status
			if($row2[2]!=0 && $row2[3]!=0 && $row2[4]!=0) $stuAttenCount++;
			if($row2[5]!=0 && $row2[6]!=0 && $row2[7]!=0) $stuAttenCount++;

			switch($stuAttenCount)
			{
				case 0 : $stuAttenStatus = "A"; break; // absent
				case 1 : $stuAttenStatus = "H"; break; // half day
				case 2 : $stuAttenStatus = "P"; break; // Full Day Present
			}

			// Update the student info
			$sqlAt = "UPDATE stud_attendance SET status = '$stuAttenStatus' WHERE stud_id = $studId AND date = '$currentDate'";
			$resAt = mysql_query($sqlAt,$db);
		}
	 }/* end hour == 6*/
}

?>
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
        <?php if($showForm) { /* if show form */?>
        <p>The page for marking attendance to students of <?php echo $deptCode." - ".$className." for hour <b>".$hour."</b>."; ?></p>
        <p> If you want to mark the attendance for a previous working day, change the text in the date field so as to reflect the change. Also make sure that the date entered is in the correct format, ie; DD-MMM-YYYY. The attendance details of all the students are updated only after the attendance is marked for the <strong>6th</strong> hour. </p>
        <form id="f_markAttend" name="form1" method="post" action="staff_markAttendance.php">
          <div style="background-color:#f7f7f7; padding:5px;">
            <label>Select Paper :
	          <select name="lstPaper" id="lstPaper" style="width:160px;">
              <!-- Dynamically insert papers for currebt department.class -->
              <?php
		/****************************************************************/
		// update for adjusting papers
		// date : october-2008
		// desc : ece a and ece b have same set of syllabus, but treated as different departments in this context
		//			so, no syllabus for a dept with id 4 (ece b)
		//			all departments have the s1s2 papers common, so shud refer to a dept with id 0
		
			$t_classId 	= 	$classId;
			$t_deptId	=	$deptId;
			if($classId == 4) $t_classId = 3; 	// ecea = eceb
			if($deptId == 4) $t_deptId = 3;		// ecea = eceb
			if($classId == 1) $t_deptId = 0;	// all departments shud point to same set of papers for s1 s2
		
			$sql = "SELECT * FROM staff_paper WHERE dept_id = '".$t_deptId."' AND class_id = '".$t_classId."'";
			$res = mysql_query($sql,$db);
			if(mysql_num_rows($res))
			{
				while($row = mysql_fetch_row($res))
					echo "<option value=\"$row[0]\">$row[2]</option>\r";
			}
		?>
            </select>
            </label>
            <label>Date :
            <input name="txtDate" type="text" id="txtDate" value="<?php echo date("d-M-Y");?>" />
            </label>
          </div>
          <br />
          <br />
          <!-- Dynamically insert student names from the dept.class -->
          <div id="item-list" style="line-height:150%;">
            <table cellpadding="2" cellspacing="2" border="0" width="750px">
              <tr class="emphasise">
                <td width="100">Roll No</td>
                <td width="410">Student Name</td>
                <td width="220">Attendance Status</td>
              </tr>
              <?php
			$sql = "SELECT * FROM user_student WHERE dept = '$deptId' AND class_id = '$classId' ORDER BY 'stud_id'";
			$res = mysql_query($sql,$db);
			$i = 1;
			if(mysql_num_rows($res))
			{
				while($row = mysql_fetch_row($res))
				{
					$s = getRowStyle($i);
					echo "<tr class='$s'>";
					  echo "<td>$i</td>";
					  echo "<td>$row[2]</td>";
					  echo "<td align=center>Present : <input type='checkbox' checked='checked' name='atten$i' value='yes'/></td>";
					echo "<tr>";
					$i++;
				}
			}
		?>
            </table>
          </div>
          <p>
            <input type="hidden" name="lstDept" 	value="<?php echo $deptId;	?>" />
            <input type="hidden" name="lstClass" value="<?php echo $classId;	?>" />
            <input type="hidden" name="lstHour" 	value="<?php echo $hour;  	?>" />
            <input type="hidden" name="total_students" value="<?php echo ($i-1);?>" />
            <input type="hidden" name="extraHours" value="<?php echo $labHours;?>" />
            <input type="submit" name="submit" value="Submit" />
            <input type="reset" name="Submit2" value="Reset" />
          </p>
        </form>
        <p>
          <?php } /*end show form */

	  else{
	  	echo "<div id=\"resultSpace\"form posted...";

	    if($errorMsg)
		  echo "<div class='error00'>$errorMsg! <br><br>Click on the link \"Mark Attendance\" to try again.</div>";
		else
		  echo "<div class='success'>Successfully submitted the attendance data...</div>";

	   	echo "</div>";
	  }
	  ?>
      </div>
    </div>
  </div>
  <?php include("../includes/footer.php"); ?>
</div>
</body>
</html>
