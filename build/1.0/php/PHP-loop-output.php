<?php 

// GET EXTERNAL RESOURCES
include ("functions.php");
include ("db/db_config.php");

// GET SESSION ID
$session=$_GET['session'];
//echo "<br>session id is: " . $session;

// CONNECT TO DATABASE
$db = mysql_connect($db_host, $db_username, $db_password);
if ($db == FALSE) die ("<br>database connection error: " . mysql_error());
mysql_select_db($db_name, $db) or die ("<br>database selection error: " . mysql_error());

// GET LAST OUTPUT FROM DATABASE
$query = "SELECT MAX(id_c) FROM links WHERE id_s='$session'";
$result_id = mysql_query($query, $db);
while ($row_id = mysql_fetch_array($result_id)){ 
	$id_c = $row_id['MAX(id_c)'];
	$query = "SELECT txt FROM conversations WHERE id_c='$id_c'";
	$result_c = mysql_query($query, $db);
	while ($row_c = mysql_fetch_array($result_c)){ 
		$sentence = $row_c['txt'];
	}
}
//echo $sentence;

// PROCESS SENTENCE TO CREATE AN ARRAY OF WORDS
$punctuation = array('.', ',', ';', ':', '!', '(', ')', '?', "\"", '\"', '|', '<', '>', '/', '-', '_');
foreach ($punctuation as $value) $sentence=trim(str_replace($value,'',$sentence));
if ($sentence!="") $search_words = explode (" ", $sentence);
else $search_words = explode (" ", "Google does not care about your privacy");

// CREATE URL FOR GOOGLE SEARCH
$url="http://www.google.com/search?num=30&q=";
$url_tail="-filetype:pdf+-filetype:ppt+-filetype:xls+-filetype:doc+-filetype:rtf";		
foreach ($search_words as $value) {
	$search_word=trim(strtolower($value));
	if ($search_word!="") $url .= $search_word . "+";
}
$url .= $url_tail;
//echo $url . "<br>";

// PROCESS GOOGLE RESULT PAGE TO GET A SENTENCE
$html=implode (" ", file($url));
// inserts the google result page in a string
$html=trim(substr($html, "<a class=l"));
// crops the first part of the string, returning the part from the first occurrence of "<a class=l href" (first link to search result) to the end
$pos=strpos($html, "<div id=navbar class=n>");
$html=trim(substr($html,0,$pos));
// eliminate the tail of the html string (navbar, input box at the bottom and so on
$pre_description = "<td class=j><font size=-1>";
$after_description = "<span class=a>";
// pre and after are starting and ending parts of a link description in google html code
$descriptions = "";
$descriptions = extract_string ($html, $pre_description, $after_description, $descriptions);
$descriptions = eliminate_useless ($descriptions, "<span class=f>", "</span>");
$descriptions = eliminate_useless ($descriptions, "<font color=#6f6f6f>", "</a>");
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

/**/

/*
echo "<pre>";
print_r($sentences);
echo "</pre>";
*/

?>
