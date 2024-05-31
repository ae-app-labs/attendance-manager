<?php
$staff_isHOD=	false;	// whether current staff member is the HOD
{
	$sqlH = "SELECT * FROM department WHERE dept_id = (SELECT dept FROM user_staff WHERE staff_id = '".$_SESSION["staff_id"]."')";
	$resH = mysql_query($sqlH,$db);
	if($resH){
		$rowH = mysql_fetch_row($resH);
		if($rowH[3] == $_SESSION["staff_id"]) $staff_isHOD = true; // The HOD of the current Department
	}
}
?>
<!-- Start Normal Navigation -->
<div id="staff-navigation">
	<a href="index.php"> Staff Main</a> /
	<a href="staff_markAttendanceHandler.php" title="Mark Attendance">Mark Attendance</a> /
	<a href="staff_studentsList.php" title="Students List">Students List </a> /
	<a href="staff_changePassword.php" title="Change Your Password">Change Password</a> /
	<a href="staff_reportGenerator.php" title="Generate Reports">Reports </a> /
	<a href="staff_helpUsing.php" title="Help on Using this software">Help </a> /
	<a href="login/logout.php" title="End your session & Logout">Logout </a>
</div>
<!-- End Normal Navigation -->
<?php if($staff_isHOD) {?>
<!-- HOD Specific Navigation -->
<!-- Manage Staff / Promote Class / Reset Values -->
<div id="hod-navigation">
	&nbsp;&nbsp;HOD &raquo;&nbsp;
	<a href="hod_manageStaff.php" title="Manage the staff of the department">Manage Staff</a> / 
	<a href="hod_helpUsing.php" title="Advanced features for HODs"> Advanced Help </a></div>
<?php } ?>
<!-- End HOD Specific -->