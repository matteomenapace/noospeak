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


?>
