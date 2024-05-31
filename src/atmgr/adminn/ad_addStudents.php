<?php
/* M5 - Administrator Module
 * Project administrator page
 * Date : 19 April 2008
 * @Author : Midhun hk
 * 
 **/

include("login/secure.php");
require_once("../includes/db_connect.php");
require_once("../includes/util_funcs.php");

$message 	= "";
$hasErrors	=	false;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="shortcut icon" href="../favicon.ico"/>
<link href="../themes/common00.css" type="text/css" rel="stylesheet" />
<link href="../themes/st_style.css" type="text/css" rel="stylesheet" />

<title>Welcome to Attendance Manager :: Add Students</title>

<script language="javascript1.2" src="../includes/scripts/customLibrary.js"></script>
<script language="javascript1.2" src="../includes/scripts/ajaxbasic.js"></script>
<script language="javascript1.2">
<!--
// AJAX Handler entrypoint for backend posting of data
// @author : Midhun Harikumar
// midhunhk@gmail.com
//
// Version 0.4

function _postStudentData(f,div){
	var stuName	=	f.txtName.value;
	var stuDept	=	f.lstDept.options[f.lstDept.selectedIndex].value; // f.lstLanguage.options[f.lstLanguage.selectedIndex].value
	var stuClass= 	f.lstClass.options[f.lstClass.selectedIndex].value;
	var stuReg	=	f.txtRegno.value;
	var rr = Math.round(10000*Math.random());
	
	if(stuName.length == 0 || stuReg.length == 0){alert("Required fields are missing..."); return;}
	if(isNaN(stuReg)){ alert("Register number should be an integer."); return;}
	
	var targetPage = "backendHandler.php?action=add&user=student&name="+stuName+"&dept="+stuDept+"&class="+
					 stuClass+"&reg="+stuReg+"&rid="+rr;
//alert(targetPage);	
	try{
		changeContent2(targetPage,div,"Student data entered for "+ stuReg +".");
	}catch(e){alert("Exception : "+e.message+"\nType : Runtime\nRecomended Operation : Try another browser");}
	
	if(f.chkAutoIncr.checked){
	// Auto increment the register number field
		 var t = Math.round(f.txtRegno.value) + 1;
		 f.txtRegno.value = (t++);
	}
}
-->
</script>
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
	  <h4>Add Students</h4>
	  <p>Use this page to add students to the various classes of departments in this college.   </p>
	  <form id="form2" name="form2" method="post" action="" style="background-color:#f8f8f8; padding:5px;">
	      <label>Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
	        <input name="txtName" type="text" id="txtName" />
          </label>
	      <p>Department &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
	        <select name="lstDept">
              <!-- Dynamically insert departments -->
              <?php 
				$sql = "SELECT * FROM department";
				$res = executeQuery($sql,$db);
				if(mysql_num_rows($res))
					while($row = mysql_fetch_row($res))
						echo "<option value=\"$row[0]\">$row[1]</option>\r";
			   ?>
            </select>
	      </p>
		  <p>
			Select the Class &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 
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
		  </p>
		  <p>
		    <label>Registration Number : 
		    <input name="txtRegno" type="text" id="txtRegno" /> </label>
		    <label><input name="chkAutoIncr" type="checkbox" id="chkAutoIncr" value="checkbox" />Auto Increment</label>
		  </p>
		  <p>
		    <input type="button" name="Submit2" value="Submit" 
				   onclick="_postStudentData(this.form,'addStudentResult'); return false;" />
		    <input type="reset" name="Submit3" value="Reset" />
		  </p>
	  </form>
	  </p>
	  <p id="addStudentResult"> </p>
    </div>
  </div>
</div>

 <?php include("../includes/footer.php"); ?>
  
</div>
</body>
</html>
