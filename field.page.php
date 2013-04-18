<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Page Field Type
 *
 * Choose a page from a drop down and return the page data.
 *
 * @author		Adam Fairholm
 * @copyright	Copyright (c) 2011 - 2012, Adam Fairholm
 * @link 		https://github.com/adamfairholm/PyroStreams-Page-Field-Type
 */
class Field_page
{
	
	public $field_type_name			= 'Page';
	
	public $field_type_slug			= 'page';
	
	public $db_col_type				= 'int';

	public $version					= '2.0.0';

	public $author					= array(
										'name' => 'Adam Fairholm',
										'url' => 'http://www.adamfairholm.com');
	
	/**
	 * Output form input
	 *
	 * @param	$data array
	 * @param	$params array
	 * @param	$field obj
	 * @return	string The form input
	 */
	public function form_output($data, $params, $field)
	{
		$html = '<select name="'.$data['form_slug'].'" id="'.$data['form_slug'].'">';
		
		if ($field->is_required == 'no') {
			$html .= '<option value="">'.get_instance()->config->item('dropdown_choose_null').'</option>';
		}
		
		return $html .= $this->_build_tree_select(array('current_parent' => $data['value'])).'</select>';
	}
	
	/**
	 * Output for Admin
	 *
	 * @param	$input string
	 * @param	$params array
	 * @return	string
	 */
	public function pre_output($input, $params)
	{
		if ( ! $input or ! is_numeric($input)) {
			return null;
		}

		// Get the page
		$page = $this->CI->db
						->limit(1)
						->select('id, title')
						->where('id', $input)
						->get('pages')
						->row();

		if ( ! $page) return null;
				
		return '<a href="'.site_url('admin/pages/edit/'.$page->id).'">'.$page->title.'</a>';
	}

	/**
	 * Tag output variables
	 *
	 * @param	$input string
	 * @param	$params array
	 * @return	array
	 */
	public function pre_output_plugin($input, $params)
	{
		$this->CI->load->helper('url');
		
		// Is this the current one?
		$input['current'] = ($input['uri'] == $this->CI->uri->uri_string()) ? true : false;

		// Create a link
		$input['link'] = site_url($input['uri']);

		// Create anchor
		$input['anchor'] = anchor($input['uri'], $input['title']);

		return $input;
	}

	/**
	 * Page Type Query Build Hook
	 *
	 * This left joins our page fields.
	 *
	 * @param 	array 	&$sql 	The sql array to add to.
	 * @param 	obj 	$field 	The field obj
	 * @param 	obj 	$stream The stream object
	 * @return 	void
	 */
	public function query_build_hook(&$sql, $field, $stream)
	{
		// Create a special alias for the users table.
		$alias = 'pg_'.$field->field_slug;

		$page_fields = array('id', 'slug', 'class', 'title', 'uri', 'parent_id',
						'type_id', 'entry_id', 'css', 'js', 'meta_title', 'meta_keywords',
						'meta_description', 'rss_enabled', 'comments_enabled', 'status',
						'restricted_to', 'strict_uri', 'is_home', 'order');

		foreach ($page_fields as $fld) {
			$sql['select'][] = '`'.$alias.'`.`'.$fld.'` as `'.$field->field_slug.'||'.$fld.'`';
		}

		$sql['join'][] = 'LEFT JOIN '.
				$this->CI->db->protect_identifiers('pages', true).' as `'.$alias.'` ON `'.
				$alias.'`.`id`='.$this->CI->db->protect_identifiers(
					$stream->stream_prefix.$stream->stream_slug.'.'.$field->field_slug, true);
	}

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
	private function _build_tree_select($params)
	{
		$params = array_merge(array(
			'tree'			=> array(),
			'parent_id'		=> 0,
			'current_parent'=> 0,
			'current_id'	=> 0,
			'level'			=> 0
		), $params);

		extract($params);

		if ( ! $tree) {
			
			if ($pages = $this->CI->db->select('id, parent_id, title')
					->get('pages')->result()) {
				
				foreach($pages as $page) {
					$tree[$page->parent_id][] = $page;
				}
			}
		}

		if ( ! isset($tree[$parent_id])) {
			return;
		}

		$html = '';

		foreach ($tree[$parent_id] as $item) {

			if ($current_id == $item->id) {
				continue;
			}

			$html .= '<option value="' . $item->id . '"';
			$html .= $current_parent == $item->id ? ' selected="selected">': '>';

			if ($level > 0) {

				for ($i = 0; $i < ($level*2); $i++) {
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