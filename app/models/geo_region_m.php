<?php
class Geo_region_m extends MY_Model {
	protected $_table_name = 'geo_region';
	
	public function get_by_name($region) {
		$this->db->where($this->_table_name.'.region', $region);
		$db_data = parent::get(null, true);
		if(count($db_data)) {
			return $db_data->id;
		} else {
			return array();
		}
	}
	
}