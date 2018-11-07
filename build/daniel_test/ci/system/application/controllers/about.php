<?php

class About extends Controller {

	function About()
	{
		parent::Controller();
		$this->output->cache(120);
	}
	
	function index()
	{
		$data['title'] = "About the Code Igniter Sample Application";
		$this->load->view('about/index', $data);
	}
}
?>