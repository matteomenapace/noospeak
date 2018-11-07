<?php 

function array_to_lowercase ($array){
	$lowerArray = array();
	$lowerValue = "";
	foreach($array as $value) {
		if (is_string($value)) {
			$lowerValue = strtolower($value);
			array_push($lowerArray, $lowerValue);
		}	
	}
	
	/*echo "<br>array_to_lowercase called <pre>";
	print_r($lowerArray);
	echo "</pre>";*/
	
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
	
		//$keyword = $keyword . " ";
		// add white space to avoid keywords within other words
		
		foreach ($sentences as $key=>$value) {
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
				// add 1 to include punctuation sign in the sentence
				$sentenceLength=$endingPos - $startingPos;
				$sentence = trim(substr($value, $startingPos, $sentenceLength));
				
				$semiRanked[$index]["sentence"] = $sentence;
				$semiRanked[$index]["keyword"] = $keyword;
				$semiRanked[$index]["pageRank"] = $key;
				$semiRanked[$index]["start"] = $startingPos;
				$semiRanked[$index]["length"] = $sentenceLength;
				
				$keywordPos += strlen($keyword);
				$index++;
			}
		}
	}
	
	/*echo "<br> semiRanked sentences<pre> ";
	print_r($semiRanked);
	echo "</pre>";*/
	
	
	return $semiRanked;
}

function get_ranked_sentences ($sentences) {
	$checkedElements = array();
	foreach ($sentences as $sentence) {
		$key = $sentence["sentence"];
		if (!in_array($key, $checkedElements)) {
			$checkedElements[] = $key;
			$rankedSentences[$key]["reference"] = $sentence;	
			$rankedSentences[$key]["keywordsRank"] = 1;
			$rankedSentences[$key]["pageRank"] = $sentence["pageRank"];
		} elseif (in_array($key, $checkedElements)) {
			$rankedSentences[$key]["keywordsRank"]++;
			$rankedSentences[$key]["pageRank"] += $sentence["pageRank"];
		} 
	}
	foreach ($rankedSentences as $key=>$value) {
		$value["pageRank"] = $value["pageRank"] / $value["keywordsRank"];
		// calculate average pageRank
		$rankedSentences[$key]["pageRank"]=$value["pageRank"];
		$rankedSentences[$key]["globalRank"]=$value["keywordsRank"]-$value["pageRank"];
		// globalRank considers how many keywords are present within a sentence (keywordsRank) and subtracts the pageRank value
		// therefore a sentence with same kR of another, but better (lower) pR will obtain a better (higher) gR
		
		/*
		echo ("<br>key >>".$key);
		echo ("<br>value >> ".$value);
		echo ("<br>value[pageRank] >> ".$value["pageRank"]);
		*/
	}
	
	usort ($rankedSentences, "compareRank");
	
	/*echo "<br>ranked sentences<pre>";
	print_r($rankedSentences);
	echo "</pre>";*/
	
	
	
	return $rankedSentences;
}

function compareRank ($a, $b) {
	if ( $a["globalRank"] == $b["globalRank"] ) return 0;
	else if ( $a["globalRank"] > $b["globalRank"] ) return -1;
	else return 1;
}

function get_sentence ($rankedArray, $rawArray) {
	$sentenceReference = $rankedArray [0]["reference"];
	
	/*echo "<br>winner sentence reference<pre>";
	print_r($sentenceReference);
	echo "</pre>";*/

	$index = $sentenceReference["pageRank"];
	$start = $sentenceReference["start"];
	$length = $sentenceReference["length"];
	
	$sentence = trim (substr ($rawArray[$index], $start, $length));
	//echo ("<br> the winner is: <b>" . $sentence . "</b>");
	
	return $sentence;
	
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*

$testSentences = array("Frase 1. Frase 2. frase 3.","Frase 1. frase 2.","frase 1. frase 3.");
$testKeywords = array("1", "frase");

$testSentences = array("I love you.", "all I know is CRAP.","I need some love.", "I need YOU, my love...", "all I need is you, my LOVE.");
$testKeywords = array("all", "you", "need", "is", "love");

$testSentences = array("has anyone seen mke hunt?", "anything is another thing","any opinion today is ok", "another of these days", "days and days");
$testKeywords = array("any", "day", "is", "other");


$startingPunctuation = array('.', '!', '(', '?', '[', '{', '–', '<', '·', ';', '\"');
$endingPunctuation = array('.', '!', ')', '?', ']', '}', '–', '>', '·', ';');
$punctuations = array("start"=>$startingPunctuation, "end"=>$endingPunctuation);

$semiRankedSentences = get_semi_ranked_sentences ($testSentences, $testKeywords, $punctuations);
$rankedSentences = get_ranked_sentences ($semiRankedSentences);
$sentence = get_sentence ($rankedSentences, $testSentences); 


*/


?>
