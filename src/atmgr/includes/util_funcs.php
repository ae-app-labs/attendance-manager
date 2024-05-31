<?php
/* util_funcs.php
 * Utility Functions
 * 21-Mar-2008
 * @author : Midhun Harikumar
 **/



/* function  : getNumRows()
 * Synopsis  : Returns the number of rows in a querry
 * parameter : SQl Querry
 * returns   : number of rows selected when the querry is run
 *
 * Date      : [21-Mar-2008]
 * @author   : Midhun Harikumar 
 * $ Version : 0.52
 *
 * Bugfix    : Database Connection not getting through to this function
 **/

function getNumRows($sql,$dbc)
{
	$res = mysql_query($sql,$dbc); // execute the query
	if($res)
		return mysql_num_rows($res); // return the number of rows 
	return -1;	// some error has occured

}

// Gets Attendance status based on the paper_id for the hour
// Date : 24-Mar-2008
function getAttenStatus($st)
{
	if($st == 0)
		return "A";
	else
		return "P";
}

// Executes a SQL Query on database $db
// Date : 31-Mar-2008
function executeQuery($sql,$db)
{
	$res = mysql_query($sql,$db);
	return $res;
}

// Gets random background color class for  a row based on the loop var
// Date : 31-Mar-2008
function getRowStyle($count)
{
	return ($count%2)?"row1":"row0";
}

// Converts String month into long month
// Date : 31-Mar-2008
function getMonthValue($month)
{
	switch($month)
	{
		case "Jan" : return 1;
		case "Feb" : return 2;
		case "Mar" : return 3;
		case "Apr" : return 4;
		case "May" : return 5;
		case "Jun" : return 6;
		case "Jul" : return 7;
		case "Aug" : return 8;
		case "Sep" : return 9;
		case "Oct" : return 10;
		case "Nov" : return 11;
		case "Dec" : return 12;
	}
	return 0;
}

// Set & Get Session variables
// Date : 12-Aug-2008
// V 0.1
function setSessionVar($name,$value)
{	$_SESSION[$name] = $value;}

function getSessionVar($name)
{	return $_SESSION[$name];}

/* getTimeStamp()
 * Converts a string date in dd-mon-yyyy format and returns the timestamp
 * 09-Jan-2009
 * $ Version : 1.0
 * [3:47 PM 1/9/2009] Major bug fix in calculation of timestamp
 **/
function getTimeStamp($strDate){
	$year  = date('Y', strtotime($strDate));
	$month = date('m', strtotime($strDate));
	$day   = date('d', strtotime($strDate));
//         mktime(hr,mn,sec,mon,   day, year)
	return mktime(0, 0, 0,  $month,$day,$year);
}

?>