<?php 
function user_info($field='') {
   // If $field is empty
   if(empty($field))
       return false;
   // Check to see if we're allowed to query the requested field.
   // If we add other fields, such as name, e-mail etc, this array
   // will have to be extended to include those fields.
   $accepted = array('username', 'user_password');
   if(!in_array($field, $accepted))
       return false;
   // Poll the database
   $result = mysql_query("SELECT ". $field ." FROM members WHERE ID = ". $_SESSION['member_ID'] .";");
   // If we don't find any rows
   if(1 != mysql_num_rows($result)) :
       return false;
   else :
       // We found the row that we were looking for
       $row = mysql_fetch_assoc($result);
       // Return the field
       return $row[$field];
   endif;
} // end user_info
?>