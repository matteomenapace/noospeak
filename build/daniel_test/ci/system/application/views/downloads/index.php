<?php
$this->load->view("header");
?>
    <h2><?= $title;?></h2>
    <p>Thanks for your interest in the application. There are 2 main downloads for you.</p>
    <ul>
      <li><?= anchor (base_url().'video_files/ci_sample_app.avi' ,'The Video (AVI format)');?> (ci_sample_app.avi, 20.9MB)</li>
      <li><?= anchor (base_url().'video_files/ci_sample_app.mov' ,'The Video (MOV format)');?> (ci_sample_app.mov, 84.3MB)</li>
      <li><?= anchor (base_url().'video_files/ci_sample_app.wmv' ,'The Video (WMV format)');?> (ci_sample_app.wmv, 16.6MB)</li>
      <li><?= anchor (base_url().'video_files/ci_sample_app.zip' ,'The application files');?> (ci_sample_app.zip, 640KB)</li>
    </ul>
    <p>If you're looking for a copy of <a href="http://www.codeigniter.com/">Code Igniter</a>, check out their page. <a href="http://script.aculo.us/">Scriptaculous</a> and <a href="http://prototype.conio.net/">prototype</a> can also be downloaded from their respective sites.</p>

<?php
$this->load->view("footer");
?>