<?php
class Geo_city_m extends MY_Model {
	protected $_table_name = 'geo_city';
	
	public function get_by_name($city) {
		$this->db->where($this->_table_name.'.city', $city);
		$db_data = parent::get(null, true);
		if(count($db_data)) {
			return $db_data->id;
		} else {
			return array();
		}
	}
	
}