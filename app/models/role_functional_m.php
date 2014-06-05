<?php
class Role_functional_m extends MY_Model {
	protected $_table_name = 'functional_user_role';
	
	public function clear() {
		$this->db->query('DELETE FROM '.$this->_table_name);
	}
	
	public function save($functional_user_role) {
		$this->clear();
		if (count($functional_user_role)) {
			foreach ($functional_user_role as $row) {
				parent::save($row);
			}
		}
	}
	
	public function get() {
		$role_functional = parent::get();
		$result = array();
		if (count($role_functional)) {
			foreach ($role_functional as $item) {
				$result[$item->user_role_id][$item->functional_id] = '';
			}
		}
		return $result;
	}
}