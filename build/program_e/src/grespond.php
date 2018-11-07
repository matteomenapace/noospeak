<?php 

// GET EXTERNAL RESOURCES
require_once "functions.php";
require_once "util.php";

// PROCESS BOT RESPONSE TO  CREATE AN ARRAY OF WORDS
$search_string = $botresponse->response;
$punctuation = array('.', ',', ';', ':', '!', '(', ')', '?', "\"", '\"', '|', '<', '>', '/', '-', '_');
foreach ($punctuation as $value) {
	$search_string=trim(str_replace($value, "", $search_string));
	//echo ("<br> polished search string is: " . $search_string . " where >>> " . $value . " <<< has been removed");	
}
$search_words = explode (" ", $search_string);

// CREATE URL FOR GOOGLE SEARCH
$url="http://www.google.com/search?num=10&q=";
$url_tail="-filetype:pdf+-filetype:ppt+-filetype:xls+-filetype:doc+-filetype:rtf";		
foreach ($search_words as $value) {
	$search_word=trim($value);
	if ($search_word!="") $url .= $search_word . "+";
}
$url .= $url_tail;
//echo $url . "<br>";

// PROCESS GOOGLE RESULT PAGE TO EXTRACT THE LINKS' DESCRIPTIONS
$html=implode (" ", file($url));
// inserts the google result page in a string
$html=trim(substr($html, "<a class=l"));
// crops the first part of the string, returning the part from the first occurrence of "<a class=l href" (first link to search result) to the end
$pos=strpos($html, "<div id=navbar class=n>");
$html=trim(substr($html,0,$pos));
// eliminate the tail of the html string (navbar, input box at the bottom and so on)
$pre_description = "<td class=j><font size=-1>";
$after_description = "<span class=a>";
// pre and after are starting and ending parts of a link description in google html code
$descriptions = "";
$descriptions = extract_string ($html, $pre_description, $after_description, $descriptions);
$descriptions = eliminate_useless ($descriptions, "<span class=f>", "</span>");
$descriptions = eliminate_useless ($descriptions, "<font color=#6f6f6f>", "</font>");
// eliminates part of the description referring to pdf files
// "Your browser may not have a PDF reader available. Google recommends visiting our text version of this document."
$descriptions = unhtmlentities ($descriptions);
// gets rid of html special characters (such as &#39;)
$descriptions = strip_tags($descriptions);
//echo ("<br>" . $descriptions . "<br>");

/*
*RULE
*extracting first full sentence where the first word of $search_words is present 
*(if not present, second/third and so on) from links descriptions, 
*from the previous closest punctuation, till the next one
*/
$starting_punctuation = array('.', '!', '(', '?', '[', '{', '–', '<', '·');
$ending_punctuation = array('.', '!', ')', '?', ']', '}', '–', '>', '·');
$g_response = extract_first_sentence ($descriptions, $search_words, $starting_punctuation, $ending_punctuation, $botresponse->response);
//echo ("<br><b>". $g_response . "</b>");

// LOG USER INPUT AND GOOGLE RESPONSE
g_logconversation($HTTP_POST_VARS['input'],$g_response);

/*

echo "<pre>";
print_r($sentences);
echo "</pre>";


$descriptions = strtolower(strip_tags($descriptions));
$interruptions = array('.', ':', '!', '(', ')', '?', '|', '-', '+', '[', ']', '{', '}', '/', '»', '*', '–', '&quot;', '“', '<', '>', '&lt;', '&gt;');
$sentences = array();
$sentences = extract_sentence ($descriptions, $search_word, $interruptions, $sentences);
if (count($sentences)==0) $sentence="?";
else {
	$sentence = trim($sentences[rand(0,count($sentences)-1)]);
	while (check_numbers($sentence)) $sentence = trim($sentences[rand(0,count($sentences)-1)]); 
}	
$sentence = unhtmlentities ($sentence);
// gets rid of html special charcaters (such as &#39;)
$sentence = string_escape($sentence);
//echo $sentence;





// SAVE OUTPUT SENTENCE
$query = "INSERT INTO conversations (txt, type) VALUES ('$sentence', 'output')";
if (mysql_query($query, $db)) $id = mysql_insert_id();
else echo "<br>an error occured while saving google output: " . mysql_error();
//echo "<br><b>" . $id . "</b>";

// LINK SESSION ID WITH CONVERSATION ID
$query = "INSERT INTO links (id_s, id_c) VALUES ('$session', '$id')";
mysql_query($query, $db) or die ("<br>an error occured while linking session id with google output id: " . mysql_error());

// STYLE CONVERSATION HISTORY
$conversation = array();
$ps=""; //previous sentence (can be iether input ot output)
$query = "SELECT id_c FROM links WHERE id_s='$session'";
$result_id = mysql_query($query, $db);
while ($row_id = mysql_fetch_array($result_id)){ 
	$id_c = $row_id['id_c'];
	$query = "SELECT * FROM conversations WHERE id_c='$id_c'";
	$result_c = mysql_query($query, $db);
	while ($row_c = mysql_fetch_array($result_c)){ 
		$sentence = $row_c['txt'];
		if ($row_c['type']=="input") {
			$sentence = "<div class='user'><div class='name'><b>Me</b><br></div><div class='text'>" . $sentence . "<br></div></div>";
			$ps="i";
		} else if ($row_c['type']=="output") {
			if ($ps=="i") {
				$sentence = "<div class='google'><div class='name'><b>Google</b><br></div><div class='text'>" . $sentence . "<br></div></div>";
				$ps="o";
			} else $sentence = "<div class='google'><div class='text'>" . $sentence . "<br></div></div>";	
		}
		$conversation[] = $sentence;
	}
}
$styled_conversation="";
foreach ($conversation as $value) $styled_conversation .= $value;
*/

/*
echo "<pre>";
print_r($sentences);
echo "</pre>";
*/

?>