<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Page Field Type
 *
 * Choose a page and return page data
 *
 * @package		PyroStreams
 * @author		Parse19
 * @copyright	Copyright (c) 2011, Parse19
 */
class Field_page
{

	// --------------------------------------------------------------------------
	 
	public $field_type_slug			= 'page';
	
	public $db_col_type				= 'int';

	public $version					= '1.1.1';

	public $author					= array('name' => 'Parse19', 'url' => 'http://parse19.com');
	
	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @access	public
	 * @param	array
	 * @param	array
	 * @param	obj
	 * @return	string
	 */
	public function form_output($data, $params, $field)
	{
		$html = '<select name="'.$data['form_slug'].'" id="'.$data['form_slug'].'">';
		
		if($field->is_required == 'no'):
		
			$html .= '<option value="">'.get_instance()->config->item('dropdown_choose_null').'</option>';
		
		endif;
		
		return $html .= $this->_build_tree_select(array('current_parent' => $data['value'])).'</select>';
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Output for Admin
	 *
	 * @param	string
	 * @param	array
	 * @return	string
	 */
	function pre_output($input, $params)
	{
		if(!$input or !is_numeric($input)) return;
	
		// Get the page
		$this->CI = get_instance();
		$obj = $this->CI->db->select('id, title')->limit(1)->where('id', $input)->get('pages');

		if($obj->num_rows() == 0) return;
		
		$row = $obj->row();
		
		return '<a href="'.site_url('admin/pages/edit/'.$row->id).'">'.$row->title.'</a>';
	}

	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	string
	 * @param	array
	 * @return	array
	 */
	function pre_output_plugin($input, $params)
	{
		if(!$input or !is_numeric($input)) return;
	
		// Get the page
		$this->CI = get_instance();
		$obj = $this->CI->db->select('uri, slug, title, id, status')->limit(1)->where('id', $input)->get('pages');

		if($obj->num_rows() == 0) return;
		
		$row = $obj->row();
		
		$this->CI->load->helper('url');
		
		// Is this the current one?
		$current = ( $row->uri == $this->CI->uri->uri_string() ) ? true : false;
				
		return array(
			'link'		=> site_url($row->uri),
			'slug'		=> $row->slug,
			'title'		=> $row->id,
			'id'		=> $row->id,
			'status'	=> $row->status,
			'current'	=> $current
		);		
	}

	// --------------------------------------------------------------------------

	/**
	 * Tree select function
	 *
	 * Creates a tree to form select.
	 *
	 * This originally appears in the PyroCMS navigation
	 * admin controller, but we need it here so here it is.
	 *
	 * @param	array
	 * @return	array
	 */
	function _build_tree_select($params)
	{
		$params = array_merge(array(
			'tree'			=> array(),
			'parent_id'		=> 0,
			'current_parent'=> 0,
			'current_id'	=> 0,
			'level'			=> 0
		), $params);

		extract($params);

		if ( ! $tree)
		{
			if ($pages = $this->CI->db->select('id, parent_id, title')->get('pages')->result())
			{
				foreach($pages as $page)
				{
					$tree[$page->parent_id][] = $page;
				}
			}
		}

		if ( ! isset($tree[$parent_id]))
		{
			return;
		}

		$html = '';

		foreach ($tree[$parent_id] as $item)
		{
			if ($current_id == $item->id)
			{
				continue;
			}

			$html .= '<option value="' . $item->id . '"';
			$html .= $current_parent == $item->id ? ' selected="selected">': '>';

			if ($level > 0)
			{
				for ($i = 0; $i < ($level*2); $i++)
				{
					$html .= '&nbsp;';
				}

				$html .= '-&nbsp;';
			}

			$html .= $item->title . '</option>';

			$html .= $this->_build_tree_select(array(
				'tree'			=> $tree,
				'parent_id'		=> (int) $item->id,
				'current_parent'=> $current_parent,
				'current_id'	=> $current_id,
				'level'			=> $level + 1
			));
		}

		return $html;
	}
	
}

/* End of file field.page.php */