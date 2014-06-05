<?php
class Role_functional extends Admin_Controller
{
	
	function __construct () {
		parent::__construct();
		$this->load->model('role_functional_m');
		$this->load->model('user_roles_m');
		$this->load->model('functional_m');
		$this->lang->load('admin_'.str_class($this));
		$this->data['c_name'] = str_class($this);
	}
	
	public function index() {
		$this->data['roles'] = $this->user_roles_m->get();
		$this->data['functionals'] = $this->functional_m->get();
		$this->data['role_functional'] = $this->role_functional_m->get();
		$this->data['subview'] = 'admin/'.str_class($this).'_'.__FUNCTION__.'_tpl';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	public function ajax() {
		if ($this->input->post('functional_user_role')) {
			$functional_user_role = $this->input->post('functional_user_role');
		} else {
			$functional_user_role = array();
		}
		$this->role_functional_m->save($functional_user_role);
		$response['status'] = 'success';
		echo json_encode($response);
	}
	
}