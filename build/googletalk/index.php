<?php 

////////////////////////// SESSION ////////////////////////////////

session_start();
// retrieves information about the current session

$session_id = session_id();

session_regenerate_id();
$new_session = session_id();
//echo("<br>new_session: " . $new_session);

if (isset($_POST["input"]) && $_POST["input"]!=="") {
	$session_id = $new_session;
	//echo("<br>(new)session_id: " . $session_id);
} elseif (isset($_GET["session"])) {
	$session_id = $_GET["session"];
	//echo ("<br>old session: " . $session_id);
} //end if (isset($_GET["session"]))

///////////////////////////////////////////////////////////////////

////////////////////////// VARIABLES AND INCLUDES /////////////////

include "db.php";
include "functions.php";

$DB_TABLE = "google_01";

$action = "index.php";
$restart = "index.php";

$url="http://www.google.com/search?num=50&q=";
$urlTail="-filetype:pdf+-filetype:ppt+-filetype:xls+-filetype:doc+-filetype:rtf";

$punctuation = array('.', ',', ';', ':', '!', '(', ')', '[', ']', '{', '}', '?', '\"', '|', '<', '>', '/', '-', '_', '~', '’', '"', '”', '*', '«', '»', '·', '—', '\'');

$htmlCropMarks=array("start"=>"<div class=g>", "end"=>"<div id=navbar class=n>");

$descriptionsArray = array();
$descriptionsNeedles=array("start"=>"<font size=-1>", "end"=>"<span class=a>");

$useless1=array("start"=>"<span class=f>", "end"=>"</span>");
$useless2=array("start"=>"<font color=#6f6f6f>", "end"=>"</font>");
$uselessArray=array($useless1,$useless2);

$MAX_SEARCH_STRING = 7;


///////////////////////////////////////////////////////////////////

////////////////////////// SEARCH STRING //////////////////////////

if  (isset($_POST["input"]) && $_POST["input"]!=="") {
	$searchString = $_POST["input"];
	foreach ($punctuation as $value) $searchString=trim(str_replace($value, "", $searchString));
	$stringLogged = log_search_string($DB_TABLE, $session_id, $searchString);
	//echo ("<br>logged successfully? " . $stringLogged);
} else  $searchString = get_search_string($DB_TABLE, $session_id);
//echo ("<br>searchString: " . $searchString);

///////////////////////////////////////////////////////////////////

////////////////////////// GOOGLE URL /////////////////////////////

$searchWords = explode (" ", $searchString);
foreach ($searchWords as $value) {
	$value=trim($value);
	if ($value!=="") {
		$searchWord = $value;
		$url .= $searchWord . "+";
	}
}
$url .= $urlTail;
//echo ("<br>url: " . $url);

///////////////////////////////////////////////////////////////////

////////////////////////// HTML BULK //////////////////////////////

$html=implode (" ", file($url));
	
$htmlFrom=strpos($html, $htmlCropMarks["start"]);
$html=trim(substr($html, $htmlFrom));
$htmlTo=strpos($html, $htmlCropMarks["end"]);
$html=trim(substr($html,0,$htmlTo));
//echo("<br>html: <br>" .$html);

///////////////////////////////////////////////////////////////////

////////////////////////// LINKS DESCRIPTIONS /////////////////////

$descriptionsArray = extract_array($html, $descriptionsNeedles["start"], $descriptionsNeedles["end"], $descriptionsArray);
$polishedDescriptions=array();
foreach($descriptionsArray as $description){
	foreach ($uselessArray as $useless){
		$description = eliminate_useless ($description, $useless["start"], $useless["end"]);
		// eliminate part of the description referring to pdf files and other crap
	}
	$description = unhtmlentities ($description);
	$description= strip_html_tags($description);
	// get rid of html special characters (such as &#39;) and html tags
	
	foreach ($punctuation as $value) $description=trim(str_replace($value, " ", $description));
	
	array_push($polishedDescriptions, $description);
}
//print_r($polishedDescriptions);
$descriptions = implode (" ", $polishedDescriptions);
//echo ("<br>descriptions: " . $descriptions);

