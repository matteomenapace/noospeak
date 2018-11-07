<html>
<head>
<title>Noospeak. Chat with your favourite search engine</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<meta name="description" content="NooSpeak is an innovative approach to Web search. You can chat with your favourite search engine, instead of squeezing your brain to find the right set of keywords.">

<link rel="icon" href="images/favicon.ico" />

<link href="css/style03.css" rel="stylesheet" type="text/css">
<!--[if lte IE 7]>
<link href="css/ie7.css" rel="stylesheet" type="text/css">
<![endif]-->

<script type="text/javascript" src="php/server.php?client"></script>
<script src="http://www.google.com/uds/api?file=uds.js&amp;v=1.0&amp;key=ABQIAAAAJEZgazCxg-mkIInnslzBPBTZbOCVrw7JuujFhfgSl2g24yPDJRRvm--hxUymxwwftQdMSzSlyP-WVA" type="text/javascript"></script>
<script type="text/javascript" src="js/utility.js"><!--// ajax utility //--></script>

</head>


<body onLoad="OnLoad()">


<div id="start">

	<div id="startLogo"></div>
	
	<form method="get" name="startForm" onSubmit="search(this.input.value,getRadioValue(this),this.botname.value); return false">
		<input type="hidden" name="botname" value="Google alpha 01" />
		
	<div id="startCenter" class="blueBox">
		Chat with your favourite search engine. <a href="faq/01.html">Learn more</a><br>
		<input 	autocomplete="off" 
				id="inputStart" 
				class="inputBox" 
				type="text" 
				name="input" 
				value=""/>
	</div>
	
	<div id="startArrow" class="arrow"></div>
	
	<div id="startRight" >
		
		<input 	type="image"
				name="submit"
				value="submit"
				alt="submit" 
				src="images/speak_button_up.gif" 
				onMouseOver="this.src='images/speak_button_over.gif'" 
				onMouseOut="this.src='images/speak_button_up.gif'">
				
		<div id="filterBox" class="greyBox">
			<div class="label">Filtering options</div>
			<input 	id='strict-filter' 
					type='radio' 
					name='filter' 
					value='on' 
					title="Pure Artificial Intelligence. It may be boring, after a while."/>Use strict filtering<br>
			<input 	id='moderate-filter' 
					type='radio' 
					name='filter' 
					value='moderate' 
					title="Artificial Intelligence applied to filter Web results." checked="checked"/>Use moderate filtering<br>
			<input 	id='no-filter' 
					type='radio' 
					name='filter' 
					value='off' 
					title="Pure Web discourse. It may not make much sense, sometimes."/>Do not filter my chat
		</div>
	</form>	
		
		<div class="greyBox" id="navStart">
			<ul>
				<li><a href='faq/01.html'>About</a></li>
				<li><a href='feedback/01.html'>Feedback</a></li> 
			 	<!--<li><a href=#>Terms of Use</a></li>-->
			</ul>	
		</div>
		
		<div class="greyBox" id="disclaimer">
			<div class="label">Disclaimer</div>
			<div id="disclaimerContent">The content of NooSpeak has not been authored by Google, nor it represents the views or opinions of Google or Google personnel. Therefore, Google does not accept any responsibility for the content found on this website. NooSpeak is not affiliated or sponsored by Google, it only uses the publicly available service known as <a href="http://www.google.com">Google Search</a>.</div>
			
		</div>	
	</div>
	
	<div id="startFootnote" align="center">
		*Google is a trademark of Google Inc.
	</div>
</div>




<!--CONVERSATION-->
<div id="conversation">

	<div id="conversationHeader">
		<a id="conversationLogo" href=""><span></span></a>
		
		<ul class="navigation">
				<li><a href="faq/01.html">About</a></li>
				<li><a href="feedback/01.html">Feedback</a></li>
				<!--<li><a href=#>Terms of Use</a></li>-->
				<li class="last"><a href=#>Disclaimer</a></li>
		</ul>
	</div>

	<div id="conversationWrap">
		
		<div id="chatLogWrap">	
			<div id="chatLog">
				<!--<div class="last-entry">
					<div class="name" id="google">NooSpeak:</div>
					<div class="content"> bla bla</div>
					<div class="time">sometime - </div>
					<div class="place">somewhere - </div>
					<div class="similar-topic">similar topic</div>
					<div class="more">more</div>
				</div>-->
			</div>
		</div>

	
	
		<div id="chatClouds">
		
			<div id="chatCloudTop">
				<table 	width="100%" 
						height="100%" 
						border="0" 
						cellpadding="5" 
						cellspacing="0" 
						class="chatCloud">
            		<tr>
                		<td class="header" valign="top">
							<p class="label">You</p>
							<!--<p class="navigation">navigation</p>
							<p class="status" id="cloudTopStatus">status</p>-->					
						</td>
					</tr>
            		<tr>
            			<td valign="top">
							<iframe 	src ="iframe_01.html" 
										frameborder="0" 
										class="chatCloudContent" 
										id="chatCloudContentTop"
										name="chatCloudContentTop"></iframe>					
						</td>
          			</tr>
				</table>
			</div>
		
			<div id="chatCloudBottom">
				<table 	width="100%" 
						height="100%" 
						border="0" 
						cellpadding="5" 
						cellspacing="0" 
						class="chatCloud">
            		<tr>
                		<td class="header" valign="top">
							<p class="label">NooSpeak</p>
							<!--<p class="navigation">navigation</p>
							<p class="status" id="cloudBottomStatus">status</p>-->				  
						</td>
					</tr>
            		<tr>
            			<td valign="top">
							<iframe 	src ="iframe_01.html" 
										frameborder="0"  
										class="chatCloudContent"
										id="chatCloudContentBottom"></iframe>				  
						</td>
          			</tr>
		  	</table>
			</div>
		</div>
	</div>	


	<div id="conversationFooter">
		
		<div id="conversationBlueBox" class="blueBox" >
		
			<div class="status" id="status">
				NooSpeak is thinking...
			</div>
			
			<!--<div id="filterBoxConversation">
				Filtering options
			</div>-->
		
		<form method="get" name="chatform" autocomplete="off" onSubmit="search(this.input.value,this.filter.value,this.botname.value); return false">
			<input type="hidden" name="filter" id="filterField" />
			<input type="hidden" name="botname" value="Google alpha 01" />
			<!--<input type="hidden" name="<?php session_name(); ?>" value="<?php echo $uid; ?>">-->
			<!--<input type="hidden" name="botname" value="Google alpha 01"> -->
		
			<input 	id="inputConversation" 
					class="inputBox" 
					type="text" 
					name="input" 
					value="" />
		</div >
		
		<div id="conversationArrow" class="arrow"></div>
		
		<div id="conversationButton">
			<input 	type="image"
				name="submit"
				value="submit"
				alt="submit" 
				src="images/speak_button_up.gif" 
				onMouseOver="this.src='images/speak_button_over.gif'" 
				onMouseOut="this.src='images/speak_button_up.gif'" />
		</div>
		</form>
		
		<div id="conversationFootnote">
			*Google is a trademark of Google Inc.
		</div>
		
		
	</div>
</div>	


</body>	
</html>
