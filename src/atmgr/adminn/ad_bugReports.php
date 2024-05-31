<?php
/* M5 - Administrator Module
 * Project administrator page
 * Date : 22 April 2008
 * @Author : Midhun hk
 * 
 **/

include("login/secure.php");
require_once("../includes/db_connect.php");
require_once("../includes/util_funcs.php");

$message 	= "";
$hasErrors	=	false;
$showList	=	true;


if(isset($_REQUEST["action"])){
	if($_REQUEST["action"] == "read"){
		$showList	=	false;	
	}
	else{
		// shud be delete
		executeQuery("DELETE FROM atmgr_bugreports WHERE bid = '".$_REQUEST["id"]."'",$db);
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="shortcut icon" href="../favicon.ico"/>
<link href="../themes/common00.css" type="text/css" rel="stylesheet" />
<link href="../themes/st_style.css" type="text/css" rel="stylesheet" />

<title>Welcome to Attendance Manager :: Staff Control Panel</title>

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
	      
    <h4>Bug Reports</h4>
	<?php if($showList)	{
		// List out all the reports
		$resList = executeQuery("SELECT * FROM atmgr_bugreports",$db);
		if($resList){
			$i = 1;
			echo "<table border=0 width='700'>";
			echo "<tr class='emphasise' align='center'><td>No.</td><td>Title</td><td>User</td><td>Date</td><td colspan=2>Operations</td></tr>";
			while($row = mysql_fetch_assoc($resList)){
				$s = getRowStyle($i);
				echo "<tr class=$s align='center'>";
					echo "<td>$i</td>";
					echo "<td>".$row["title"]."</td>";
					echo "<td>".$row["user"]."</td>";
					echo "<td>".$row["date"]."</td>";
					echo "<td class='edit-links'><a href='ad_bugReports.php?action=read&id=".$row["bid"]."'>Read</a></td>";
					echo "<td class='edit-links'><a href='ad_bugReports.php?action=delete&id=".$row["bid"]."'>Delete</a></td>";
				echo "</tr>";
				$i++;
			}
			echo "</table>";
		}
	}
	else
	{
		$resRead	=	executeQuery("SELECT * FROM atmgr_bugreports WHERE bid = ".$_REQUEST["id"],$db);
		if($resRead){
			$row = mysql_fetch_assoc($resRead);
			
			echo "<p class='small-heading'>".$row["title"]."</p>";
			echo "<p>".stripslashes($row["report"])."</p>";
			echo "<p> - ".$row["user"]."</p>";
		}
	
	}
	?>
    <p>&nbsp; </p>
  </div>
  </div>
</div>

 <?php include("../includes/footer.php"); ?>
  
</div>
</body>
</html>
