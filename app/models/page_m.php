<?php
class Page_m extends MY_Model {
	protected $_table_name = 'pages';
	protected $_order_by = 'order';
	public $rules = array(
		'parent_id' => array(
			'field' => 'parent_id',
			'label' => 'Parent_id',
			'rules' => 'trim|intval'
		),
		'template' => array(
			'field' => 'template',
			'label' => 'Template',
			'rules' => 'trim|required|xss_clean'
		),
		'title' => array(
			'field' => 'title',
			'label' => 'Title',
			'rules' => 'trim|required|max_length[100]|xss_clean'
		),
		'slug' => array(
			'field' => 'slug',
			'label' => 'Slug',
			'rules' => 'trim|required|max_length[100]|url_title|callback__unique_slug|xss_clean'
		),
		'order' => array(
			'field' => 'order',
			'label' => 'Order',
			'rules' => 'trim|is_natural|xss_clean'
		),
		'body' => array(
			'field' => 'body',
			'label' => 'Body',
			'rules' => 'trim|required'
		)
	);
	
	public function get_new() {
		$page = new stdClass();
		$page->title = '';
		$page->slug = '';
		$page->order = '';
		$page->body = '';
		$page->parent_id = 0;
		$page->template = 'page';
		return $page;
	}
	
	public function get_archive_link() {
		$page = parent::get_by(array('template' => 'news_archive'), TRUE);
		return isset($page->slug) ? $page->slug : '';
	}
	public function delete($id) {
		parent::delete($id);
		$this->db->set(array('parent_id' => 0))->where('parent_id', $id)->update($this->_table_name);
	}
	
	public function get_nested() {
		$this->db->order_by($this->_order_by);
		$pages = $this->db->get('pages')->result_array();
		$array = array();
		foreach ($pages as $page) {
			if (!$page['parent_id']) {
				foreach ($page as $key => $page_el) {
					$array[$page['id']][$key] = $page_el;
				}
			} else {
				foreach ($page as $key => $page_el) {
					$array[$page['parent_id']]['children'][$page['id']][$key] = $page_el;
				}
			}
		}
		return $array;
	}
	
	public function save_order($pages) {
		if (count($pages)) {
			foreach ($pages as $order => $page) {
				if ($page['item_id'] != '') {
					$data = array('parent_id' => (int) $page['parent_id'], 'order' => $order);
					$this->db->set($data)->where($this->_primary_key, $page['item_id'])->update($this->_table_name);
				}
			}
		}
	}
	
	// public function get_with_parent($id = NULL, $single = FALSE) {
		// $this->db->select('pages.*, p.slug as parent_slug, p.title as parent_title');
		// $this->db->join('pages as p', 'pages.parent_id = p.id', 'left');
		// return parent::get($id, $single);
	// }
	
	public function get_no_parents() {
		$this->db->select('id, title');
		$this->db->where('parent_id', 0);
		$pages = parent::get();
		
		$array = array(0 => 'No parent');
		if (count($pages)) {
			foreach ($pages as $page) {
				$array[$page->id] = $page->title;
			}
		}
		return $array;
	}
	
	public function get_page($curr_page, $per_page) {
		$this->db->select('pages.*, parent.slug as parent_slug, parent.title as parent_title');
		$this->db->join('pages as parent', 'pages.parent_id = parent.id', 'left');
		return parent::get_page($curr_page, $per_page);
	}
}