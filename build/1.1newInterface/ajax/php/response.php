<?php 

// EXTERNAL RESOURCES
require_once "functions.php";
require_once "rank-sentences.php";
require_once "util.php";
include "respond.php";


// VARIABLES
$punctuation = array('.', ',', ';', ':', '!', '(', ')', '[', ']', '{', '}', '?', '\"', '|', '<', '>', '/', '-', '_', '~');
$startingPunctuation = array('...', '!', '(', '?', '[', ']', '{', '}', '–', '<', '·', ';', '\"', '~');
$endingPunctuation = array('.', '!', ')', '?', ']', '}', '–', '>', '·', ';', '~');
$punctuations = array("start"=>$startingPunctuation, "end"=>$endingPunctuation, "global"=>$punctuation);

$url="http://www.google.com/search?num=10&q=";
$urlTail="-filetype:pdf+-filetype:ppt+-filetype:xls+-filetype:doc+-filetype:rtf";	

$html="";
$htmlCropMarks=array("start"=>"<div class=g>", "end"=>"<div id=navbar class=n>");

$descriptions = "";
$descriptionsArray = array();
$descriptionsNeedles=array("start"=>"<font size=-1>", "end"=>"<span class=a>");

$useless1=array("start"=>"<span class=f>", "end"=>"</span>");
$useless2=array("start"=>"<font color=#6f6f6f>", "end"=>"</font>");
$uselessArray=array($useless1,$useless2);


// SWITCH FILTERING MODE
if (isset($_GET['filter'])){
	$filter=$_GET['filter'];
	switch($filter){
		
		case "off":
			$searchString = $_GET['input'];
			break;
			
		case "moderate":
			$numselects=0;
			session_start();
			$myuniqueid=session_id();
			//include "respond.php";
			$botresponse = replybotname($_GET['input'],$myuniqueid,$_GET['botname']);
			if (isset($botresponse)) $searchString = $botresponse->response;
			else $searchString = $_GET['input'];
			break;
			
		case "on":
			$numselects=0;
			session_start();
			$myuniqueid=session_id();
			//include "respond.php";
			$botresponse = replybotname($_GET['input'],$myuniqueid,$_GET['botname']);
			echo $botresponse->response;
			break;
	}
}

if (isset($searchString)){
	
	// PROCESS BOT RESPONSE TO  CREATE AN ARRAY OF WORDS
	$searchString = eliminate_string($searchString, "<br/>");
	foreach ($punctuation as $value) $searchString=trim(str_replace($value, "", $searchString));
	$searchWords = explode (" ", $searchString);

	// CREATE URL FOR GOOGLE SEARCH
	foreach ($searchWords as $value) {
		$searchWord=trim(strip_html_tags($value));
		if ($searchWord!=="") $url .= $searchWord . "+";
	}
	$url .= $urlTail;

	// PROCESS GOOGLE RESULT PAGE TO EXTRACT THE LINKS' DESCRIPTIONS
	$html=implode (" ", file($url));
	
	$htmlFrom=strpos($html, $htmlCropMarks["start"]);
	$html=trim(substr($html, $htmlFrom));
	$htmlTo=strpos($html, $htmlCropMarks["end"]);
	$html=trim(substr($html,0,$htmlTo));
	// crop the "head" and "tail" of the html

	$descriptionsArray = extract_array($html, $descriptionsNeedles["start"], $descriptionsNeedles["end"], $descriptionsArray);

	// POLISH LINKS' DESCRIPTIONS
	$polishedDescriptions=array();
	foreach($descriptionsArray as $description){
		foreach ($uselessArray as $useless){
			$description = eliminate_useless ($description, $useless["start"], $useless["end"]);
			// eliminate part of the description referring to pdf files and other crap
		}
		$description = unhtmlentities ($description);
		$description= strip_html_tags($description);
		// get rid of html special characters (such as &#39;) and html tags
		array_push($polishedDescriptions, $description);
	}

	// EXTRACT ONE SENTENCE, THE ONE USER WILL READ
	if (count($polishedDescriptions)>0){
		$semiRankedSentences = get_semi_ranked_sentences ($polishedDescriptions, $searchWords, $punctuations);
		$rankedSentences = get_ranked_sentences ($semiRankedSentences);
		$googleResponse = get_sentence ($rankedSentences, $polishedDescriptions); 
		if ($googleResponse=="") $googleResponse = "...";
	} else $googleResponse = "...";

	echo ($googleResponse);

	// LOG USER INPUT AND GOOGLE RESPONSE
	g_logconversation($_GET['input'],$googleResponse);
	
}

?>