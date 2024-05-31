<?php
/* Administrator Navigation
 * Navigation for the administrator
 * September 2008
 * @Author : Midhun Harikumar
 * $ Version : 1.3
 **/
?>

<!--  Admin's navigation -->

<div id="staff-navigation">
	<a href="index.php">Main Page</a> /
	<a href="ad_manageStaff.php" title="Manage Staff">Manage Staff</a> /
	<a href="ad_addStudents.php" title="Add Students">Add Students</a> /
	<a href="ad_studentsList.php" title="List Students">List Students</a> /
	<a href="ad_reportGenerator.php" title="Generate Reports">Reports</a> /
	<a href="ad_helpUsing.php" title="Help on Using this software">Help-Using </a> /
	<a href="login/logout.php" title="End your session & Logout">Logout </a>
</div>
<div id="hod-navigation" style="height:12px;">
	<div style="float:left"><a href="javascript:void(0)" onclick="toggleDisplay('advancedLinks')">Advanced&raquo;</a></div>
	<div id="advancedLinks" style="display:none; float:left;">
	<a href="ad_changePassword.php" title="Change Your Password">Change Password</a> /
	<a href="ad_staffClasses.php" title="Staff Class Deails">Staff Classes</a> /
	<a href="ad_bugReports.php" title="Bug Reports">Bug Reports</a> /
	<a href="ad_promoteClass.php" title="Promote Classes">Promote Classes</a> /
	<a href="ad_resetAtten.php" title="Reset Attendances">Reset Attendance</a>
	</div>
</div>