///////////////////////////////////////////////////////////////////

////////////////////////// NEXT WORDS /////////////////////////////

//echo ("<br>searchWord: " . $searchWord);
$findMe = $searchWord;
$words = getNextWordsArray ($findMe, $descriptions);

/*echo "<br>words <pre>";
print_r($words);
echo "</pre>";*/

///////////////////////////////////////////////////////////////////

////////////////////////// ONE WORD ///////////////////////////////

$words_length=sizeof($words);
for ($i=0; $i<$words_length;$i++){
	if (!isset($w_checked)){
		$w_checked[]=$words[$i];
		$key=$words[$i];
		$w_count[$key]=1;
		//echo (key($w_count));
	} elseif (in_array($words[$i],$w_checked)){
		$key=$words[$i];
		$w_count[$key]++;
	} elseif (!in_array($words[$i],$w_checked)){
		$w_checked[]=$words[$i];
		$key=$words[$i];
		$w_count[$key]=1;
	}
}		

if (count($w_count) > 0) {
	arsort($w_count);
	// sorts $w_count elements from the biggest to the smalles, maintainig their keys
	reset($w_count);
	// reset the array pointer on the first element

	/*echo "<br>w_count <pre>";
	print_r($w_count);
	echo "</pre>";*/
	
	$new_word = key($w_count);
	
	while (in_array($new_word,$searchWords) || strlen($new_word) < 2) {
		//echo("<br>" . $new_word . " is already in this ");
		//print_r ($searchWords);
		array_shift($w_count);
		reset($w_count);
		// eliminates first array element and reset the array pointer on the first element 
		if (count($w_count) > 0) $new_word=key($w_count); 
		else return;
	}

	//echo ("<br>new_word after while is: >>" . $new_word . "<<<br>");
	
} else $new_word = "Google";	

//echo ("<br>new_word is: >>" . $new_word . "<<<br>");		
//echo ("<br> new_word's length is: " . strlen($new_word));
	
$sentence= " " . $new_word;

///////////////////////////////////////////////////////////////////

////////////////////////// UPDATE SEARCH STRING ///////////////////

if (count($searchWords) < $MAX_SEARCH_STRING) {
	$searchString .= " " . $new_word;
} else {
	array_shift($searchWords);
	array_push($searchWords,$new_word);
	$searchString = implode(" ", $searchWords);
} 

//echo ("<br>new searchString is: " . $searchString . "<br>");

///////////////////////////////////////////////////////////////////

////////////////////////// LOG SENTENCE ///////////////////////////

if (isset($_POST["input"]) && $_POST["input"]!=="") $sentence = $searchString;
else $sentence = get_sentence ($DB_TABLE, $session_id) . " " . $new_word;
//echo ("<br>sentence is: " . $sentence . "<br>");

/*$sentence = get_sentence ($DB_TABLE, $session_id);
if ($sentence == "") $sentence = $searchString;*/


$stringAndSentenceLogged = log_sentence($DB_TABLE, $session_id, $searchString, $sentence);
//echo ("<br>logged successfully? " . $stringAndSentenceLogged);

///////////////////////////////////////////////////////////////////




?>


<html>
<head>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>

<!--<b>Speak to Google</b><br>-->
<div class="tip">Type something in the box, and Google will build on your sentence. Click on "continue" to make Gooogle add new words.</div>

<form method="post" action="<?php echo $action; ?>">
<input  onFocus="clearInterval(intervalID)" onMouseDown="clearInterval(intervalID)" type="text" name="input">
<input type="submit" size=80 value="Speak to Google">
</form> 

<div class="entry">
	<div class="label">Google says:</div>
    <div class="content"><?php echo ($sentence); ?></div>
</div>

<br><a  href="<?php echo ( $restart . "?session=" . $session_id ); ?>" title="continue">continue</a>


</body>
</html>
