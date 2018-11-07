<?php

class Video extends Controller {

	function Video()
	{
		parent::Controller();
		$this->output->cache(120);
	}
	
	function index()
	{
		$data['title'] = "Code Igniter Sample Application Video";
		$data['extraHeadContent'] = '<script type="text/javascript" src="' . base_url() . '/js/flashobject.js"></script>    
   <script type="text/javascript">
      <!-- To load a movie other then the first one listed in the xml file you can specify a movie=# arguement. -->
      <!-- For example, to load the third movie you would do the following: MyProjectName.html?movie=3 -->      
      // <![CDATA[
      var args = new Object();
      var query = location.search.substring(1);
      // Get query string
      var pairs = query.split( "," );
      // Break at comma
      for ( var i = 0; i < pairs.length; i++ )
      {
         var pos = pairs[i].indexOf(\'=\');
         if( pos == -1 )
         {
            continue; // Look for "name=value"
         }
         var argname = pairs[i].substring( 0, pos ); // If not found, skip
         var value = pairs[i].substring( pos + 1 ); // Extract the name
         args[argname] = unescape( value ); // Extract the value
      }
      // ]]>
   </script>';
		$this->load->view('video/index', $data);
	}
}
?>