<?php
$this->load->view("header");
?>
    <h2><?php echo $title;?></h2>
    <form id="function_search_form" method="post" action="<?php echo site_url('application/search');?>">
	<div>
        <label for="function_name">Search by function name </label>
        <input type="text" name="function_name" id="function_name" />
		<input type="submit" value="search" id="search_button" />
		<div id="autocomplete_choices" class="autocomplete"></div>
	</div>
    </form>
    <div id="function_description" style="display:none;">
	<p>Enter your function above</p>
	</div>
    

<?php
$this->load->view("footer");
?>