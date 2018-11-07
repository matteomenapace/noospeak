<?php
/* 
* author: matteo
* created on May 15, 2007
*/

class Search_model extends Model
{
	var $words = array();
	var $wordsInfo = array();
	
	// words/elements to be eliminated from the final cloud
	var $crap = array('.', '?','<tr','/tr>','<td','/td>','<','>', "\"", '\"', '<br/>', ',', '!', '…', '(', ')', '“', '*', '‘', '-', '&', '&quot;', '/', '<b>', ':', ';', '/b>','border=','cellspacing=');
	var $redundant = array('I', 'you');
	
	function Search_model()
	{
		parent::Model();
	}
	
	
	function getSearchResults($keywords)
	{
		$keywords = $this->cleanKeywords($keywords);
		
		foreach ($keywords as $keyword)
		{
			$this->db->orlike('response', $keyword);
		}
		$query = $this->db->get('g_conversationlog');
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$tWords = strtolower($row->response);
				//$tWord = strip_tags($tWords);
				foreach ($this->crap as $crap) $tWords = trim(str_replace($crap, " ", $tWords));
				$tWords = explode(" ", $tWords);
				// populating words array, 2d array containing all words (1d) + their dates (2d)
				foreach ($tWords as $word)
				{
					if ($word!=="" && !in_array($word,$this->redundant))
					{
						// each word must be recorded in the array with its timestamp
						$timestamp=strtotime ($row->enteredtime) ;
						$this->words[$word][]=$timestamp;	
					}
				}
			}	
			// populating wordsInfo array, with the necessary data to build a tag
			foreach ($this->words as $key => $value) 
			{
				$tWord = $key;					
				$tLength = count($value);
				$sum = 0;
				foreach ($value as $date) $sum +=$date;
				$tAverageDate=round($sum/$tLength);
				$this->wordsInfo[] = array("word"=>$tWord, "count"=>$tLength, "date"=>$tAverageDate);
			}	
			// adding elements to the tagCloud object
			foreach ($this->wordsInfo as $value) 			
			{
				$url= "#";
				$this->tagcloud->addElement($value["word"], $url, $value["count"], $value["date"]);
			}
			return $this->tagcloud->buildAll();
		} else return '<p>Sorry, nothing found.</p>';
	}
	
	
	function cleanKeywords($array)
	{
		$cleanArray = array();
		foreach ($array as $element)
		{
			foreach ($this->crap as $crap) $element = trim(str_replace($crap, " ", $element));
			$cleanArray[] = $element;
		}
		return $cleanArray;
	}
		

}

?>
