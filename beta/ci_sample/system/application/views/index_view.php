<?php
/* 
* author: matteo
* created on May 15, 2007
*/
?>

<html>
	<head>		
		<title><?= $title ?></title>
	</head>

	<body>  		
  		<form id="function_search_form" method="post" action="<?php echo site_url('searchcloud/search');?>">
		<div>
        	<input type="text" name="input_keywords" id="input_keywords" />
			<input type="submit" value="search" id="search_button" />
			<div id="autocomplete_choices" class="autocomplete"></div>
		</div>
    	</form>
    	<div id="results" style="display:none;">
			<p>results</p>
		</div> 
	</body>
</html>