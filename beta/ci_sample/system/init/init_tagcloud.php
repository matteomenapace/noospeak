<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Loads and instantiates tagcloud class
 * @access	private called by the app controller
 */	

require_once(BASEPATH.'application/libraries/TagCloud'.EXT);

$obj =& get_instance();
$obj->tagcloud = new TagCloud();
$obj->ci_is_loaded[] = 'tagcloud';

?>
