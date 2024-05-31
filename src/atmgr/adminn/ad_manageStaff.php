
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="shortcut icon" href="../favicon.ico"/>
<link href="../themes/common00.css" type="text/css" rel="stylesheet" />
<link href="../themes/st_style.css" type="text/css" rel="stylesheet" />

<title>Welcome to Attendance Manager :: Manage Staffs</title>
<?php
/* M5 - Administrator Module
 * Project administrator page
 * Date : 18 April 2008
 * @Author : Midhun hk
 * 
 **/

include("login/secure.php");
require_once("../includes/db_connect.php");
require_once("../includes/util_funcs.php");

$message 	= "";
$hasErrors	=	false;
$showAddform=	false;

if(isset($_REQUEST["action"])){
	// Perform some action
	$action	=	$_REQUEST["action"];
	
	if($action == "delete"){
		// Delete a staff member
		if(executeQuery("DELETE FROM user_staff WHERE staff_id = ".$_REQUEST["uid"],$db))
			$message = "Deleted the staff member.";
		else{
			$hasErrors = true;
			$message = "An Error has occured during the operation.";
		}
	}
	else if(action == "reset_pass")
	{
		// Reset password for the staff

		$defaultPassword	=	MD5($staffDefaultPasword);
		$resRP = executeQuery("UPDATE user_staff SET password = '$defaultPassword' WHERE staff_id = ".$_REQUEST["staff_id"],$db);
		echo "UPDATE user_staff SET password = '$defaultPassword' WHERE staff_id = ".$_REQUEST["staff_id"];
	}
}

if(isset($_POST["Submit"])){
	// Create a new user
	
	/////////////////////////////////////////
	$defaultPasswd	=	MD5($staffDefaultPasword);// defined in db-connect
	/////////////////////////////////////////
	
	$newUserName	=	stripslashes($_POST["sname"]);
	$newUserDeptId	=	$_POST["lstDept"];
	$userLevel		=	1;	// normal staff member
	$b_isHod		=	($_POST["b_ishod"]!="")?true:false;
	
	if($b_isHod) $userLevel = 5;

	// Create the new user	
	$sqlNew = "INSERT INTO user_staff (`dept`,`staff_name`,`password`,`level`)"
				." VALUES ('$newUserDeptId','$newUserName','$defaultPasswd','$userLevel')";
	executeQuery($sqlNew,$db);
	
	// If new HOD, update the department table
	if($b_isHod){
		// fetch this user's id || assume that full name of satff is also unique!
		$resT = executeQuery("SELECT * FROM user_staff WHERE staff_name = '$newUserName'",$db);
		$rowT = mysql_fetch_assoc($resT);
		$usrT = $rowT["staff_id"];
		executeQuery("UPDATE department SET hod = $usrT WHERE dept_id = $newUserDeptId",$db);
	}
}
?>
<script language="javascript1.2" src="../includes/scripts/customLibrary.js"></script>
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
	  <p><img src="../themes/img/fma_740x140_adminn.jpg" alt="Admin Control panel" width="739" height="140" /></p>
	  <p>
	  <?php
	  	$s = ($hasErrors)?"error00":"success";
		echo "<div class=$s>$message</div>"	  
	  ?>
	  To Add a new staff member, click <a href="javascript:void(0);" onclick="toggleDisplay('addUserForm');" 
	  title="Add New Staff">here</a>.<br /></p>
	  <div id="addUserForm" style="background-color:#f6f6f6; padding:8px; width:726px; display:none;">
	    <form id="form1" name="form1" method="post" action="ad_manageStaff.php">
	      <label>Staff name &nbsp;&nbsp;  :&nbsp;&nbsp;  <input type="text" name="sname" />    </label>
	      <p>Department &nbsp;: &nbsp;&nbsp;
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
	      </p>
	      <p><label><input name="b_ishod" type="radio" value="yes" /> Is Hod?</label> <span style="font-size:10px">(If this staff member is the HOD of this department, set this.)</span></p>
	      <p><input type="submit" name="Submit" value="Create" /></p>
		  <p style="font-size:10px">The newly created staff members will have the default pasword. It is important to change the password after logging in.</p>
	    </form>
	    </div>	  
	  </p>
	  <h4>List of staffs  </h4>
	  <p>
	  <?php
	  	//////////////////////////////////////////
		// 
		// Listing All The Staff Members
	  	//////////////////////////////////////////
	  	$resStaff = executeQuery("SELECT * FROM user_staff",$db);

		
		$i = 1;
		
		if($resStaff){
		?>
		<table width="748" border="0" cellpadding="4" cellspacing="1">
			<tr align="center" class="emphasise">
				<td>#</td>
				<td>Name</td>
				<td>Department</td>
				<td>Is Hod</td>
				<td colspan="2">Operation</td>
			</tr>
		<?
		while($row = mysql_fetch_assoc($resStaff)){
			$s = getRowStyle($i);

			$resStaffDept = executeQuery("SELECT * FROM department WHERE dept_id =".$row['dept']." ",$db);
			$rowDept = mysql_fetch_assoc($resStaffDept);
			$isHod = ($rowDept['hod'] == $row['staff_id'])? "Yes" : "No";
			echo "<tr class=$s align='center'>";
				echo "<td>$i</td>";
				echo "<td>".$row['staff_name']."</td>";
				echo "<td>".$rowDept['code']."</td>";
				echo "<td>$isHod</td>";
				echo "<td class='edit-links'><a href='ad_manageStaff.php?action=delete&user=staff&uid=".$row["staff_id"]."'"
					  ." onclick='return window.confirm(\"Are You sure you want to delete this user?\")';>Delete</a></td>";
				echo "<td class='edit-links'><a href='ad_manageStaff.php?action=reset_pass&staff_id=".$row["staff_id"]."'>"
					  ."Reset Password</a></td>";
			echo "</tr>";
			$i++;
		}		
		?>		
		</table>		
		<?
		}	  
	  ?>  
	  </p>
	</div>	
  </div>
</div>

 <?php include("../includes/footer.php"); ?>
  
</div>
</body>
</html>
