<?php
class Article extends Admin_Controller {
	
	function __construct () {
		parent::__construct();
		$this->load->model('article_m');
		$this->lang->load('admin_'.str_class($this));
		$this->data['c_name'] = str_class($this);
	}
	
	public function index($curr_page = 1) {
		$this->load->library('pagination');
		$config['base_url'] = '/admin/'.str_class($this).'/'.__FUNCTION__.'/';
		$config['total_rows'] = $this->article_m->total_rows();
		$config['per_page'] = 15;
		$config['uri_segment'] = 4;
		$config['first_link'] = lang('first_link');
		$config['last_link'] = lang('last_link');
		$this->pagination->initialize($config);
		$this->data['paging'] = $this->pagination->create_links();
		$this->data['items'] = $this->article_m->get_page($curr_page, $config['per_page']);
		$this->data['subview'] = 'admin/'.str_class($this).'_'.__FUNCTION__.'_tpl';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	public function edit($id = NULL) {
		
		if ($id) {
			$this->data['item'] = $this->article_m->get($id);
			if (count($this->data['item'])) {
				$this->load->model('image_links_m');
				$this->data['item']->images = $this->image_links_m->get_type($id, str_class($this));
				$this->data['header'] = sprintf($this->lang->line('header_item_edit'), $this->data['item']->title);
			} else {
				$this->data['header'] = lang('not_found');
			}
		} else {
			$this->data['item'] = $this->article_m->get_new();
			$this->data['header'] = lang('header_item_add');
		}
		
		if ($this->input->post()) {
			$rules = rules_lang($this->article_m->rules);
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == TRUE) {
				$data = $this->article_m->array_from_post(array('title', 'slug', 'body', 'pubdate'));
				$id = $this->article_m->save($data, $id);
				$this->load->model('image_m');
				$images_ids = $this->image_m->upload();
				$this->load->model('image_links_m');
				$this->image_links_m->save($images_ids, $id, str_class($this));
				$this->session->set_userdata(array('message' => lang('status_success'), 'message_type' => 'success'));
				redirect('admin/'.str_class($this).'/edit/'.$id);
			} else {
				$message = validation_errors();
				$this->data['message'] = create_message($message, 'danger');
				$this->data['item'] = array_to_object($this->input->post());
			}
		}
		
		$this->data['subview'] = 'admin/'.str_class($this).'_'.__FUNCTION__.'_tpl';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	public function delete($id) {
		$this->article_m->delete($id);
		redirect('admin/article');
	}
	
	public function _unique_slug($str) {
		$id = $this->uri->segment(4);
		$this->db->where('slug', $this->input->post('slug'));
		!$id || $this->db->where('id !=', $id);
		$article = $this->article_m->get();
		
		if (count($article)) {
			$this->form_validation->set_message('_unique_slug', '%s should be unique');
			return FALSE;
		}
		
		return TRUE;
	}
	
	public function ajax_remove_image($id) {
		$this->load->model('image_links_m');
		$this->image_links_m->remove_link($id, $this->input->post('type'), $this->input->post('image'));
	}
}