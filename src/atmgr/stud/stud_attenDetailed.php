<?php
/* M3 - Student Pages / Detailed Attendance 
 * Support Pages
 * Date : 20 March 2008
 * @Author : Midhun hk
 **/
 
// error_reporting(0);
require_once("../includes/db_connect.php"); // Database connectivity
require_once("../includes/util_funcs.php");  // Utility Functions

$studData 		 = "";
$stud_id		 = "";
$stud_department = "";
$stud_class		 = "";
$stud_name		 = "";
$stud_regno		 = "";
$message		 = "";
$hasErrors		 = false;

if(isset($_REQUEST["stud_regno"]) && $_REQUEST["stud_regno"]>0)
{
	/* if student id is valid, display detailed attendance details.
	 *
	 *
	 */
	$studRegno = $_REQUEST["stud_regno"];
//	$studName = $_REQUEST["stud_name"];
	// get student details	 	
	$res = executeQuery("SELECT * FROM user_student WHERE reg_no = '$studRegno'",$db);
	if($res)
	{
		$studData 	= mysql_fetch_row($res);
		$stud_name 	= $studData[2];
		$stud_id	= $studData[0];

/*		// get stud dept
		$sql2 = "SELECT * FROM department WHERE dept_id = (SELECT dept FROM user_stud WHERE stud_id = '$studId'";
		$res2 = mysql_query($sql2,$db);
		$row2 = mysql_fetch_row($res2);
		$stud_department = $row2[2];
		
		// get stud class
		$sql2 = "SELECT * FROM stud_classes WHERE class_id = (SELECT class_id FROM user_stud WHERE stud_id = '$studId'";
		$res2 = mysql_query($sql2,$db);
		$row2 = mysql_fetch_row($res2);
		$stud_class = $row[1];
*/		
	}else
	{	
		$hasErrors = true;
		$message = "Error while retrieving information from database...";
	}
}
else
{
	$hasErrors = true;
	$message = "Invalid parameter to the page...";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="shortcut icon" href="../favicon.ico"/>
<link href="../themes/common00.css" type="text/css" rel="stylesheet" />
<link href="../themes/homepage.css" type="text/css" rel="stylesheet" />

<title>Student Detailed Attendance ::  Attendance Manager</title>
</head>

<body>
<div align="center">
<div id="outer-wrapper">
  <?php include("../includes/topnav.php");?>
  <div id="header"></div>
  
  <div id="content-wrapper">
   <div class="blockButton" align="left">
  	<a href="../index.php">Home</a>
	<a href="../support/su_developers.php">Developers</a>
  	<a href="stud_details.php<?php echo "?stud_regno=".$_REQUEST["stud_regno"];?>">Student Details</a>
   </div>
    <h4>Detailed Attendance Information </h4>
    <p>
      <?php echo $studData[4];
	if($hasErrors)
	  	echo "<span class='error00'><div id='error-icon'></div>An Error has occured<br><br>$message</span>";
	else
	{ /*start detailed display*/
	
//	echo $studName;
	?>
	</p>
    <table width="750" border="0" cellspacing="2" cellpadding="2">
      <tr class="emphasise">
        <td><div align="center">Date</div></td>
        <td><div align="center">Hour1</div></td>
        <td><div align="center">Hour2</div></td>
        <td><div align="center">Hour3</div></td>
        <td><div align="center">Hour4</div></td>
        <td><div align="center">Hour5</div></td>
        <td><div align="center">Hour6</div></td>
        <td><div align="center">Attendance</div></td>
      </tr>
	  <tr>
	  	<td colspan="8"></td>
	  </tr>
	  <?php
	  $resV = executeQuery("SELECT * FROM stud_attendance WHERE stud_id = $stud_id",$db);
	  $k = 0;
	  if($res)
	  {
	  		while($rowV = mysql_fetch_row($resV))
			{
				$s = getRowStyle($k);
				$k++;
				echo "<tr align='center' class='$s'>";
					echo "<td>$rowV[0]</td>";
					// Print attendance status for hour 1 to hour 6
					for($j = 2; $j<=7;$j++)
					{
						echo "<td><div align='center'>";
						echo getAttenStatus($rowV[$j]);
						echo "</div></td>";
					}
					
					// print total attendance status for the day.
					echo "<td  class='attenColumn'>$rowV[8]</td>";
				echo "</tr>";
			}
	  }
	  
	  
	  ?>
    </table>
    <p>
      <?php
	} /* end detailed info*/
	?>
    </p>
  </div>
</div>

 <?php include("../includes/footer.php"); ?>
  </div>
  
</body>
</html>
