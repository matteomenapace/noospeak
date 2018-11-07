<?php
$this->load->view("header");
?>
    <h2><?= $title;?></h2>
	<p>Please be patient, the file is 46MB.  If you'd prefer, you can download the video in AVI format (<?= anchor (base_url().'video_files/ci_sample_app.avi' ,'ci_sample_app.avi, 20.9MB');?>), MOV format (<?= anchor (base_url().'video_files/ci_sample_app.mov' ,'ci_sample_app.mov, 83.4MB');?>) or in WMV format (<?= anchor (base_url().'video_files/ci_sample_app.wmv' ,'ci_sample_app.wmv, 16.6MB');?>).</p>      <div id="flashcontent">	   		
			<div id="noexpressUpdate">
			  <p>The Camtasia Studio video content presented here requires JavaScript to be enabled and the  latest version of the Macromedia Flash Player. If you are you using a browser with JavaScript disabled please enable it now. Otherwise, please update your version of the free Flash Player by <a href="http://www.macromedia.com/go/getflashplayer">downloading here</a>. </p>
		    </div>
	   </div>
      <script type="text/javascript">
		  // <![CDATA[
         var fo = new FlashObject( "<?= base_url();?>video_files/ci_sample_app_controller.swf", "<?= base_url();?>video_files/ci_sample_app_controller.swf", "800", "655", "8", "#FFFFFF", false, "best" );
         fo.addVariable( "csConfigFile", "<?= base_url();?>video_files/ci_sample_app_config.xml"  ); 
         fo.addVariable( "csColor"     , "FFFFFF"           );
         fo.addVariable( "csPreloader" , '<?= base_url();?>video_files/ci_sample_app_preload.swf' );
         if( args.movie )
         {
            fo.addVariable( "csFilesetBookmark", args.movie );
         }
         fo.write("flashcontent"); 		  	  
         // ]]>
	   </script> 
	   
<?php
$this->load->view("footer");
?>