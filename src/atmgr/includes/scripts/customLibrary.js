/* customLibrary.js
 * Custom js Library 
 * Date : 3/21/2008
 * @Author : Midhun hk
 **/

//--------------------------------------------------------------

// Constants
var MSG_EMPTY_FIELD 	= "A required text field is empty.";
var MSG_INVALID_DATA	= "The data entered is invalid.";

function gebid(id) {return document.getElementById(id);}
function geds(id){ return gebid(id).style.display;}

function toggleDisplay(id){gebid(id).style.display = (geds(id)=="")? "none" : "";}
function setDisplayStyle(id,style){ gebid(id).style.display=style;}

function setContent(id,data)
{	gebid(id).value = data;}


//--------------------------------------------------------------

//////////////
// Functions
//////////////

/* fn isValidEmail()
 * input : string that is supposed to be an email-id
 * returns true if str is valid email else false
 * Using regular expressions to validate it.
 * Date : 03-Aug-2007
 **/
function isValidEmail(str)
{	
	// Believe me, this will test for valid e-mail address, and it works
	var regExp = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;	
	return regExp.test(str);
}

//--------------------------------------------------------------

function isEmpty(data)
{return data=="";}
function clearTextField(object){ object.value = ""; }

/* fn updateCharCount()
 * Sets the number of charactes in f into the div
 * Use onKeypress() event of a textbox
 * Date : 22-Apr-2008
 * Version : 0.2
 *
 * + uses limit to limit the num characters in the text
 **/
function updateCharCount(f,div,limit){
	if(gebid(div))
		gebid(div).innerHTML = "There are <strong>"+(f.value.length)+"</strong> character(s).";
	if(limit)		f.value = f.value.substring(0,limit-1);
}