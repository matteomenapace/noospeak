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
 		<p><?= $content ?></p>
 		
  		<ul>
  			<?php foreach($array as $element):?>
    			<li><?= $element ?></li>
    		<?php endforeach; ?>	
  		</ul>
  
 		
  		<a href="http://www.google.com">google</a> 
	</body>
</html>


