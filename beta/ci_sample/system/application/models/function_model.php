<?php
class Function_model extends Model {

	function Function_model()
	{
		parent::Model();
	}
	
	function getSearchResults ($function_name, $description = TRUE)
	{
		$this->db->like('function_name', $function_name);
		$this->db->orderby('function_name');
		$query = $this->db->get('functions');
		
		if ($query->num_rows() > 0)
		{
			$output = '<ul>';
			foreach ($query->result() as $function)
			{
				if ($description)
				{
					$output .= '<li><strong>' . $function->function_name . '</strong><br>';
					$output .= $function->function_description . '</li>';
				} else $output .= '<li>' . $function->function_name . '</li>';
			}
			$output .='</ul>';
			return $output;
		} else return '<p>Sorry, no results returned.</p>';
	}

}
?>