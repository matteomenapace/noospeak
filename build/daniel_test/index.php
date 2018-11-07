<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Noospeak</title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="php/server.php?client"></script>
<script src="http://www.google.com/uds/api?file=uds.js&amp;v=1.0&amp;key=ABQIAAAAJEZgazCxg-mkIInnslzBPBTZbOCVrw7JuujFhfgSl2g24yPDJRRvm--hxUymxwwftQdMSzSlyP-WVA" type="text/javascript"></script>
<script type="text/javascript" src="js/utility.js"><!--// ajax utility //--></script>

</head>


<body onLoad="OnLoad()">

<!--START-->
<div id="start">
<center>
	<div id="logo"></div>

	<div class="form">
	<form method="get" name="startForm" onSubmit="search(this.input.value,getRadioValue(this),this.botname.value); return false">
		<table cellpadding=0 cellspacing=0>
      		<tr valign=top>
        		<td width=25%>&nbsp;</td>
       			<td align=center nowrap>
          			<input autocomplete="off" id="inputStart" class="inputBox" type="text" name="input" value="" />
					<input type="hidden" name="botname" value="Google alpha 01" />
		          	<br>
          			<input type="Submit" value="Speak to Google"><input type="button" value="I'm Feeling Curious" />
				</td>
				<td align="left" width=25% class="preferences" id="preferences">
					<input id='strict-filter' type='radio' name='filter' value='on' title="Pure Artificial Intelligence. It may be boring, after a while." >Use strict filtering<br>
					<input id='moderate-filter' type='radio' name='filter' value='moderate' title="Artificial Intelligence applied to filter Web results." checked>Use moderate filtering<br>
					<input id='no-filter' type='radio' name='filter' value='off' title="Pure Web discourse. It may not make much sense, sometimes.">Do not filter my conversation
				</td>
        	</tr>
    	</table>
	</form>
	</div>
	
	<div id="links">
		Forget about keyword search, Google is learning to speak! <a href="faq/01.html">Learn more</a>
		<br><br><br>
		<a href="mailto:i.am.dissatisfied@gmail.com">Feedback</a> - 
		<a href=#>Privacy</a> - 
		<a href=#>Terms of Use</a>
	</div>
	
	<div id="copyright">
		Powered by Google Search
	</div>
	
</center>	
</div>


<!--CONVERSATION-->
<div id="conversation">
<div id="wrap">
	<div id="chatLog">
	</div>

	<div id="chatClouds">
	
		<div id="chatCloudTop">
			<table width="100%" height="100%" border="0" cellpadding="5" cellspacing="0" class="chatCloud">
            	<tr>
                	<td height="70" valign="top">
						<p class="label">Users</p>
						<p class="navigation">navigation</p>
						<p class="status" id="cloudTopStatus">status</p></td>
				</tr>
            	<tr>
            		<td valign="top">
						<iframe src ="content_01.html" frameborder="0" class="chatCloudContent" id="chatCloudContentTop" name="cloudTop"></iframe></td>
          		</tr>
			</table>
		</div>
		
		<div id="chatCloudBottom">
			<table width="100%" height="100%" border="0" cellpadding="5" cellspacing="0" class="chatCloud">
            	<tr>
                	<td height="70" valign="top">
						<p class="label">Google*</p>
						<p class="navigation">navigation</p>
						<p class="status" id="cloudBottomStatus">status</p></td>
				</tr>
            	<tr>
            		<td valign="top">
						<iframe src ="content_01.html" frameborder="0" class="chatCloudContent" id="chatCloudContentBottom" name="cloudBottom"></iframe></td>
          		</tr>
		  </table>
		</div>
	</div>
</div>

<div id="footer">
		
		<a id="logo-small" href=""><span></span></a>
		
		<div class="box" >
			<div class="status" id="status">
				<!--Google is thinking...-->
			</div>
		
			<div class="form">
			<form method="get" name="chatform" autocomplete="off" onSubmit="search(this.input.value,this.filter.value,this.botname.value); return false">
				<input id="inputConversation" class="inputBox" type="text" name="input" value="" />
				<input id="filterField" type="hidden" name="filter" />
				<input type="hidden" name="botname" value="Google alpha 01" />
				<input type="Submit" value="Speak to Google" />
			 
				<!--<input type="hidden" name="<?php session_name(); ?>" value="<?php echo $uid; ?>">-->
				<!--<input type="hidden" name="botname" value="Google alpha 01"> -->
			</form>
			</div>
		
			<ol id="navigation">
				<li><a href="faq/01.html">F.A.Q.</a></li>
				<li><a href="mailto:i.am.dissatisfied@gmail.com">Feedback</a></li>
				<li><a href=#>Privacy</a></li>
				<li class="last"><a href=#>Terms of Use</a></li>
			</ol>	
		
		</div>	
	</div>
</div>

</body>	
</html>
