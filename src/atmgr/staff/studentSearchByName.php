<?php
/* Inline Search Handler
 * Handler for the AJAX Calls to display student searches by name
 * Author  : Midhun Harikumar
 * Date    : 24-Dec-2008
 * Version : $ 1.2.1
 **/

require_once("../includes/db_connect.php");
require_once("../includes/util_funcs.php");

$searchTerm = $_REQUEST["q"];

// "looking for names like '$searchTerm'";

$sql = "SELECT * FROM `user_student` WHERE stud_name like '%$searchTerm%' ORDER BY 'stud_id'";
$res = executeQuery($sql,$db);
if(mysql_num_rows($res) > 0){

	echo "<span class=small-text>Listing ".mysql_num_rows($res)." entries.</span>";
	$theResponse = "";
	$theResponse .= "<table cellpadding=0 cellspacing=0 border=0 width=550>";
	$theResponse .= "<tr class=emphasise><td width=40>No.</td><td width=300>Name</td><td>Register No.</td><td>dept</td></tr>";
	
	for($i=0;$i<mysql_num_rows($res);$i++){
		$row = mysql_fetch_assoc($res);			// fetched the students details
		$studName = $row["stud_name"];
		$studRegno  = $row["reg_no"];

		$r = executeQuery("SELECT * FROM `department` WHERE dept_id = ".$row["dept"],$db);
		$s = mysql_fetch_row($r);
		$studDept = $s[1];
/*Since the retrieval of classes is making the response time to degrade, its not being used for now...*/

/*		$t = executeQuery("SELECT * FROM `stud_classes` WHERE class_id = ".$row["class_id"],$db);
		$u = mysql_fetch_row($t);
		$studClass = $u[1];
*/		
		$theResponse .= "<tr><td>".($i+1)."</td>";
		$theResponse .= "<td>$studName</td>";
		$theResponse .= "<td>$studRegno</td>";
		$theResponse .= "<td>$studDept </td>"; //- $studClass
		$theResponse .= "</tr>";		
	}
	$theResponse .= "</table>";
	
	echo $theResponse;					//$theResponse += "";
}
else
	echo "<br>No student found with name '$searchTerm'";
	

?>