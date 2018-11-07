<?php 

include ("db/db_config.php");

require_once ("TagCloud4.php");
//date_default_timezone_set("Europe/London");




function string_escape($s) {
	if (!get_magic_quotes_gpc()) $s=addslashes($s);
	return $s;
}

// CONNECT TO DATABASE
$db = mysql_connect($db_host, $db_username, $db_password);
if ($db == FALSE){
	die ("database connection error");
}
mysql_select_db($db_name, $db) or die ("database selection error");

// SAVE USER INPUT (IF ANY)
if (isset($_POST['user_input']) && $_POST['user_input']!="") {
	$input = $_POST['user_input'];
	$input = string_escape($input);
	//echo $input . "<br>";
	$time = time();
	//echo $time . "<br>";
	$query = "INSERT INTO thisisnot_inputs (input, time) VALUES ('$input', '$time')";
	$insert = mysql_query($query, $db);
	if (!$insert){
		echo "an error occured while saving this input";
	} 
} 

// CREAT WORDS CLOUD
$query = "SELECT * FROM thisisnot_inputs ORDER BY time DESC";
$result = mysql_query($query, $db);
$words= array();
// 2d array containing all words (1d) + their dates (2d)
while ($row = mysql_fetch_array($result)){

	$current_words = explode (" ", $row['input']);
	// separates words from each row within the $current_words array
	
	if (in_array($input, $current_words)) {
	
	
		foreach ($current_words as $word) {
			$word=trim($word);
			$words[$word][]=$row['time'];
			// each word is inserted with its date
		}
		
		
		
	}
}
//
$words_info=array();
foreach ($words as $key => $value) {
	$c_word=$key;
	$c_length= count($value);
	// echo ($c_word . " was used " . $c_length . " times<br>");
	$sum=0;
	foreach ($value as $date) {
		$sum +=$date;
	}
	$c_average_date=round($sum/$c_length);
	$words_info[] = array("word"=>$c_word, "count"=>$c_length, "date"=>$c_average_date);
}

/*
echo "<pre>";
print_r($words_info);
echo "</pre>";
*/

$words_cloud = new HTML_TagCloud(36,24);
foreach ($words_info as $v) {
	$url= "?tag=" . $v["word"];
	$words_cloud->addElement($v["word"], $url, $v["count"], $v["date"]);
}
// print $words_cloud->buildALL();
// output HTML and CSS
$css = $words_cloud->buildCSS();
// CSS part only
$words_html = $words_cloud->buildHTML();
// html part only

