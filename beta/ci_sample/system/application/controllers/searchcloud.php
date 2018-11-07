<?php
/* 
* author: matteo
* created on May 15, 2007
*/

class SearchCloud extends Controller
{
	
	function SearchCloud()
	{
		parent::Controller();
		$this->load->model('search_model');
		//$this->load->library('benchmark');
		$this->load->library('TagCloud');
		//$this->load->library('someclass');
	}
	
	function index()
	{
		$data['title']="some title";
//		$data['content']="this will be dynamic";
//		$data['array']=array('uno','due', 'tre');
		$this->load->view('searchcloud/index_view',$data);
	}
	
	function search()
	{
		$data['title']="search results";
		$keywords = $this->input->post('input_keywords');
		$keywords = explode(' ',$keywords);
		$data['search_results'] = $this->search_model->getSearchResults($keywords);
		$this->load->view('searchcloud/search_view',$data);
	}
	
	
}

?>
