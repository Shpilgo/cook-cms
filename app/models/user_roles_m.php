<?php
class User_roles_m extends MY_Model {
	protected $_table_name = 'user_roles';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'trim|required|max_length[100]|callback__unique_name|xss_clean'
		)
	);
	
	public function get_new() {
		$item = new stdClass();
		$item->name = '';
		return $item;
	}
	
	public function get_dropdown_list() {
		$this->db->select('id, name');
		$roles = parent::get();
		
		$array = array(0 => 'No role');
		if (count($roles)) {
			foreach ($roles as $role) {
				$array[$role->id] = $role->name;
			}
		}
		return $array;
	}
	
}