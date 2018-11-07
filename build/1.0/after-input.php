<?php 
include ("php/PHP-after-input.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Chat with Google</title>
<style type="text/css" media="screen">
	@import "styles/style01.css";
</style>
<script language=Javascript>
	function scrollDown() {
		var msgBox = document.getElementById('history')
        msgBox.scrollTop = msgBox.scrollHeight - msgBox.clientHeight
	}
	function focusInputbox() {
		var inputBox = document.getElementById('box')
		//inputBox.style.border="2px solid #A0BEDC"
		inputBox.focus()		
	}
	var interval_redirect;
	function doRedirect() {
      window.location.href="loop-output.php?session=" + <?php echo $session; ?>;
	} 
	function keyListener(event) {
		var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
		if (keyCode >= 32) {
			clearTimeout(interval_redirect);
		}
		return true;
	}
</script>
</head>

<body onLoad="scrollDown();focusInputbox()">
<!--<body onLoad="scrollDown();focusInputbox()">-->
<center>
<a id="logo" href="index.html"><img src="images/logo.gif" width=276 height=110 alt="Google"></a>
<br>
<table border=0 cellspacing=0 cellpadding=4>
	<tr>
		<td nowrap>
			<font size=-1><b>Web</b>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href=# onMouseOver="window.status='';return true" onMouseUp="javascript:alert('No images here, just text.')">Images</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href=# onMouseOver="window.status='';return true" onMouseUp="alert('You clicked on a link, but it will not bring you anywhere.')">Video</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href=# onMouseOver="window.status='';return true" onMouseUp="alert('Why don\'t you ask Google instead of clicking on such links?')">News</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href=# onMouseOver="window.status='';return true" onMouseUp="alert('Do you need \'\'maps\'\'? I\'m afraid we don\'t have any here.')">Maps</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<b><a href=# onMouseOver="window.status='';return true" onMouseUp="alert('Unfortunately, we do not sell cheese (yet). Try again later.')">more&nbsp;&raquo;</a></b>
			</font>
		</td>
	</tr>
</table>
<div class="container">
<div id="history" onMouseUp="focusInputbox()">
	<div class="google">
		<div class="name"><b>Google</b><br></div>
		<div class="text">hi, i am google<br></div>
	</div>
	<?php echo $styled_conversation; ?>
</div>
<table class="container" cellpadding="0" cellspacing="0" onMouseUp="focusInputbox()">
	<tr><!--eyebrows-->
		<td align="left"><input class="eyebrow" type="button" value=""></td>
		<td></td><td></td><td></td>
		<td align="right"><input class="eyebrow" type="button" value=""></td>
	</tr>
	<tr><!--eyes and nose-->
		<td class="eye" align="center"><input type="radio" checked></td>
		<td align="right" valign="bottom"><input type="checkbox"></td>
		<td align="center"><select id="nose" size=4 multiple><option><option><option><option></select></td>
		<td align="left" valign="bottom"><input type="checkbox"></td>
		<td class="eye" align="center"><input type="radio" checked></td>
	</tr>
</table>
<table id="beard" cellpadding="0" cellspacing="0">
	<tr>
		<td id="mouth" align="center">
		<form method="post" name="chatform" autocomplete="off" action="after-input.php?session=<?php echo $session; ?>">
		<input id="box" type="text" name="words" value="" onKeyPress="return keyListener(event)">
		</form>
		</td>
	</tr>
</table>
</div>
<script type="text/javascript">
interval_redirect = setTimeout("doRedirect()", 5000);
</script>
<br>
	<font size=-1>
	<a href=# onMouseOver="window.status='';return true" onMouseUp="alert('1. write something in the box\n2. press Enter\n3. wait for Google to answer\n4. repeat, and enjoy the conversation')">How do I chat with Google?</a> - 
	<a href=# onMouseOver="window.status='';return true" onMouseUp="alert('Why not?')">Why?</a> - 
	<a href="http://www.google.com/technology/pigeonrank.html" target="_blank" onMouseOver="window.status='';return true">About this project</a> - 
	<b><a href=# onMouseOver="window.status='';return true" onMouseUp="alert('We are happy to hear from you!\nPlease write to:\ni.am.dissatisfied@gmail.com')">Dissatisfied? Help us improve</a></b>
	</font>
	<p><font size=-2>&copy;2006 Google - All rights and wrongs reversed</font></p>
</center>
</body>
</html>
