<?php
class Functional_m extends MY_Model {
	protected $_table_name = 'functional';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'trim|required|max_length[100]|callback__unique_name|xss_clean'
		),
		'link' => array(
			'field' => 'link',
			'label' => 'Link',
			'rules' => 'trim|required|max_length[100]|callback__unique_link'
		)
	);
	
	public function get_new() {
		$functional = new stdClass();
		$functional->name = '';
		$functional->parent_id = 0;
		$functional->link = '';
		return $functional;
	}
	
	public function get_no_parents($id) {
		$this->db->select('id, name');
		$this->db->where('parent_id', 0);
		if ($id) {
			$this->db->where('id !=', $id);
		}
		$items = parent::get();
		
		$array = array(0 => 'No parent');
		if (count($items)) {
			foreach ($items as $item) {
				$array[$item->id] = $item->name;
			}
		}
		return $array;
	}
	
	public function get_page($curr_page, $per_page) {
		$this->db->select($this->_table_name.'.*, parent.name AS parent_name');
		$this->db->join($this->_table_name.' AS parent', 'parent.id = '.$this->_table_name.'.parent_id', 'left');
		return parent::get_page($curr_page, $per_page);
	}
	
	public function get($id = NULL, $single = FALSE) {
		$this->db->select($this->_table_name.'.*, parent.name AS parent_name');
		$this->db->join($this->_table_name.' AS parent', 'parent.id = '.$this->_table_name.'.parent_id', 'left');
		$this->db->where($this->_table_name.'.status', 1);
		return parent::get($id, $single);
	}
	
	public function has_access($role_id) {
		$uri_elements = explode('/', $this->uri->uri_string());
		unset($uri_elements[0]);
		if (count($uri_elements) == 0 || $uri_elements[1] == 'home' || $this->session->userdata('id') == 1) {
			return true;
		} else {
			if (count($uri_elements) >= 1) {
				$this->db->join('functional_user_role', 'functional_id = '.$this->_table_name.'.id AND user_role_id = '.$role_id);
				$this->db->where($this->_table_name.'.link', $uri_elements[1]);
				if (count($uri_elements) >= 2) {
					$this->db->or_where($this->_table_name.'.link', $uri_elements[1].'/'.$uri_elements[2]);
				}
				return (bool) parent::get();
			} else {
				return false;
			}
		}
	}
	
	public function get_nested($role_id) {
		$this->db->where('id IN (SELECT functional_id FROM functional_user_role WHERE user_role_id = '.$role_id.')', NULL, FALSE);
		$this->db->where($this->_table_name.'.status', 1);
		$items = $this->db->get($this->_table_name)->result_array();
		$array = array();
		foreach ($items as $item) {
			if (!$item['parent_id']) {
				foreach ($item as $key => $item_el) {
					$array[$item['id']][$key] = $item_el;
				}
			} else {
				foreach ($item as $key => $item_el) {
					$array[$item['parent_id']]['children'][$item['id']][$key] = $item_el;
				}
			}
		}
		return $array;
	}
	
	public function get_by_link($link) {
		$link_parts = explode('/', $link);
		unset($link_parts[0]);
		foreach ($link_parts as $index => $link_part) {
			if ($link_part == 'edit') {
				unset($link_parts[$index]);
			} else if (is_numeric($link_part)) {
				unset($link_parts[$index]);
			}
		}
		$link = implode('/', $link_parts);
		$this->db->select($this->_table_name.'.*, parent.name AS parent_name, parent.link AS parent_link');
		$this->db->join($this->_table_name.' AS parent', 'parent.id = '.$this->_table_name.'.parent_id', 'left');
		$this->db->where($this->_table_name.'.link', $link);
		$page = parent::get(null, true);
		return($page);
	}
	
}