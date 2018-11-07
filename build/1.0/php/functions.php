<?php 

function extract_string ($string, $from_str, $to_str, $clean_str){
	while (strpos($string, $from_str)!==false){
	// while an occurrence of $from_str is found within $string
		$from=strpos($string, $from_str) + strlen($from_str);
		// gets the position of the first $from_str occurrence
		$string= trim(substr($string, $from));
		// cuts whatever comes before $from, so next lines will look for the right $to_str
		$to=strpos($string, $to_str);
		$clean_str .= substr($string, 0, $to);
		$string= trim(substr($string, $to));
	}
	return $clean_str;
}

function eliminate_useless ($string, $from_str, $to_str){
	while (strpos($string, $from_str)!==false){
	// while an occurrence of $from_str is found within $string
		$from=strpos($string, $from_str);
		// gets the position of the first $from_str occurrence
		$crop_string= trim(substr($string, $from_str));
		// cuts whatever comes before $from_str, so next lines will look for the right $to_str
		$to=strpos($crop_string, $to_str) + strlen($to_str);
		$dirty_string = substr($string, $from, $to);
		$string=str_replace($dirty_string,' ',$string);
	}
	return $string;
}

function extract_sentence ($string, $sw, $in_array, $out_array) {
	while (strpos($string, $sw)!==false){
		$swp=strpos($string, $sw);
		// gets the position of the last search_words
		$string=trim(substr($string, $swp));
		$ns=strpos($string," ");
		// gets next space " " position 
		if ($ns>0) {
		// if there is actually a next space (otherwise search_word is the last html word..)
 			$string= trim(substr($string, $ns));
			// crops the string, returning the part from next space to the end (gets rid of $search word and eventual other characters attached to it
			// example: if looking for "form", "formation" will be stripped in order to avoid "ation" to be counted as a separate word
			$crop_here=10000;
			foreach ($in_array as $value) {
				if (strpos($string, $value)!==false) {
					$pos=strpos($string, $value);
					if ($pos<$crop_here) {
						$crop_here=$pos;
					}
				}
			}
			$sentence=trim(substr($string,0,$crop_here));
			if ($sentence!="") {
				//echo "<br>" . $sentence;
				array_push($out_array, $sentence);
			}
			$string=trim(substr($string,$crop_here+1));
		}
	}
	return $out_array;
}

function string_escape($s) {
	if (!get_magic_quotes_gpc()) $s=addslashes($s);
	return $s;
}

function unhtmlentities($string) {
   $trans_tb = get_html_translation_table(HTML_SPECIALCHARS);
   $trans_tb["'"] = "&#39;";
   $trans_tb = array_flip($trans_tb);
   /*
   echo "<pre>";
   print_r($trans_tb);
   echo "</pre>";
   */
   return strtr($string, $trans_tb);
}

function check_numbers($string) {
	$pattern="[0-9]";
	$check_reg_exp=ereg($pattern,$string);
	if ($check_reg_exp) return true;
	else return false;
}

?>
