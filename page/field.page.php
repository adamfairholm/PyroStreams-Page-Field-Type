<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Page Field Type
 *
 * @package		PyroStreams
 * @author		Parse19
 * @copyright	Copyright (c) 2011, Parse19
 */
class Field_page
{
	public $field_type_name 		= 'Page';
	
	public $field_type_slug			= 'page';
	
	public $db_col_type				= 'int';
	
	// --------------------------------------------------------------------------

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
		
		$dropdown = array();
		
		foreach($tree as $tree_item):
		
			$dropdown[$tree_item['id']] = $tree_item['title'];
		
		endforeach;
		
		return form_dropdown($data['form_slug'], $dropdown, $data['value']);
	}

	// --------------------------------------------------------------------------
	
	function pre_output($input, $params)
	{
		if(!$input or !is_numeric($input)) return;
	
		// Get the page
		$this->CI = get_instance();
		$obj = $this->CI->db->select('title')->limit(1)->where('id', $input)->get('pages');

		if($obj->num_rows() == 0) return;
		
		$row = $obj->row();
		
		return $row->title;
	}

	// --------------------------------------------------------------------------

	function pre_output_plugin($prefix, $input, $params)
	{
		if(!$input or !is_numeric($input)) return;
	
		// Get the page
		$this->CI = get_instance();
		$obj = $this->CI->db->select('uri, slug, title, id, status')->limit(1)->where('id', $input)->get('pages');

		if($obj->num_rows() == 0) return;
		
		$row = $obj->row();
		
		$this->CI->load->helper('url');
		
		$page_data[rtrim($prefix, '.')] = site_url($row->uri);
		$page_data[$prefix.'slug']		= $row->slug;
		$page_data[$prefix.'title']		= $row->title;
		$page_data[$prefix.'id']		= $row->id;
		$page_data[$prefix.'status']	= $row->status;
		
		return $page_data;
	}
	
}

/* End of file field.page.php */