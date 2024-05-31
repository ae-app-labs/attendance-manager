<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>AJAX Password Strength - Hakc.net</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="ajaxforms.js" type="text/javascript" language="javascript"></script>
<style type="text/css">
body {
	background: #333;
	color: #f8f8f8;
	font: 12px 'lucida sans unicode', lucida, helvetica, verdana, arial, sans-serif;
	text-align: center;
}
a:link, a:visited  { 
	color: #f8f8f8;
	text-decoration: underline;
}
#content{
border-top:dotted 2px #c0f813;
border-bottom:dotted 2px #c0f813;
}
#footer{
padding: 0px 0px 0px 0px;
margin: 125px 0px;
font-size: 9px;
}
</style>
<script type="text/javascript" language="Javascript">
function focus(){ document.passcheck.password.focus(); }
</script>
</head>

<body onLoad="focus()">

	<form action="javascript:get(document.getElementById('passform'));" name="passcheck" id="passcheck">
	<h1> AJAX Password Strength </h1>
	<br/>
	Type your password in the box and the script will automatically determine it's strength!
	<br/>
	<br/>
	<div id="content">
          <p> 
		    <input name="password" type="text" onKeyUp="javascript:get(this.form);">
          </p>
        </form>
		<br/>
   <span id="myspan"></span>  </div>
   <br/><br/>
 
   <br/><br/><br/>
	 <a href="http://www.hakc.net/2007/04/06/ajax-password-strength/">Script Information</a><br/>
	 <a href="http://www.hakc.net/scripts/passjax/">Script Download</a></br>
<div id="footer">Script by <a href="http://www.hakc.net">Surya</a> - HACK.NET</div>
    
</body>
</html>