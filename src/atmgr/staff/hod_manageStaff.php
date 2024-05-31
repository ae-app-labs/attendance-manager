<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link href="../themes/common00.css" type="text/css" rel="stylesheet" />
<link href="../themes/st_style.css" type="text/css" rel="stylesheet" />
<?php
/* M1.7 - HOD / Manage Staff
 * Manage Staff memebers of a department
 * Date : 28 March 2008
 * @Author : Midhun hk
 * 
 * [6:35 PM 3/18/2008] Sucessfully added session to the Staff Interface
 * [1:58 PM 1/9/2009]  Bugfix for removing staff
 **/

include("login/secure.php");
require_once("../includes/db_connect.php");
require_once("../includes/util_funcs.php");

// common global variables to be used in page
$hod_name	=	"";
$hod_id		=	"";
$hod_dept	=	"";
$hod_dCode	=	"";
$hod_deptId	=	"";

$message	=	"";
$hasErrors	=	false;
$showUpdateForm = false;

// Get the HODs department
$hod_id		=	$_SESSION["staff_id"];
$hod_name	=	$_SESSION["staff_name"];

$sqlH = "SELECT * FROM department WHERE dept_id = (SELECT dept FROM user_staff WHERE staff_id = '$hod_id')";
$resH = mysql_query($sqlH,$db);
if($resH){
	$rowH = mysql_fetch_row($resH);
	$hod_deptId	=	$rowH[0];
	$hod_dCode	=	$rowH[1];
	$hod_dept	=	$rowH[2];	
}else{ $hasErrors = true; $message = "Error Accessing database.";}

//
$edit_staffId	=	"";
$edit_staffName	=	"";

if(isset($_REQUEST["action"]))
{
	// modify staff details
	$edit_staffId	=	$_REQUEST["staff_id"];
	if($_REQUEST["action"] == "edit")
	{
		// show edit form
		$showUpdateForm	= true;
		$sqlE	=	"SELECT * from user_staff WHERE staff_id = '$edit_staffId'";
		$resE	=	mysql_query($sqlE,$db);
		$rowE	=	mysql_fetch_row($resE);
		$edit_staffName	=	$rowE[2];
	}
	else if($_REQUEST["action"] == "remove")
	{
		// Remove a staff
		$sqlR	=	"DELETE FROM user_staff WHERE staff_id = '$edit_staffId'";
		$resR	=	mysql_query($sqlR,$db);
	}
}
if(isset($_POST["updateSubmit"])){
	if($_POST["txtStaffName"] != "" && $_POST["staff_id"] != "")
	{
		// Update a staff
		$sqlU	=	"UPDATE user_staff SET staff_name = '".$_POST["txtStaffName"]."' WHERE staff_id = '".$_POST["staff_id"]."'";
		$resU	=	mysql_query($sqlU,$db);		
	}
}
?>

<title>Welcome to Attendance Manager :: HOD Control Panel</title>
</head>

<body>
<div align="center">
<div id="outer-wrapper">
  <?php include("../includes/topnav.php");?>
  <div id="header"></div>
  
  <br />
  <div id="content-wrapper">
  
<div style="font-weight:bold; margin-bottom:4px;"></div>
<?php include("staff_navigation.php")  ?>
	<div id="staff-content">
	  <p>Manage the staff of the department here. You can edit or remove staff members.</p>
	  <p>
	  <?php 
		if($showUpdateForm){
		  	// showUpdateForm
			?>
		<h4>Edit Staff Details</h4>
			<form name="update" action="hod_manageStaff.php" method="post">
				<input type="text" name="txtStaffName" value="<?php echo $edit_staffName; ?>"/>
				<input type="hidden" name="staff_id" value="<?php echo $edit_staffId; ?>" />
				<input type="submit" name="updateSubmit" value="Update" />
			</form>
			
			<?php
		}
		?>

		<h4>Staff List </h4>
		<table width="746" border="0" cellspacing="2" cellpadding="4">
        <tr class="emphasise" style="padding:5px;">
          <td width="100">Serial no : </td>
          <td width="300">Name : </td>
          <td colspan="2">&laquo;-------------------Operations---------------&raquo;</td>
        </tr>
	  <?php		
		// select all staff from the department
		// and list them
		$sqlS	=	"SELECT * from user_staff WHERE dept = '$hod_deptId'";
		$resS	=	mysql_query($sqlS,$db);
		$i		=	1;
		while($row = mysql_fetch_row($resS))
		{
			// Skip the HOD Details as HOD cant modify his own details
			if($row[0] == $hod_id) continue;

			$s = getRowStyle($i%2);
			echo "<tr class='$s' align='center'>";
				echo "<td>$i</td>";
				echo "<td>$row[2]</td>";
				echo "<td class='edit-links'><a href='hod_manageStaff.php?action=edit&staff_id=$row[0]'>Edit</a></td>";
				echo "<td class='edit-links'><a href='hod_manageStaff.php?action=remove&staff_id=$row[0]'>Remove</a></td>";
			echo "</tr>";
			$i++;
		}
	  
	  ?>
        </table>
	  </p>
	  
	  <p>&nbsp; </p>
	  <p>&nbsp;</p>
	</div>
	
	
  </div>
</div>

 <?php include("../includes/footer.php"); ?>
  
</div>
</body>
</html>
