<?php

include "respond.php";
if (isset($HTTP_POST_VARS['input'])){
	$new_conversation=0;
	$numselects=0;
	// Start the session or get the existing session.
	session_start();
	$myuniqueid=session_id();
	// Here is where we get the reply (from respond.php)
	$botresponse = replybotname($HTTP_POST_VARS['input'],$myuniqueid,$HTTP_POST_VARS['botname']);
	$conversation = getconversation();
	/*
	echo "<pre>";
	print_r($conversation);
	echo "</pre>";
	*/
	
	
	$history="";
	foreach ($conversation as $value) $history .= $value;
	//echo ("history: " . $styled_conversation);
	// Print the results.
	//echo "<B>Google: " . $botresponse->response . "<BR></b>";
	//echo "<BR><BR>execution time: " . $botresponse->timer;
	//echo "<BR>numselects= $numselects";
	//print_r($botresponse->inputs);
	//print_r($botresponse->patternsmatched);
} else {
	$new_conversation=1;
	$availbots=array();
	// Get all the names of our bots.
	$query="select botname from bots";
    $selectcode = mysql_query($query);
    if ($selectcode) {
        if (!mysql_numrows($selectcode)) {
        } else {
            while ($q = mysql_fetch_array($selectcode)){
                $availbots[]=$q[0];
            }
        }
    }
}	
?>	
	



<?php 
//include ("php/PHP-after-input.php");
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Chat with Google</title>
<style type="text/css" media="screen">
	@import "styles/style01.css";
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
<center>
<a id="logo" href="index.html"><img src="images/logo.gif" width=276 height=110 alt="Google"></a>
<br>
<!--<table border=0 cellspacing=0 cellpadding=4>
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
</table>-->
<div class="container">
<div id="history" onMouseUp="	document.getElementById('box').focus()">
	<?php 	if (isset($botresponse)) {
					echo ($history);
				} else {
					echo ("<div class=\"google\"><div class=\"name\"><b>Google</b><br></div><div class=\"text\">Hi, I am Google, what about you?</div></div>");
				}
	?>
	</div>	
</div>
<!--<table class="container" cellpadding="0" cellspacing="0" onMouseUp="focusInputbox()">
	<tr>
		<td align="left"><input class="eyebrow" type="button" value=""></td>
		<td></td><td></td><td></td>
		<td align="right"><input class="eyebrow" type="button" value=""></td>
	</tr>
	<tr>
		<td class="eye" align="center"><input type="radio" checked></td>
		<td align="right" valign="bottom"><input type="checkbox"></td>
		<td align="center"><select id="nose" size=5 multiple><option><option><option><option></select></td>
		<td align="left" valign="bottom"><input type="checkbox"></td>
		<td></td><td></td><td></td>
		<td class="eye" align="center"><input type="radio" checked></td>
	</tr>
</table>-->
<table id="beard" cellpadding="0" cellspacing="0">
	<tr>
		<td id="mouth" align="center">
		<form method="post" name="chatform" autocomplete="off" action="talk2.php">
		<? if ($new_conversation==0) {
				//echo ("Are we starting a new conversation?" . $new_conversation . "<br>");	
				echo ( "<input type=\"hidden\" name=\"" . session_name() . "\" value=\"" . $uid . "\">
							<input type=\"hidden\" name=\"botname\" value=\"" . $HTTP_POST_VARS['botname'] . "\">");
			} else {
				//echo ("Are we starting a new conversation?" . $new_conversation . "<br>");	
				echo ("Talk to: <select name=\"botname\">");
				foreach ($availbots as $bot){
					echo ("<option value=\"" . $bot . "\">$bot</option>");
				}
				echo ("</select><br>");
			}
		?>
		<input id="box" type="text" name="input" value="" onKeyPress="return keyListener(event)">
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
<!--	<font size=-1>
	<a href=# onMouseOver="window.status='';return true" onMouseUp="alert('1. write something in the box\n2. press Enter\n3. wait for Google to answer\n4. repeat, and enjoy the conversation')">How do I chat with Google?</a> - 
	<a href=# onMouseOver="window.status='';return true" onMouseUp="alert('Why not?')">Why?</a> - 
	<a href="http://www.google.com/technology/pigeonrank.html" target="_blank" onMouseOver="window.status='';return true">About this project</a> - 
	<b><a href=# onMouseOver="window.status='';return true" onMouseUp="alert('We are happy to hear from you!\nPlease write to:\ni.am.dissatisfied@gmail.com')">Dissatisfied? Help us improve</a></b>
	</font>-->
	<p><font size=-2>&copy;2006 Google - All rights and wrongs reversed</font></p>
</center>
</body>
</html>
