<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Page Field Type
 *
 * @package		PyroStreams
 * @author		Parse19
 * @copyright	Copyright (c) 2011, Parse19
 * @license		http://parse19.com/pyrostreams/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_page
{
	public $field_type_name 		= 'Page';
	
	public $field_type_slug			= 'page';
	
	public $db_col_type				= 'int';
	
	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output( $data )
	{
		$this->CI = get_instance();
	
		// Build a drop down of pages
		$this->CI->load->model('pages/pages_m');
		
		$tree = $this->CI->pages_m->get_page_tree();
		
		print_r($tree);
	}
	
}

/* End of file field.text.php */