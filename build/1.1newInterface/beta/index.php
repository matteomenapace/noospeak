<?php

define ("ACTION", "index.php");
define ("BOT_NAME", "Google alpha 01");
define ("G_RESPOND", "grespond.php");
define ("CONVERSATION", "conversation.php");
define ("CONVERSATION_START", "conversationStart.php");


if (isset($HTTP_POST_VARS['input'])){
	
	$numselects=0; // ?
	
	session_start();
	$myuniqueid=session_id();
	
	include "respond.php";
	$botresponse = replybotname($HTTP_POST_VARS['input'],$myuniqueid,$HTTP_POST_VARS['botname']);
	
	if (isset($botresponse)) {
		include G_RESPOND;
	}	
	
	$conversation = g_getconversation();
	$history="";
	//populate conversation history
	for($i=0; $i<count($conversation)-1; $i++){
		$history .= $conversation[$i];
	}
	//replace last value class (<div class='google/user'>) with <div id='last-entry'>
	$lastConversation = $conversation[count($conversation)-1];
	$cropLastConversation = substr($lastConversation, strpos($lastConversation,">")+1);
	$lastEntry = "<div id='last-entry'>" . $cropLastConversation;
	$history .= $lastEntry;
	
	include CONVERSATION;

} else {

	include CONVERSATION_START;
}

?>	




