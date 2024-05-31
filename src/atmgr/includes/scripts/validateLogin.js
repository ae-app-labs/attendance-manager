/* validateLogin.js
 * scripts for validating login data
 * Date : 27-Mar-2008
 * @Author : Midhun hk
 **/
 
// Validation functions
function validateStudentLogin(f){
	var regNo = f.stud_regno.value; // alert(regNo);
	if(isEmpty(regNo)){
		alert(MSG_EMPTY_FIELD);
		return false;
	}
	if(isNaN(f.stud_regno.value)){
		alert("The Registration number should be an integer.");
		clearTextField(f.stud_regno);
		return false;
	}
	return true;
}

function validateStaffLogin(f){
	var staff_name = f.username.value;
	var staff_pass = f.password.value;
	
	if(isEmpty(staff_name) || isEmpty(staff_pass)){
		alert("Please Enter username and password.");
		return false;
	}
	return true;
}