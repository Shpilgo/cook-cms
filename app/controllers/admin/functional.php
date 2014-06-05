<?php
class Functional extends Admin_Controller
{
	
	function __construct () {
		parent::__construct();
		$this->load->model('functional_m');
		$this->lang->load('admin_'.str_class($this));
		$this->data['c_name'] = str_class($this);
	}
	
	public function index($curr_page = 1) {
		$this->load->library('pagination');
		$config['base_url'] = '/admin/'.str_class($this).'/'.__FUNCTION__.'/';
		$config['total_rows'] = $this->functional_m->total_rows();
		$config['per_page'] = 100;
		$config['uri_segment'] = 4;
		$config['first_link'] = lang('first_link');
		$config['last_link'] = lang('last_link');
		$this->pagination->initialize($config);
		if (($config['total_rows'] / $config['per_page']) > 1) {
			$this->data['curr_page'] = $curr_page;
			$this->data['base_url'] = $config['base_url'];
		}
		$this->data['paging'] = $this->pagination->create_links();
		$this->data['items'] = $this->functional_m->get_page($curr_page, $config['per_page']);
		$this->data['subview'] = 'admin/'.str_class($this).'_'.__FUNCTION__.'_tpl';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	public function edit($id = NULL) {
		
		if ($id) {
			$this->data['item'] = $this->functional_m->get($id);
			if (count($this->data['item'])) {
				$this->data['header'] = sprintf($this->lang->line('header_item_edit'), $this->data['item']->name);
			} else {
				$this->data['header'] = lang('not_found');
			}
		} else {
			$this->data['item'] = $this->functional_m->get_new();
			$this->data['header'] = lang('header_item_add');
		}
		
		$this->data['parents'] = $this->functional_m->get_no_parents($id);
		
		if ($this->input->post()) {
			$rules = rules_lang($this->functional_m->rules);
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == TRUE) {
				$id = $this->functional_m->save($this->input->post(), $id);
				$message = ($id) ? lang('saved') : lang('added');
				set_message($message, 'success');
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
		$this->functional_m->delete($id);
		redirect('admin/'.str_class($this));
	}
	
	public function _unique_name($str) {
		$id = $this->uri->segment(4);
		$this->db->where('functional.name', $this->input->post('name'));
		!$id || $this->db->where('functional.id !=', $id);
		$item = $this->functional_m->get();
		
		if (count($item)) {
			$this->form_validation->set_message('_unique_name', '%s '.lang('unique_error'));
			return FALSE;
		}
		
		return TRUE;
	}
	
	public function _unique_link($str) {
		$id = $this->uri->segment(4);
		$this->db->where('functional.link', $this->input->post('link'));
		!$id || $this->db->where('functional.id !=', $id);
		$item = $this->functional_m->get();
		
		if (count($item)) {
			$this->form_validation->set_message('_unique_link', '%s '.lang('unique_error'));
			return FALSE;
		}
		
		return TRUE;
	}
	
	public function ajax($id) {
		$this->functional_m->save($this->input->post(), $id);
		$response['status'] = 'success';
		$response['message'] = '';
		echo json_encode($response);
	}
	
}