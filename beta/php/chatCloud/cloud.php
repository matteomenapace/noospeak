<?php 
require_once "TagCloud4.class.php";
require_once "commonWords.php";


function cloud($type, $input){
$crap = array('.', '?', "\"", '\"', '<br/>', ',', '!', '…', '(', ')', '“', '*', '‘', '-', '&', '&quot;', '/', '<b>', ':', ';', '/b>',"'","#","acirc;");
global $common;

if ($type=='google') $id='response';
else $id='input';

$words_array = array();
$tags_array = array();
$tags_weight = array();

$input = strtolower($input);
$input = stripslashes($input);
$input_words = explode(" ", $input);

foreach($input_words as $wrd)
{
				foreach ($crap as $value)
				{
					if(($str_index = strpos($wrd,$value))!==FALSE)
						$wrd = substr($wrd,0,$str_index);
				}

	if(!in_array($wrd,$common) & !in_array($wrd,$words_array))	
	$words_array[] = $wrd;
}

$query = "SELECT * FROM g_conversationlog";

if(!empty($words_array))
{
	$query .= " WHERE";
	
	foreach($words_array as $wrd)
	{
		$query .= " $id LIKE '%$wrd%' OR";
	}
}

$query .= " 1=0 ORDER BY `enteredtime` DESC LIMIT 0,30";

$result = mysql_query($query);

while ($row = mysql_fetch_array($result)){
	$response = strtolower($row[$id]);
	foreach ($crap as $value) $response = trim(str_replace($value, " ", $response));
	$result_words = explode(" ", $response);
	foreach($result_words as $wrd)
	{
				foreach ($crap as $value)
				{
					if(($str_index = strpos($wrd,$value))!==FALSE)
						$wrd = substr($wrd,0,$str_index);
				}

	if(!in_array($wrd,$common) & !in_array($wrd,$tags_array))
	$tags_array[] = $wrd;
	}
}


if(!empty($tags_array))
{	
	foreach($tags_array as $tag) //Go through all Tags
	{
		$weight = 0;
		$query = "SELECT * FROM g_conversationlog WHERE $id LIKE '%$tag%' ORDER BY `enteredtime` DESC LIMIT 0,30";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		while ($row = mysql_fetch_array($result)) //Go through all resources described by tag
		{
			$d=0;
			$response = strtolower($row[$id]);
			$result_words = explode(" ", $response);
			foreach($result_words as $wrd)
			{
				foreach ($crap as $value)
				{
					if(($str_index = strpos($wrd,$value))!==FALSE)
						$wrd = substr($wrd,0,$str_index);
				}

				if(!in_array($wrd,$common))
				{
				if(!in_array($wrd,$tags_weight))
				$all_tags[] = $wrd;
				if($wrd == $tag)
				$d++;
				}
			
			}
			$tag_weight[$tag]['time'] = strtotime($row[enteredtime]);
			$weight += ceil(($d/count($all_tags))*100);
			
		}
		$tag_weight[$tag]['weight'] = $weight;
		$tag_weight[$tag]['tag'] = $tag;
	}
}

$words_cloud = new HTML_TagCloud(36,24);

if(!empty($tag_weight))
{
foreach ($tag_weight as $tag) {
	$url= "#";
	$words_cloud->addElement($tag["tag"], $url, $tag["weight"], $tag["time"]);
}


return $words_cloud->buildALL();
}

else
return '';


}

?>