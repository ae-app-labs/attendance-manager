<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link href="../themes/common00.css" type="text/css" rel="stylesheet" />
<link href="../themes/st_style.css" type="text/css" rel="stylesheet" />

<script language="javascript1.2" src="../includes/scripts/customLibrary.js"></script>
<script language="javascript1.2">
function _doInlineSearch(str,div){

	if(str == ""){
		gebid(div).innerHTML = ""; 
		return;
	}
	var rr = Math.round(10000*Math.random());
	page = "../staff/studentSearchByName.php?q="+str+"&r="+rr;
	var ajaxRequest;
	try{/* Opera 8.0+, Firefox, Safari*/ajaxRequest = new XMLHttpRequest();}
	catch (e){/* Internet Explorer Browsers*/
		try{ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");}
		catch (e) {
			try{ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");}
			catch (e){
				alert("incompatable browser!");
				return false;
	}	}	}
	gebid(div).innerHTML = "<div align=center><img src='../themes/img/loading.gif'/><div>";
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			gebid(div).innerHTML  = ajaxRequest.responseText;
		}
	}
	ajaxRequest.open("GET", page, true);
	ajaxRequest.send(null);
}
</script>

<title>Welcome to Attendance Manager :: Students List</title>
<?php
/* Management / Students list
 * Shows students list + update student name and register number + delete student
 * Date : 20 March 2008
 * @Author : Midhun hk
 * 
 **/

include("login/secure.php");
require_once("../includes/db_connect.php");
require_once("../includes/util_funcs.php");

// Global Variables
$msg 		= false;
$hasErrors 	= false;
$showSelect	= true;	// show the class select form
$showEdit	= false;// show the student details edit page
$res2 		= "";
$row3		= "";

//////////////////////////////////
// List The Students of dept.class
//////////////////////////////////
if(isset($_POST["resubmit"])){
	$showSelect = false;
	$classId	=	$_POST["lstClass"];
	$deptId		=	$_POST["lstDept"];
	$sql2 = "SELECT * FROM user_student WHERE dept = $deptId AND class_id = $classId ORDER BY `stud_id` ASC";
	$res2 = mysql_query($sql2,$db);
}

////////////////////////////////////////
// Show Edit Form for dept.class.student
////////////////////////////////////////
if(isset($_REQUEST["action"]))
{	
	// page.php?action=edit_stud&stud_id=<id>
	// page.php?action=delete_stud&stud_id=<id>
	
	$studId	= $_REQUEST["stud_id"];

	if($_REQUEST["action"] == "edit_stud"){
		// show edit form and hide the select form
		$showSelect = false;
		$showEdit	= true;
	
		$sql3 	= "SELECT * FROM user_student WHERE stud_id = $studId";
		$res3	= mysql_query($sql3,$db);
		$row3	= mysql_fetch_row($res3);
	}

	if($_REQUEST["action"] == "delete_stud"){
		// Deletes a student without confirmation
		executeQuery("DELETE FROM user_student WHERE stud_id = $studId LIMIT 1",$db);	
	}
}

////////////////////////////////////
// Update dept.class.Student details
////////////////////////////////////
if(isset($_POST["update_stud"]))
{
	$studId	=	$_POST["stud_id"];
	$stuName=	$_POST["stu_name"];
	$stuReg =	$_POST["stu_reg"];
	
	if($stuName != "" && $stuReg != ""){
		// fixed a bug in the updation of student code
		$sql4 = "UPDATE `user_student` SET `stud_name` = '$stuName', `reg_no` = '$stuReg' WHERE `stud_id` =$studId LIMIT 1 ;";
		$res4 = mysql_query($sql4,$db);
	}else{
		$hasErrors = true;
		$msg = "The fields cannot be empty.";	
	}
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
	<h4 align="left">
	 <img src="../themes/img/fma_staff/fma_740x140_studentsList.jpg" alt="Students List" width="739" height="140" /></h4>
     
     <div  style="background-color:#f2f2f2;">
	<div class="edit-links" style="display:block; float:left; margin:4px; font-size:10px;">
		<a href="javascript:void(0);" onclick="toggleDisplay('searchStudent');">Show/Hide Search Student</a>
	</div>&nbsp;

	<div id="searchStudent">
 		<div align="right">
			<label> Enter Student Name : 
				<input name="searchString" id="searchString" onkeyup="_doInlineSearch(this.value,'searchResultPlaceHolder');" />
			</label>
		</div>
		
		<div id="searchResultPlaceHolder"></div>

	 </div>
</div>
     
	 
  <?php 
    if($hasErrors) echo "<div class='error00'>$msg</div>";
	
	
  	if($showSelect)
	{/*Show select form*/
   ?>
	  <p>
	  View the list of all students of a particular class.<br />
	  <form name="selectClass" method="post" action="ad_studentsList.php">
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
	  </p>
	  
	  
	<?php
	
	}/*end select form*/
	else if($showEdit)
	{/*show edit student form*/
	?>
	<!-- Student Details Show & Update -->
	<p>Update the details of this student. (Name & register no.)</p>
	<form name="editStudDetails" method="post" action="ad_studentsList.php">
	  <label>Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
      <input type="text" name="stu_name" value="<?php echo $row3[2];?>" /></label>	

	  <p><label>Register No :<input type="text" name="stu_reg" value="<?php echo $row3[4];?>" /> </label></p>
	  <p>
	    <input type="submit" name="Sub3" value="Update" 
			onselect="return(this.stu_name.text.length!=0 && this.stu_reg.text.length!=0);" />
		<input type="hidden" name="update_stud" value="yes" />
		<input type="hidden" name="stud_id" value="<?php echo $row3[0];?>"  />
	  </p>
	</form>	
	<?php
	}
	else
	{/*show specific student list*/	
	$re1 = executeQuery("SELECT * FROM department WHERE dept_id = ".$_POST["lstDept"],$db);
	$re2 = executeQuery("SELECT * FROM stud_classes WHERE class_id = ".$_POST["lstClass"],$db);
	$ro1 = mysql_fetch_assoc($re1);
	$ro2 = mysql_fetch_assoc($re2);
	echo "Showing the students list of <strong>";
	echo $ro1["code"]."  -  ".$ro2["class_name"]."</strong>";
	
	?>
	
	<table width="700" cellpadding="2" cellspacing="2" border="0">
		<tr class="emphasise">
			<td>No</td>
			<td>Name</td>
			<td>Reg.No</td>
			<td colspan="2">Operation</td>
		</tr>
		<?php
		$i = 1;
		while($row2 = mysql_fetch_row($res2))
		{
			$s = getRowStyle($i);
			echo "<tr class=$s>";
				echo "<td>$i</td>";
				echo "<td>$row2[2]</td>";
				echo "<td>$row2[4]</td>";
				echo "<td><div class='edit-links'>";
				echo "<a href='ad_studentsList.php?action=edit_stud&stud_id=$row2[0]'>Edit Details</a></div></td>";
				echo "<td><div class='edit-links'>";
				echo "<a href='ad_studentsList.php?action=delete_stud&stud_id=$row2[0]'>Delete</a></div></td>";
			echo "</tr>";
			$i++;		
		}
		?>
	</table>
	<?php
	}/*end stud list*/
	?>
	  </div>
	
	
  </div>
</div>

 <?php include("../includes/footer.php"); ?>
  
</div>
</body>
</html>

