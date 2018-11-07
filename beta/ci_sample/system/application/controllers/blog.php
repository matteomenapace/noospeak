<?php
/* 
* author: matteo
* created on May 15, 2007
*/

class Blog extends Controller
{
	
	function Blog()
	{
		parent::Controller();
	}
	
	function index()
	{
		$data['title']="some title";
		$data['content']="this will be dynamic";
		$data['array']=array('uno','due', 'tre');
		$this->load->view('blog/blog_view',$data);
	}
	
	
}

?>