// DISPLAY INPUTS SORTED BY TAG
if (isset($_GET['tag'])) {
	$tag=$_GET['tag'];
	$query = "SELECT * FROM thisisnot_inputs WHERE input LIKE '$tag %' OR input LIKE '% $tag %' OR input LIKE '% $tag' OR input LIKE '$tag' ORDER BY time DESC";
	$result = mysql_query($query, $db);
	$sentences= array();
	$html_sentences= array();
	while ($row = mysql_fetch_array($result)){
		$sentences[] = $row['input'];
	}
	foreach ($sentences as $sentence) {
		$sentence=trim($sentence);
		// echo $sentence . "<br>";
		$html_sentences[]= "<li>$sentence </li>";
	}
	$tagged_sentences = implode("", $html_sentences);
	mysql_close($db);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<meta name="author" content="Matteo Menapace">
<meta name="keywords" content="this, is, not, thisisnot, this is not, negative, negation system, negative tagging, tagging, negative tags, tags, Matteo, Menapace, Matteo Menapace, tag cloud, tag, cloud">
<meta name="description" content="thisisnot.org is a negative tagging system: simply look at the picture, decide what it is NOT, and write about it.">
<meta name="robots" content="all"><title>This is not...</title>	
<script type="text/javascript">
	function focusElement(id) {
		e=get_element_by_id(id)
		e.focus()
	}
	var menu= ["about", "theory", "disclaimer", "credits"];
	function changeDisplayState (id) {
		e=get_element_by_id(id)
		for(var i=0;i<menu.length;i++){
			var obj=menu[i]
			if (obj==id) {
				if (e.style.display == 'none' || e.style.display == "") e.style.display = 'block'
			} else {
				obj=get_element_by_id(obj)
				obj.style.display = 'none'
			}
		} 
	}
	function get_element_by_id(id) {
		var element
 		// if the method getElementById exists
		// this if will be different from false, null or undefined
		if(document.getElementById) {
			element = document.getElementById(id)
 		} else {
			element = document.all[id]
		}
		return element
	}
</script>
<style type="text/css" media="all">
	@import "styles/style01.css";
	<?php 
	echo $css;
	?>
</style>
</head>

<body onload="focusElement('inputbox')">

<div id="container">
	
	<div id="header">
	<a id="logo" href="index.php"><img src="images/this-is-not-03.gif" width="114" alt="logo" onmouseover="this.src='images/this-is-not-04.gif'" onmouseout="this.src='images/this-is-not-03.gif'" /></a>
	</div>
	
	<div id="form">
	<form method=post action=index.php>
	This is not&nbsp;&nbsp;
	<input id="inputbox" name="user_input" type="text" value="" autocomplete="off" maxlength="2048">&nbsp;&nbsp;
	<input name="submit" type="image" value="submit" src="images/submit.gif" onmouseover="this.src='images/submit-over.gif'" onmouseout="this.src='images/submit.gif'" alt="submit" align="top" >
	</form>
	</div>
	
	<?php
	if (isset($_POST['user_input']) && $_POST['user_input']!="") {
		print ("<div id='tagcloud'>" . $words_html . "</div>");
	}
	if (isset($_GET['tag']) && $_GET['tag']!="") {
		print ("<div id='tagcloud'>" . $words_html . "</div>");
		print ("<div id='sentences'><ul class='sentences'>" . $tagged_sentences . "</ul></div>");
	}
	?>

	<div id="menu">
	<table border=0 cellspacing=0 cellpadding=0 style="width:100%"><tr >
		<td class="button" align="center">
		<a href="javascript:changeDisplayState('about')" onMouseOver="window.status='';return true">&nbsp;About&nbsp;</a></td>
		<td class="button" align="center">
		<a href="javascript:changeDisplayState('theory')" onMouseOver="window.status='';return true">&nbsp;Theory&nbsp;</a></td>
		<td class="button" align="center">
		<a href="javascript:changeDisplayState('disclaimer')" onMouseOver="window.status='';return true">Disclaimer</a></td>
		<td class="button" align="center" style="border-right:1px solid #9c0;">
		<a href="javascript:changeDisplayState('credits')" onMouseOver="window.status='';return true">&nbsp;Credits</a></td>
	</tr></table>	
		<div class="explanation" id="about">
		<b>thisisnot.org is a negative tagging system</b>: simply look at the picture, decide what it is <b>NOT</b>, and write about it. <br>If the question “why?” is raised somewhere in your mind while using <b>thisisnot.org</b>, replace it quickly with “why not?”. 
		</div>   
		<div class="explanation" id="theory">
		This is a failed attempt to not represent anything, yet nevertheless to communicate something. <br>The original representation of this concept was a painting (René Magritte, 1928), witty and unique both in physical and semantic terms. It questioned the gap between representation and reality, and possibly it was also mocking Freud’s theory about the treachery of dreams. <br>As the years passed, new multiform icons have invaded our culture, new technologies have brought new media, so now what is <b>this</b>? Certainly it is not fixed: every time someone types something, its appearance changes (at first significantly, then slightly and then quite unnoticeably: that’s democracy, baby). Magritte had it easy when he claimed that it was not a pipe, but is it now “work”? Or a “text”? Or.. 
		</div> 
		<div class="explanation" id="disclaimer">
		<b>thisisnot.org is not moderated</b>: all negations posted on it are published but do not in any way represent the thoughts or beliefs of who created <b>thisisnot.org</b>. Therefore, the creator does not accept any responsibility for the content found on the website.
		</div> 
		<div class="explanation" id="credits">
		<b>thisisnot.org</b> was patiently drawn and copypasted by Matteo Menapace.<div id="email">&nbsp;</div>
		</div> 
	</div>
	
</div>

</body>
</html>

