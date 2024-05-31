/* ajaxBasic.js - implements basic ajax functionality
 * Jan 2007 
 * (c) Midhun hk / Centrum inc Software Solutions
 */
var retContent = "";
var g_div = "";

function changeContent(page,div){
	changeContent2(page,div,"<div class='ajaxRetContent'>Data posted successfully.</div>");
}

function changeContent2(page,div,str){
	var ajaxRequest;  // The variable that makes Ajax possible!
	g_div = div
	try{/* Opera 8.0+, Firefox, Safari*/ajaxRequest = new XMLHttpRequest();}
	catch (e){/* Internet Explorer Browsers*/
		try{ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");}
		catch (e) {
			try{ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");}
			catch (e){
				alert("incompatable browser!");
				return false;
	}	}	}
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			retContent  = str;
			setTimeout("setContent0()", 1000);
		}
	}
	gebid(div).innerHTML = '<div align=center>Posting the data ...</div>';
	ajaxRequest.open("GET", page, true);
	ajaxRequest.send(null);
}

function setContent0()
{gebid(g_div).innerHTML = retContent;}