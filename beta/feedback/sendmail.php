<html>
<head>
<title>NooSpeak Feedback</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="description" content="NooSpeak is an innovative approach to Web search. You can chat with to your favourite search engine, instead of squeezing your brain to find the right set of keywords.">
<link rel="icon" href="../images/favicon.ico" />

<style type="text/css"> 
	body{font-family:Arial, Helvetica, sans-serif; font-size:0.9em; margin:0; padding:0;}
	a, a:active {color:#6699FF;}
	a:hover {background:#6699FF; color:#FFFFFF; text-decoration:none;}
	a:visited {color:#66FF00;}
	a:visited:hover {color:#FFFFFF;}
	h1 {background:#66FF00; color:#FFFFFF; font-size:1em; margin:0 12px; padding:5px;}
	#logo { margin-left:12px; margin-top:10px; display:block; background-color:#FFFFFF;}
	#logoSmall { position:relative; top:0.35em; background:transparent;}
	p { margin:12px; margin-bottom:0px;}
</style>
</head>

<body>

	<a id="logo" href="../index.php">
		<img 	height="39" 
				width="203" 					
				border="0" 
				src="../images/logo_medium_01.gif" 
				alt="NooSpeak Home">
	</a>
	<br>
	<h1>NooSpeak: Feedback Form</h1>

<?php

	/* Specify your SMTP Server, Port and Valid From Address */
  	ini_set("SMTP","smtp.baddeo.com");
  	ini_set("smtp_port","25");
  	ini_set("sendmail_from","i.am.dissatisfied@gmail.com");
	
	$tryAgain = "01.html";

	$to = "iosonomatteo@gmail.com";
	
	$name = stripslashes($_POST['name']);
	$from = stripslashes($_POST['email']);
	$subject = stripslashes($_POST['subject']);
	
	$headers = "From: $name <$from>";

	$fields = array();
	$fields{"name"} = "name";
	$fields{"email"} = "email";
	$fields{"message"} = "message";

	/*$body = "We have received the following information:\n\n"; 
	
	foreach ($fields as $a => $b) { 
		$body .= sprintf("%20s: %s\n",$b,stripslashes($_POST[$a]));
	}*/
	
	$body = stripslashes($_POST['message']);

	$autoreplyHeaders = "From: i.am.dissatisfied@gmail.com";
	$autoreplySubject = "Thank you for contacting NooSpeak";
	$autoreplyBody = "Thank you for contacting NooSpeak. Somebody will get back to you as soon as possible, usually within 24 hours.";
	
	
	$send = mail($to, $subject, $body, $headers);	
	//$autoreplySend = mail($from, $autoreplySubject, $autoreplyBody, $autoreplyHeaders);
	
	$echo = "<p>";
	if($send) $echo .= "Your message has been sent successfully! Now get back to <a id='logoSmall' href='../index.php'><img height='20' width='102' border='0' src='../images/logo_small_01.gif' alt='NooSpeak Home'></a></p>";
	else $echo .= "Ops! An error occurred while sending your message. Could you <a href='" . $tryAgain . "'>try again</a>?</p>"; 
	
	echo $echo;

?>

<!--	<center>
		<hr noshade color="#66FF00">
		<a id="logoSmall" href="../index.php">
			<img 	height="20" 
					width="102" 					
					border="0" 
					src="../images/logo_small_01.gif" 
					alt="NooSpeak Home">
		</a>
	</center>-->

</body>
</html>


