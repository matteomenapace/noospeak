<?php
// $Id: autocomplete_server.php,v 1.5 2004/11/23 14:10:56 harryf Exp $
/**
* This is a remote script to call from Javascript
*/

define ('JPSPAN_ERROR_DEBUG',TRUE);
require_once '../JPSpan.php';
require_once JPSPAN . 'Server/PostOffice.php';
require_once "functions.php";
require_once "rank-sentences.php";
require_once "util.php";
include "respond.php";
include "chatCloud/cloud.php";



//-----------------------------------------------------------------------------------
class myServer {

    function getResponse($input,$filter,$botname) {
	
		$searchString = "";
		
		switch($filter){
		
		case "off":
			$searchString = $input;
			break;
			
		case "moderate":
			$numselects=0;
			session_start();
			$myuniqueid=session_id();
			$botresponse = replybotname($input,$myuniqueid,$botname);
			if (isset($botresponse)) $searchString = $input.' '.$botresponse->response;
			else $searchString = $input;
			break;

	}

        return $searchString;
    }
	
	function getRanked($searchString,$descriptionsArray,$input) {
		
		session_start();
	
		$punctuation = array('.', ',', ';', ':', '!', '(', ')', '[', ']', '{', '}', '?', '\"', '|', '<', '>', '/', '-', '_', '~');
		$useless1=array("start"=>"<span class=f>", "end"=>"</span>");
		$useless2=array("start"=>"<font color=#6f6f6f>", "end"=>"</font>");
		$uselessArray=array($useless1,$useless2);
		$startingPunctuation = array('...', '!', '(', '?', '[', ']', '{', '}', '–', '<', '·', ';', '\"', '~');
	$endingPunctuation = array('.', '!', ')', '?', ']', '}', '–', '>', '·', ';', '~');
	$punctuations = array("start"=>$startingPunctuation, "end"=>$endingPunctuation, "global"=>$punctuation);

		$searchString = eliminate_string($searchString, "<br/>");
		foreach ($punctuation as $value) $searchString=trim(str_replace($value, "", $searchString));
		$searchWords = explode (" ", $searchString);
		
		$polishedDescriptions=array();
		foreach($descriptionsArray as $description){
		foreach ($uselessArray as $useless){
			$description = eliminate_useless($description, $useless["start"], $useless["end"]);
			// eliminate part of the description referring to pdf files and other crap
		}
		$description = unhtmlentities($description);
		$description= strip_html_tags($description);
		// get rid of html special characters (such as &#39;) and html tags
		array_push($polishedDescriptions, $description);
	}
	
	//return $polishedDescriptions[0];

	// EXTRACT ONE SENTENCE, THE ONE USER WILL READ
	if (count($polishedDescriptions)>0){
		$semiRankedSentences = get_semi_ranked_sentences ($polishedDescriptions, $searchWords, $punctuations);
		$rankedSentences = get_ranked_sentences ($semiRankedSentences);
		$result = get_sentence($rankedSentences, $polishedDescriptions);
		$googleResponse = $result[0]; 
		$index = $result[1];
		if ($googleResponse=="") $googleResponse = "...";
	} 
	else 
	{
		$googleResponse = "...";
		$index = 0;
		
	}

	$response = $googleResponse;
	//$link = get_url($rankedSentences, $descriptionsArray, $html, $linkNeedles);

	// LOG USER INPUT AND GOOGLE RESPONSE
	g_logconversation($input,$googleResponse);
	
	return array($response,$index,cloud(session_id(), 'user'),cloud(session_id(),'google'));	
	}
	
	function getResponseOn($input,$botname) {
	 
			$numselects=0;
			session_start();
			$myuniqueid=session_id();
			$botresponse = replybotname($input,$myuniqueid,$botname);
			$response=$botresponse->response;
			
			return $response;
	 }

}

$S = & new JPSpan_Server_PostOffice();
$S->addHandler(new myServer());

//-----------------------------------------------------------------------------------
// Generates the Javascript client by adding ?client to the server URL
//-----------------------------------------------------------------------------------
if (isset($_SERVER['QUERY_STRING']) && strcasecmp($_SERVER['QUERY_STRING'], 'client')==0) {
    // Compress the Javascript
    // define('JPSPAN_INCLUDE_COMPRESS',TRUE);
    $S->displayClient();
    
//-----------------------------------------------------------------------------------
} else {

    //-----------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------
    
    // Include error handler - PHP errors, warnings and notices serialized to JS
    //require_once JPSPAN . 'ErrorHandler.php';
    $S->serve();

}
?>