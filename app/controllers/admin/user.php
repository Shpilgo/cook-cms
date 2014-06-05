<?php
class User extends Admin_Controller
{
	
	function __construct () {
		parent::__construct();
		$this->lang->load('admin_'.str_class($this));
		$this->data['c_name'] = str_class($this);
	}
	
	public function index($curr_page = 1) {
		$this->load->library('pagination');
		$config['base_url'] = '/admin/'.str_class($this).'/'.__FUNCTION__.'/';
		$config['total_rows'] = $this->user_m->total_rows();
		$config['per_page'] = 15;
		$config['uri_segment'] = 4;
		$config['first_link'] = lang('first_link');
		$config['last_link'] = lang('last_link');
		$this->pagination->initialize($config);
		$this->data['paging'] = $this->pagination->create_links();
		$this->data['items'] = $this->user_m->get_page($curr_page, $config['per_page']);
		$this->data['subview'] = 'admin/'.str_class($this).'_'.__FUNCTION__.'_tpl';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	public function edit($id = NULL) {
		
		if ($id) {
			$this->data['item'] = $this->user_m->get($id);
			if (count($this->data['item'])) {
				$this->data['header'] = sprintf($this->lang->line('header_item_edit'), $this->data['item']->name);
			} else {
				$this->data['header'] = lang('not_found');
			}
		} else {
			$this->data['item'] = $this->user_m->get_new();
			$this->data['header'] = lang('header_item_add');
		}
		
		$this->load->model('user_roles_m');
		$this->data['user_roles'] = $this->user_roles_m->get_dropdown_list();
		
		if ($this->input->post()) {
			$rules = rules_lang($this->user_m->rules_admin);
			$data = $this->input->post();
			$id || $rules['password']['rules'] .= '|required';
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == TRUE) {
				unset($data['password_confirm']);
				if ($data['password'] != '') {
					$data['password'] = $this->user_m->hash($data['password']);
				} else {
					unset($data['password']);
				}
				$id = $this->user_m->save($data, $id);
				$this->session->set_userdata(array('message' => lang('status_success'), 'message_type' => 'success'));
				redirect('admin/'.str_class($this).'/edit/'.$id);
			} else {
				$message = validation_errors();
				$this->data['message'] = create_message($message, 'danger');
				$this->data['item'] = array_to_object($data);
			}
		}
		
		$this->data['subview'] = 'admin/'.str_class($this).'_'.__FUNCTION__.'_tpl';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	public function delete($id) {
		$this->user_m->delete($id);
		redirect('admin/user');
	}
	
	public function login() {
		
		$home = 'admin/home';
		$this->user_m->loggedin() == FALSE || redirect($home);
		
		$rules = rules_lang($this->user_m->rules);
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == TRUE) {
			if ($this->user_m->login() == TRUE) {
				redirect($home);
			} else {
				$this->session->set_flashdata('error', 'That email/password combination does not exist');
				redirect('admin/user/login', 'refresh');
			}
		}
		$this->data['subview'] = 'admin/'.str_class($this).'_'.__FUNCTION__.'_tpl';
		$this->load->view('admin/_layout_modal', $this->data);
	}
	
	public function logout() {
		$this->user_m->logout();
		redirect('admin/user/login');
	}
	
	public function _unique_email($str) {
		$id = $this->uri->segment(4);
		$this->db->where('email', $this->input->post('email'));
		!$id || $this->db->where('id !=', $id);
		$user = $this->user_m->get();
		
		if (count($user)) {
			$this->form_validation->set_message('_unique_email', '%s should be unique');
			return FALSE;
		}
		
		return TRUE;
	}
	
}