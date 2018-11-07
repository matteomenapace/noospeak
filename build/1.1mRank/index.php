<?php

$action = "index.php";

include "respond.php";
if (isset($_POST['input'])){
	//echo ("<br> oh dear, there is an input!");
	$new_conversation=0;
	$numselects=0;
	// Start the session or get the existing session.
	session_start();
	$myuniqueid=session_id();
	// get the reply of the bot (from respond.php)
	// the following logs the conversation (user+chatbot)
	$botresponse = replybotname($_POST['input'],$myuniqueid,$_POST['botname']);
	// pass the botresponse to google
	if (isset($botresponse)) {
		//echo ("the following sentence will be passed to google: " . $botresponse->response . "<br>");
		include "grespond.php";
	}	
	// log conversation (input +google response)
	$conversation = g_getconversation();
	$history="";
	foreach ($conversation as $value) $history .= $value;
	//echo ("<br>the following sentence came back from google: " . $value . "<br>");
	
	/*echo "<pre>";
	print_r($conversation);
	echo "</pre>";*/
	
} else $new_conversation=1;

?>	

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="icon" href="images/favicon.ico"/>
<title>Chat with Google</title>
<style type="text/css" media="screen">
	@import "css/googlebot02.css";
</style>
<script language="text/javascript">
	function scrollDown() {
		var msgBox = document.getElementById('history')
        msgBox.scrollTop = msgBox.scrollHeight - msgBox.clientHeight
	}
	function focusInputbox() {
		var inputBox = document.getElementById('box')
		inputBox.focus()
	}
	function keyListener(event) {
		var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
		if (keyCode >= 32) {
			clearTimeout(ask_google);
		}
		return true;
	}
</script>
</head>

<body>
<center>
<a id="logo"><img src="images/logo.gif" width=276 height=110 alt="Google"></a>
<br>

<div class="container">
<div id="history" onMouseUp="	document.getElementById('box').focus()">
	<?php 	
		echo ("<div class=\"google\"><div class=\"name\"><b>Google</b><br></div><div class=\"text\">Hi, I am Google, who are you?</div></div>");
		if (isset($botresponse)) {
			echo ($history);
		} 
	?>
	</div>	
</div>
<table class="container"  cellpadding="0" cellspacing="0" onMouseUp="focusInputbox()">
	<tr>
		<td align="left"><input class="eyebrow" type="button" value=""></td>
		<td></td>
		<td align="right"><input class="eyebrow" type="button" value=""></td>
	</tr>
	<tr>
		<td class="eye" align="center"><input type="radio" checked></td>
		<td id="nose" align=center><input id="nosetext" type="text" onMouseUp="	document.getElementById('box').focus()"></td>
		<td class="eye" align="center"><input type="radio" checked></td>
	</tr>
</table>
<table id="beard" cellpadding="0" cellspacing="0">
	<tr>
		<td id="mouth" align="center">
		<form method="post" name="chatform" autocomplete="off" action="<?php echo $action; ?>">
		<? if ($new_conversation==0) {
				//echo ("Are we starting a new conversation?" . $new_conversation . "<br>");	
				//<input type=\"hidden\" name=\"botname\" value=\"" . $HTTP_POST_VARS['botname'] . "\">");
				echo ( "<input type=\"hidden\" name=\"" . session_name() . "\" value=\"" . $uid . "\">
							<input type=\"hidden\" name=\"botname\" value=\"Google alpha 01\">");
			} else {
				echo ("<input type=\"hidden\" name=\"botname\" value=\"Google alpha 01\">");
			}
		?>
		<input id="box" type="text" name="input" value="">
        <!--onKeyPress="return keyListener(event);"-->
		</form>
		</td>
	</tr>
</table>
</div>
<script type="text/javascript">
	document.getElementById('box').focus()
	var msgBox = document.getElementById('history')
	msgBox.scrollTop = msgBox.scrollHeight - msgBox.clientHeight
</script>
<br>
	<font size=-1>
	<a href=# onMouseOver="window.status='';return true" onMouseUp="alert('1. write something in the box\n2. press Enter\n3. wait for Google to answer\n4. repeat, and enjoy the conversation')">How do I chat with Google?</a> - 
	<a href=# onMouseOver="window.status='';return true" onMouseUp="alert('Why not?')">Why?</a> - 
	<b><a href="mailto: i.am.dissatisfied@gmail.com">Dissatisfied? Help me improve</a></b>
	</font>
	<p><font size=-2>&copy;2007 Google - All rights and wrongs reversed</font></p>

<div id="test"></div>	
</center>
</body>
</html>


