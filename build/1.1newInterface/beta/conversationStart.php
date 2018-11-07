
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Chat with Google</title>
<style type="text/css" media="screen">
	@import "../../styles/googlebot03start.css";
</style>
</head>

<body onLoad="document.getElementById('box').focus()">
<center>

	<div id="logo"></div>

	<div id="form">
		<form method="post" name="chatform" autocomplete="off" action="<?php echo ACTION; ?>">
			<input type="hidden" name="botname" value="<?php echo BOT_NAME; ?>">	
			<input id="inputbox" type="text" name="input" value="">
			 <br><input name=btnG type=submit value="Speak to Google"><input name=btnI type=submit value="I'm Feeling Curious">
		</form>
	</div>
	
	<div id="links">
		Forget keyword search, Google is learning to speak! <a href=#>Learn more</a>
		<br><br><br>
		<a href=#>Feedback</a> - 
		<a href=#>Privacy</a> - 
		<a href=#>Terms of Use</a>
	</div>
	
	<div id="copyright">
		&copy;2007 Google - All rights and wrongs reversed
	</div>

</center>
</body>
</html>
