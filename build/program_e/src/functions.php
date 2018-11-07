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

function extract_first_sentence ($string, $kw_array, $starting_punctuation, $ending_punctuation, $botresponse){
	$finished=false;
	$counter=0;
	while ($finished===false){
		$kw=$kw_array[$counter] . " ";
		if (strpos($string, $kw)!==false) {
			//echo ("<br>keyword: ---" . $kw . "---");
			$kw_pos=strpos($string, $kw);
			//echo ("<br>keyword position: " . $kw_pos);
			// get previous interruption
			$prev_string = trim(substr($string, 0, $kw_pos));
			//echo ("<br>previous string: ---" . $prev_string . "---");
			$starting_pos=0;
			foreach ($starting_punctuation as $value) {
				if (strrpos($prev_string, $value)!==false) {
					$pos=strrpos($prev_string, $value);
					if ($pos>$starting_pos) {
						$starting_pos=$pos;
					}
				}
			}
			// the actual punctuation sign at the beginning (if any) needs to be cut out, otherwise it would be the first occurence of $sentence
			if ($starting_pos!==0) {
				$starting_pos++;
				//echo ("<br>prev_interruption_pos aumentato di un'unità");
			}	
			//echo ("<br>previous interruption position: " . $starting_pos);
			// get next interruption
			$next_string = trim(substr($string, $kw_pos));
			$ending_pos=10000;
			foreach ($ending_punctuation as $value) {
				if (strpos($next_string, $value)!==false) {
					$pos=strpos($next_string, $value);
					//echo ("<br>symbol >>> " . $value . " <<< found at " . $pos);
					if ($pos<$ending_pos) {
						$ending_pos=$pos;
					}
				}
			}
			$ending_pos = $ending_pos + $kw_pos + 1;
			$sentence_length = $ending_pos - $starting_pos;
			//echo ("<br>next interruption position: " . $ending_pos);
			$sentence = trim(substr($string, $starting_pos, $sentence_length));
			//echo ("<br>sentence: ---" . $sentence . "---");
			
			$finished=true;
			//echo ("<br>finished: " . $finished);
		} else {
			$counter++;
			//echo ("<br>counter: " . $counter);
			if ($counter >= count($kw_array)) {
				$sentence= $botresponse;
				$finished=true;
			}	
		}	
	}
	return $sentence;		
}

function string_escape($s) {
	if (!get_magic_quotes_gpc()) $s=addslashes($s);
	return $s;
}

function unhtmlentities($string) {
   $trans_tb = get_html_translation_table(HTML_SPECIALCHARS);
   $trans_tb["'"] = "&#39;";
   $trans_tb["·"] = "&middot;";
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
