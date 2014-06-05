<?php
class Admin_Controller extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->data['meta_title'] = $this->config->item('site_name');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('user_m');
		$this->lang->load('admin_global');
		$this->data['delete_confirm'] = lang('delete_confirm');
		
		$extensions_uris = array(
			'admin/user/login',
			'admin/user/logout'
		);
		
		if (in_array(uri_string(), $extensions_uris) == FALSE) {
			$this->user_m->loggedin() == TRUE || redirect('admin/user/login');
			$this->data['role_id'] = $this->session->userdata('role_id');
			if ($this->session->userdata('message')) {
				$this->data['message'] = create_message_session();
			}
			$this->load->model('functional_m');
			if ($this->functional_m->has_access($this->data['role_id'])) {
				$this->data['menu'] = $this->functional_m->get_nested($this->data['role_id']);
				$this->data['page'] = $this->functional_m->get_by_link($this->uri->uri_string());
			} else {
				redirect('404');
			}
		}
		
		
	}
}