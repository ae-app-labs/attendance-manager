<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link href="../themes/common00.css" type="text/css" rel="stylesheet" />
<link href="../themes/st_style.css" type="text/css" rel="stylesheet" />

<script language="javascript1.2" src="../includes/scripts/customLibrary.js"></script>

<title>Welcome to Attendance Manager :: Students List</title>
<?php
/* M - Administrator / Show Staff Class
 * Shows the classes taken by staff for a paper
 * Date : 30 September 2008
 * @Author : Midhun hk
 * $ Version : 1.2
 **/

include("login/secure.php");
require_once("../includes/db_connect.php");
require_once("../includes/util_funcs.php");

// Global Variables
$msg 		= false;
$hasErrors 	= false;
$showList   = false;
$resPapers 	= "";

//////////////////////////////////
// List The Papers for dept.class
//////////////////////////////////
if(isset($_POST["resubmit"])){
	$showList 	= 	true;
	$classId	=	$_POST["lstClass"];
	$deptId		=	$_POST["lstDept"];

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
				
	$sql = "SELECT * FROM staff_paper WHERE dept_id = $t_deptId AND class_id = $t_classId";
	$resPapers 	= 	executeQuery($sql,$db);
}

?>
</head>

<body>
<div align="center">
<div id="outer-wrapper">
  <?php include("../includes/topnav.php");?>
  <div id="header"></div>
  
  <br />

  <div id="content-wrapper">  

<div style="font-weight:bold; margin-bottom:4px;"><?php include("ad_navigation.php");?></div>

	<div id="staff-content">
	<!--
	 <img src="../themes/img/fma_staff/fma_740x140_studentsList.jpg" alt="Students List" width="739" height="140" />
	 -->
  <?php 
    if($hasErrors) echo "<div class='error00'>$msg</div>";

	if($showList){
	//
	// Show the listing for papers for dept.class and the total num of hours taken yet
//	echo "<p></p>";
	?>
	<table width="700" cellpadding="2" cellspacing="2" border="0">
		<tr class="emphasise">
			<td>No</td>
			<td>Paper Name</td>
			<td>Hours Taken</td>
		</tr>
		<?php
		$i = 1;
		while($row2 = mysql_fetch_assoc($resPapers))
		{
			$s = getRowStyle($i);
			echo "<tr class=$s>";
				echo "<td>$i</td>";
				echo "<td>".$row2["subject_name"]."</td>";
				echo "<td>".$row2["total_hours"]."</td>";
			echo "</tr>";
			$i++;		
		}
		?>
	</table>
	<?php
	}
	else{
   ?>
   <h4>Staff Classes</h4>
   <p>Select the class to view the number of hours each paper has been taken so far.</p>
   <form action="ad_staffClasses.php" method="post" name="selectClass" id="selectClass">
     <label>Select the class of</label>
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
     <input type="submit" name="submit" value="View List" />
     <input type="hidden" name="resubmit" value="yes" />
   </form>
   <?php
   } /*end show form*/
   ?>
   <p>&nbsp;</p>
	</div>
  </div>
</div>

 <?php include("../includes/footer.php"); ?>
  
</div>
</body>
</html>
