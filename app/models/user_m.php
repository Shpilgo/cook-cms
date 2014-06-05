<?php
class User_M extends MY_Model {
	
	protected $_table_name = 'users';
	protected $_order_by = 'name';
	public $rules = array(
		'email' => array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'trim|required|valid_email|xss_clean'
		),
		'password' => array(
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'trim|required'
		)
	);
	public $rules_admin = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'trim|required|xss_clean'
		),
		'email' => array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'trim|required|valid_email|callback__unique_email|xss_clean'
		),
		'password' => array(
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'trim|matches[password_confirm]'
		),
		'password_confirm' => array(
			'field' => 'password_confirm',
			'label' => 'Confirm Password',
			'rules' => 'trim|matches[password]'
		)
	);
	
	function __construct () {
		parent::__construct();
	}
	
	public function login() {
		$user = $this->get_by(array(
			'email' => $this->input->post('email'),
			'password' => $this->hash($this->input->post('password'))
		), TRUE);
		
		if (count($user)) {
			$data = array(
				'name' => $user->name,
				'email' => $user->email,
				'id' => $user->id,
				'role_id' => $user->role_id,
				'loggedin' => TRUE
			);
			$this->session->set_userdata($data);
		}
	}
	
	public function logout() {
		$this->session->sess_destroy();
	}
	
	public function loggedin() {
		return (bool) $this->session->userdata('loggedin');
	}
	
	public function get_new() {
		$user = new stdClass();
		$user->name = '';
		$user->email = '';
		$user->password = '';
		$user->role_id = 0;
		return $user;
	}
	
	public function hash($string) {
		return hash('sha512', $string.config_item('encryption_key'));
	}
	
	public function get_page($curr_page, $per_page) {
		$this->db->select($this->_table_name.'.*, user_roles.name AS role');
		$this->db->join('user_roles', 'user_roles.id = '.$this->_table_name.'.role_id', 'left');
		return parent::get_page($curr_page, $per_page);
	}
	
}