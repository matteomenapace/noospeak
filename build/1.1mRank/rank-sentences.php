<?php 

function array_to_lowercase ($array){
	/*
	echo "<br>array_to_lowercase called <pre>";
	print_r($array);
	echo "</pre>";
	*/
	$lowerArray = array();
	$lowerValue = "";
	foreach($array as $value) {
		if (is_string($value)) {
			$lowerValue = strtolower($value);
			array_push($lowerArray, $lowerValue);
		}	
	}
	return $lowerArray;
}

function get_prev_interruption ($needles, $haystack) {
	$prev=0;
	foreach ($needles as $needle) {
		if (strrpos($haystack, $needle)!==false) {
			$pos = strrpos($haystack, $needle);
			if ($pos > $prev) $prev = $pos;
		}
	}
	// the actual punctuation sign at the beginning (if any) needs to be cut out, otherwise the sentence would start with such punctuation sign
	if ($prev!==0) $prev++;
	return $prev;
}

function get_next_interruption ($needles, $haystack) {
	$next = 100000;
	foreach ($needles as $needle) {
		if (strpos($haystack, $needle)!==false) {
			$pos = strpos($haystack, $needle);
			if ($pos<$next) $next = $pos;
		}
	}
	return $next;
}


function get_semi_ranked_sentences ($sentences, $keywords, $punctuation) {
	$semiRanked= array();
	$index=0;
	$sentences = array_to_lowercase($sentences);
	$keywords = array_to_lowercase($keywords);
	foreach ($keywords as $keyword) {
		$keyword = $keyword . " ";
		foreach ($sentences as $key=>$value) {
			//echo ("<br><br>" . $value);
			//echo ("<br>" . $keyword);
			$cropString = $value;
			$keywordPos = 0;
			while (strpos($cropString, $keyword)!==false) {
				$keywordRelativePos = strpos($cropString, $keyword);
				$keywordPos += $keywordRelativePos;
				$prevString = trim(substr($value, 0, $keywordPos));
				$nextString = trim(substr($value, $keywordPos));
				$cropString = trim(substr($cropString, $keywordRelativePos+strlen($keyword)));

				$startingPos = get_prev_interruption($punctuation["start"], $prevString);
				$endingPos = get_next_interruption($punctuation["end"], $nextString) + $keywordPos + 1;
				$sentenceLength=$endingPos - $startingPos;
				$sentence = trim(substr($value, $startingPos, $sentenceLength));
				
				$semiRanked[$index]["sentence"] = $sentence;
				$semiRanked[$index]["start"] = $startingPos;
				$semiRanked[$index]["length"] = $sentenceLength;
				$semiRanked[$index]["pageRank"] = $key;/**/
				
				$keywordPos += strlen($keyword);
				$index++;
			}
		}
	}
	/*
	echo "<pre>";
	print_r($semiRanked);
	echo "</pre>";
	*/
	
	return $semiRanked;
}

function get_ranked_sentences ($sentences) {
	foreach ($sentences as $sentence) {
		$key = $sentence["sentence"];
		if (!isset($checkedElements) || !in_array($key, $checkedElements)) {
			$checkedElements[] = $key;
			$rankedSentences[$key]["keywordsRank"] = 1;
			$rankedSentences[$key]["pageRank"] = $sentence["pageRank"];
			$rankedSentences[$key]["referenceArray"] = $sentence;	
		} elseif (in_array($key, $checkedElements)) {
			$rankedSentences[$key]["keywordsRank"]++;
			$rankedSentences[$key]["pageRank"] += $sentence["pageRank"];
		} 
	}
	foreach ($rankedSentences as $key=>$value) {
		$value["pageRank"] = $value["pageRank"] / $value["keywordsRank"];
		// calculate average pageRank
		$rankedSentences[$key]["pageRank"]=$value["pageRank"];
		/*
		echo ("<br>key >>".$key);
		echo ("<br>value >> ".$value);
		echo ("<br>".$value["pageRank"]);
		*/
	}
	
	usort ($rankedSentences, "compareRank");
	/*
	echo "<pre>";
	print_r($rankedSentences);
	echo "</pre>";
	*/
	
	
	return $rankedSentences;
}

function compareRank ($a, $b) {
	if ( $a["pageRank"] == $b["pageRank"] ) return 0;
	else if ( $a["pageRank"] < $b["pageRank"] ) return -1;
	else return 1;
}

function get_sentence ($rankedArray, $rawArray) {
	$sentenceReference = $rankedArray [0]["referenceArray"];
	/*
	echo "<pre>";
	print_r($sentenceReference);
	echo "</pre>";
	*/
	$index = $sentenceReference["pageRank"];
	$start = $sentenceReference["start"];
	$length = $sentenceReference["length"];
	
	$sentence = trim (substr ($rawArray[$index], $start, $length));
	//echo ("<br> the winner is: <b>" . $sentence . "</b>");
	
	return $sentence;
	/**/
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*

$testSentences = array("Frase 1. Frase 2. frase 3.","Frase 1. frase 2.","frase 1. frase 3.");
$testKeywords = array("1", "frase");
$startingPunctuation = array('.', '!', '(', '?', '[', '{', '–', '<', '·', ';', '\"');
$endingPunctuation = array('.', '!', ')', '?', ']', '}', '–', '>', '·', ';');
$punctuations = array("start"=>$startingPunctuation, "end"=>$endingPunctuation);

$semiRankedSentences = get_semi_ranked_sentences ($testSentences, $testKeywords, $punctuations);
$rankedSentences = get_ranked_sentences ($semiRankedSentences);
$sentence = get_sentence ($rankedSentences, $testSentences); 

*/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*
echo "<pre>";
print_r($myArray);
echo "</pre>";
*/


?>
