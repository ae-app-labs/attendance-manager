<?php 
session_start();
include('../../includes/db_connect.php');
if(isset($_POST['submit'])) :
   // Username and password sent from signup form
   // First we remove all HTML-tags and PHP-tags, then we create a sha1-hash
   $username = strip_tags($_POST['username']);
   $password = md5(strip_tags($_POST['password']));
   // Make the query a wee-bit safer
   // to avoid SQL Injection
   $query = sprintf("SELECT staff_id FROM user_staff WHERE staff_name = '%s' AND password = '%s' LIMIT 1;", mysql_real_escape_string($username), mysql_real_escape_string($password));
//   echo $query;
   $result = mysql_query($query);
   if(1 != mysql_num_rows($result)) :
       // MySQL returned zero rows (or there's something wrong with the query)
       header('Location: ../../index.php?msg=login_failed'); // display login error message on home page itself
   else :
       // We found the row that we were looking for
       $row = mysql_fetch_assoc($result);
       // Register the user ID for further use
       $_SESSION['staff_id'] 	= $row['staff_id'];
	   $_SESSION['staff_name'] 	= $username;
	   $_SESSION['staff_deptId']= $row['dept'];
//       header('Location: members-only.php');
       header('Location: ../../staff/index.php');
   endif;
endif;
?>