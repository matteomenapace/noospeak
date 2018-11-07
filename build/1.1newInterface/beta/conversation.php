
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Chat with Google</title>
<style type="text/css" media="screen">
	@import "../../styles/googlebot03conversation.css";
</style>
</head>

<body onLoad=	"document.getElementById('inputbox').focus();
						 var msgBox = document.getElementById('leftbar');
						 msgBox.scrollTop = msgBox.scrollHeight - msgBox.clientHeight">

<div id="wrap">

	<div id="leftbar" onMouseUp="	document.getElementById('inputbox').focus()">
	<!--<div class="google">
				<div class="name">Google<br></div>
				<div class="text">Hi, I am Google, who are you?</div>
				<div class="info">13:38 06.03.2007 Mountain View (CA) - <a href=#>similar topic</a></div>
			</div>-->
			<?php echo ($history); ?>
	</div>
	
	<div id="rightbar">
		<div class="tagcloud" id="users">
			<div class="header">
				<div class="label">users</div>
				<div class="navigation">
					<b>View: </b><a href=#>most popular</a> - <a href=#>most recent</a> - <a href=#>all</a>
				</div>
			</div>		
			<div class="cloud">
				<?php include("tagcloud-users.php"); ?>
			</div>	
		</div>
		
		<div class="tagcloud" id="google">
			<div class="header">
				<div class="label">google</div>
				<div class="navigation">
					<b>View: </b><a href=#>most popular</a> - <a href=#>most recent</a> - <a href=#>all</a>
				</div>
			</div>	
			
			<div class="cloud">
				<?php include("tagcloud-google.php"); ?>
			</div>	
		</div>
	</div>
</div>

<div id="footer">
	<a id="logo" href=""><span></span></a>
	<div class="box" >
		<div id="status">
			Google is thinking...
		</div>
		<div id="form">
		<form method="post" name="chatform" autocomplete="off" action="<?php echo ACTION; ?>">
			<input type="hidden" name="<?php session_name(); ?>" value="<?php echo $uid; ?>">
			<input type="hidden" name="botname" value="<?php echo BOT_NAME; ?>">	
			<input id="inputbox" type="text" name="input" value="">
			 <input type="submit" name="submit" value="Speak to Google">
		</form>
		</div>
		<ol id="navigation">
			<li><a href=#>F.A.Q.</a></li>
			<li><a href=#>Feedback</a></li>
			<li><a href=#>Privacy</a></li>
			<li class="last"><a href=#>Terms of Use</a></li>
		</ol>	
	</div>	
</div>

</body>
</html>

