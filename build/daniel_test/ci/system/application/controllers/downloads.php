<?php

class Downloads extends Controller {

	function Downloads()
	{
		parent::Controller();
		$this->output->cache(120);
	}
	
	function index()
	{
		$data['title'] = "Code Igniter Sample Application Downloads";
		$this->load->view('downloads/index', $data);
	}
}
?>