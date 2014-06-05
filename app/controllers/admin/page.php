<?php
class Page extends Admin_Controller
{
	
	function __construct () {
		parent::__construct();
		$this->load->model('page_m');
		$this->lang->load('admin_'.str_class($this));
		$this->data['c_name'] = str_class($this);
	}
	
	public function index($curr_page = 1) {
		$this->load->library('pagination');
		$config['base_url'] = '/admin/'.str_class($this).'/'.__FUNCTION__.'/';
		$config['total_rows'] = $this->page_m->total_rows();
		$config['per_page'] = 15;
		$config['uri_segment'] = 4;
		$config['first_link'] = lang('first_link');
		$config['last_link'] = lang('last_link');
		$this->pagination->initialize($config);
		$this->data['paging'] = $this->pagination->create_links();
		$this->data['items'] = $this->page_m->get_page($curr_page, $config['per_page']);
		$this->data['subview'] = 'admin/'.str_class($this).'_'.__FUNCTION__.'_tpl';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	public function order() {
		$this->data['sortable'] = TRUE;
		$this->data['subview'] = 'admin/'.str_class($this).'_'.__FUNCTION__.'_tpl';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	public function order_ajax() {
		if (isset($_POST['sortable'])) {
			$this->page_m->save_order($_POST['sortable']);
		}
		$this->data['pages'] = $this->page_m->get_nested();
		$this->load->view('admin/'.str_class($this).'_'.__FUNCTION__.'_tpl', $this->data);
	}
	
	public function edit($id = NULL) {
		
		if ($id) {
			$this->data['item'] = $this->page_m->get($id);
			if (count($this->data['item'])) {
				$this->data['header'] = sprintf($this->lang->line('header_item_edit'), $this->data['item']->title);
			} else {
				$this->data['header'] = lang('not_found');
			}
		} else {
			$this->data['item'] = $this->page_m->get_new();
			$this->data['header'] = lang('header_item_add');
		}
		
		$this->data['pages_no_parents'] = $this->page_m->get_no_parents();
		
		if ($this->input->post()) {
			$rules = rules_lang($this->page_m->rules);
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == TRUE) {
				$data = $this->page_m->array_from_post(array('title', 'slug', 'body', 'template', 'parent_id'));
				$id = $this->page_m->save($data, $id);
				$this->session->set_userdata(array('message' => lang('status_success'), 'message_type' => 'success'));
				redirect('admin/'.str_class($this).'/edit/'.$id);
			} else {
				$message = validation_errors();
				$this->data['message'] = create_message($message, 'danger');
				$this->data['item'] = array_to_object($this->input->post());
			}
			
		}
		$this->data['templates_list'] = get_templates_list();
		$this->data['subview'] = 'admin/'.str_class($this).'_'.__FUNCTION__.'_tpl';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	public function delete($id) {
		$this->page_m->delete($id);
		redirect('admin/page');
	}
	
	public function _unique_slug($str) {
		$id = $this->uri->segment(4);
		$this->db->where('slug', $this->input->post('slug'));
		!$id || $this->db->where('id !=', $id);
		$page = $this->page_m->get();
		
		if (count($page)) {
			$this->form_validation->set_message('_unique_slug', '%s should be unique');
			return FALSE;
		}
		
		return TRUE;
	}
	
}