<?php 

function extract_array ($string, $fromString, $toString, $array){
	/*
	echo ("<br><br>extract_string called");
	echo ("<br> string: " . $string);
	echo ("<br> fromString: " . $fromString);
	echo ("<br> toString: " . $toString);
	*/
	while (strpos($string, $fromString)!==false){
	// while an occurrence of $fromString is found within $string		
		$from=strpos($string, $fromString) + strlen($fromString);
		// gets the position of the first $fromString occurrence
		$string= trim(substr($string, $from));
		// cuts whatever comes before $from, so next lines will look for the right $toString
		$to=strpos($string, $toString);
		$array[] = substr($string, 0, $to);
		$string= trim(substr($string, $to));
	}
	//print_r($array);
	return $array;
}

function eliminate_useless ($string, $from_str, $to_str){
	while (strpos($string, $from_str)!==false){
	// while an occurrence of $from_str is found within $string
		$from=strpos($string, $from_str);
		// get the position of the first $from_str occurrence
		$crop_string= trim(substr($string, $from_str));
		// cut whatever comes before $from_str, so next lines will look for the right $to_str
		$to=strpos($crop_string, $to_str) + strlen($to_str);
		$dirty_string = substr($string, $from, $to);
		$string=str_replace($dirty_string,' ',$string);
	}
	return $string;
}

function string_escape($s) {
	if (!get_magic_quotes_gpc()) $s=addslashes($s);
	return $s;
}

function unhtmlentities($string) {
	//echo ("<br>unhtmlentities called");
	$translationTable = get_html_translation_table(HTML_SPECIALCHARS);
	$translationTable["'"] = "&#39;";
	$translationTable["·"] = "&middot;";
	$translationTable = array_flip($translationTable);
	$cleanString=strtr($string, $translationTable);
	return $cleanString;
}

function strip_html_tags($string) {
	$search = "@<[\/\!]*?[^<>]*?>@si";
	if (is_string($string)){
		$cleanString = preg_replace($search, "", $string);
		return $cleanString;
	}	
}

function eliminate_string ($haystack, $needle) {
	$cropHaystack=$haystack;
	$cleanString="";
	while (strpos($cropHaystack, $needle)!==false) {
		$pos = strpos($cropHaystack, $needle);
		$length= strlen($needle);
		$cleanString .= trim(substr($cropHaystack, 0, $pos)) . " ";
		$cropHaystack = trim(substr($cropHaystack, $pos+$length));
		//echo ("<br>cleanString  ---" . $cleanString . "---");
		//echo ("<br>cropHaystack ---" . $cropHaystack . "---<br>");
	}
	$cleanString .= $cropHaystack;
	//echo ("<br>cleanString  ---<b>" . $cleanString . "</b>---"); 
	return $cleanString;
}

function getNextWordsArray($needle, $haystack) {

	//echo ("<br>needle: " . $needle);
	//echo ("<br>haystack: " . $haystack);

	$words = array();
	$haystack=strtolower($haystack);
	while (strpos($haystack, $needle) !== false){
 		$pos = strpos($haystack, $needle);
 		$crop_here = $pos+strlen($needle);
 		$haystack = trim(substr($haystack, $crop_here));
		$string_length = strlen($haystack);
		$next_space_pos = strpos($haystack," ");
		
		$end_crop = $next_space_pos - $string_length;
		// calculates the number of letters from there to the end of the string
		
		//$word = substr($haystack,0,$end_crop);
		$word = substr($haystack,0,$next_space_pos);
		// extracts from the string a sub-string starting from 0 and ending at $end-crop (first space found)
		//
		$word=trim(strip_tags($word));
		//
		if ($word!==""){
			$words[]=$word;
			//echo($word . "<br>");
		}	
	}
	return $words;
}

function get_search_string($db_table, $session) {
	$query="SELECT (search_string) FROM " . $db_table . " WHERE session_id='$session' ORDER BY id DESC LIMIT 1";
	$data = mysql_query($query);
	if ($data) {
		while ($result = mysql_fetch_array($data)) return $result[0];
	}
}

function log_search_string($db_table, $session, $string){
	$query = "INSERT INTO " . $db_table . " ( session_id , search_string , timestamp ) VALUES ('$session', '$string', NOW())";
	$success = mysql_query($query);
	return $success;
}

function log_sentence($db_table, $session, $string, $sentence){
	$query = "INSERT INTO " . $db_table . " ( session_id , search_string , sentence , timestamp ) VALUES ('$session', '$string', '$sentence', NOW())";
	$success = mysql_query($query);
	return $success;
}

function get_sentence($db_table, $session) {
	$query="SELECT (sentence) FROM " . $db_table . " WHERE session_id='$session' ORDER BY id DESC LIMIT 1";
	$data = mysql_query($query);
	if ($data) {
		while ($result = mysql_fetch_array($data)) return $result[0];
	}
}


?>
