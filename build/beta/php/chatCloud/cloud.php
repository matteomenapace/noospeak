<?php 

// GET EXTERNAL RESOURCES
//require_once "../admin/dbprefs.php";
//require_once "../util.php";
//require_once "../functions.php";
require_once "TagCloud4.class.php";

// VARIABLES
/*if (isset($HTTP_GET_VARS['id'])) $id=($HTTP_GET_VARS['id']=='google')? 'response':'input';*/

function cloud($sessionId, $type){

if ($type=='google') $id='response';
else $id='input';

$words= array();
$words_info=array();
$crap = array('.', '?', "\"", '\"', '<br/>', ',', '!', '…', '(', ')', '“', '*', '‘', '-', '&', '&quot;', '/', '<b>', ':', ';', '/b>');

// CONNECT TO DATABASE
/*$db = mysql_connect($DB_HOST, $DB_UNAME, $DB_PWORD);
if ($db == FALSE) die ("database connection error");
mysql_select_db($DB_DB, $db) or die ("database selection error");*/

// CREATE WORDS CLOUD
$query = "SELECT * FROM g_conversationlog WHERE uid='$sessionId'";
$result = mysql_query($query);
// 2d array containing all words (1d) + their dates (2d)
while ($row = mysql_fetch_array($result)){
	$current_words = $row[$id];
	foreach ($crap as $value) $current_words = trim(str_replace($value, " ", $current_words));
	$current_words = explode (" ", $current_words);
	foreach ($current_words as $word) {
		$word=trim($word);
		if ($word!=="") {
			// each word must be recorded in the array with its timestamp
			$timestamp=strtotime ($row['enteredtime']) ;
			$words[$word][]=$timestamp;
			//echo $word . " entered at " . $row['enteredtime'] . "<br>";
		}	
	}
}
//
foreach ($words as $key => $value) {
	$c_word=$key;
	$c_length= count($value);
	$sum=0;
	foreach ($value as $date) {
		$sum +=$date;
	}
	$c_average_date=round($sum/$c_length);
	//echo (">>><b>" . $c_word . "</b><<< was used " . $c_length . " times and its average date is " . $c_average_date . "<br>");
	$words_info[] = array("word"=>$c_word, "count"=>$c_length, "date"=>$c_average_date);
}

$words_cloud = new HTML_TagCloud(36,24);
foreach ($words_info as $v) {
	//$url= "?tag=" . $v["word"];
	$url= "#";
	$words_cloud->addElement($v["word"], $url, $v["count"], $v["date"]);
}

return $words_cloud->buildALL();
// output HTML and CSS

/*$css = $words_cloud->buildCSS();
// CSS part only
$words_html = $words_cloud->buildHTML();
// html part only*/

}

/*
// DISPLAY INPUTS SORTED BY TAG
if (isset($_GET['tag'])) {
	$tag=$_GET['tag'];
	$query = "SELECT * FROM g_conversationlog WHERE $id LIKE '%$tag%' ";
	$result = mysql_query($query, $db);
	$sentences= array();
	$html_sentences= array();
	while ($row = mysql_fetch_array($result)) $sentences[] = $row[$id];
	foreach ($sentences as $sentence) {
		$sentence=trim($sentence);
		//echo $sentence . "<br>";
		$html_sentences[]= "<li>$sentence</li>";
	}
	$tagged_sentences = implode("", $html_sentences);
	echo ("<ul>" . $tagged_sentences . "</ul>");
}
*/

/*
echo "<pre>";
print_r($words_info);
echo "</pre>";
*/

?>