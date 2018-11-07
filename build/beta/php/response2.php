<?php 

//header("Content-type: text/xml; charset=UTF-8");

// EXTERNAL RESOURCES
require_once "functions.php";
require_once "rank-sentences.php";
require_once "util.php";
include "respond.php";


// VARIABLES
$punctuation = array('.', ',', ';', ':', '!', '(', ')', '[', ']', '{', '}', '?', '\"', '|', '<', '>', '/', '-', '_', '~');
$startingPunctuation = array('...', '!', '(', '?', '[', ']', '{', '}', '�', '<', '�', ';', '\"', '~');
$endingPunctuation = array('.', '!', ')', '?', ']', '}', '�', '>', '�', ';', '~');
$punctuations = array("start"=>$startingPunctuation, "end"=>$endingPunctuation, "global"=>$punctuation);

$url="http://www.google.com/search?num=10&q=";
$urlTail="-filetype:pdf+-filetype:ppt+-filetype:xls+-filetype:doc+-filetype:rtf";	

$html="";
$htmlCropMarks=array("start"=>"<div class=g>", "end"=>"<div id=navbar class=n>");

$descriptions = "";
$descriptionsArray = array();
$descriptionsNeedles=array("start"=>"<font size=-1>", "end"=>"<span class=a>");

$linkNeedles=array("start"=>"<h2 class=r><a href=", "end"=>" class=l>");

$useless1=array("start"=>"<span class=f>", "end"=>"</span>");
$useless2=array("start"=>"<font color=#6f6f6f>", "end"=>"</font>");
$uselessArray=array($useless1,$useless2);


// GETTERS AND SETTERS 

function get_input()
{
	if (isset($input)) return $input;
	else return "input not set";
}

function set_input($value)
{
	$input = $value;	
}

function get_response()
{
	if (isset($response)) return $response;
	else return "response not set";
}

/*
// SWITCH FILTERING MODE
if (isset($HTTP_GET_VARS['filter'])) $filter=$HTTP_GET_VARS['filter'];
else $filter = "moderate";
 
switch($filter){
		
	case "off":
		$searchString = $HTTP_GET_VARS['input'];
		break;
			
	case "moderate":
		$numselects=0;
		session_start();
		$myuniqueid=session_id();
		$botresponse = replybotname($HTTP_GET_VARS['input'],$myuniqueid,$HTTP_GET_VARS['botname']);
		if (isset($botresponse)) $searchString = $botresponse->response;
		else $searchString = $HTTP_GET_VARS['input'];
		break;
		
	case "on":
		$numselects=0;
		session_start();
		$myuniqueid=session_id();
		$botresponse = replybotname($HTTP_GET_VARS['input'],$myuniqueid,$HTTP_GET_VARS['botname']);
		$response=$botresponse->response;
		break;
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
	//echo $url;

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

	$response = $googleResponse;
	//$link = get_url($rankedSentences, $descriptionsArray, $html, $linkNeedles);

	// LOG USER INPUT AND GOOGLE RESPONSE
	g_logconversation($HTTP_GET_VARS['input'],$googleResponse);
	
}
*/


// create the XML RESPONSE
/*
if (isset($response)){
	
	$xml_output  = "<?xml version=\"1.0\"?>\n"; 
	$xml_output .= "<response>\n";
	$xml_output .= "\t<text><![CDATA[" . $response . "]]></text>\n";
	//$xml_output .= "\t<url><![CDATA[" . $link . "]]></url>\n";
	$xml_output .= "</response>";
	
	echo $xml_output;
			
}
*/
?>