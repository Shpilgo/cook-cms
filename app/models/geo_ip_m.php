<?php
class Geo_ip_m extends MY_Model {
	protected $_table_name = 'geo_ip';
	
	public function get_data($ip) {
		$this->db->select($this->_table_name.'.*, geo_region.region, geo_city.city');
		$this->db->from($this->_table_name);
		$this->db->join('geo_region', 'geo_region.id = '.$this->_table_name.'.region_id', 'left');
		$this->db->join('geo_city', 'geo_city.id = '.$this->_table_name.'.city_id', 'left');
		$this->db->where($this->_table_name.'.ip', $ip);
		$db_data = $this->db->get()->row_array();
		if (count($db_data)) {
			return $db_data;
		} else {
			$this->load->helper('pharse');
			$url = "http://geoip.elib.ru/cgi-bin/getdata.pl?ip=".$ip."&fmt=json&cn=1&rg=1&tn=1&lt=1&lg=1";
			$geoip_data = json_decode(get_page_html($url, false));
			if (isset($geoip_data->$ip->Error)) {
				return false;
			}
			$country = '';
			if ($geoip_data->$ip->Country == 'Украина') {
				$country = 'UA';
			} else if ($geoip_data->$ip->Country == 'Россия') {
				$country = 'RU';
			}
			$this->load->model('geo_region_m');
			$region_id = $this->geo_region_m->get_by_name($geoip_data->$ip->Region);
			if (!count($region_id)) {
				$region_id = $this->geo_region_m->save(array(
					'region' => $geoip_data->$ip->Region
				));
			}
			$this->load->model('geo_city_m');
			$city_id = $this->geo_city_m->get_by_name($geoip_data->$ip->Town);
			if (!count($city_id)) {
				$city_id = $this->geo_city_m->save(array(
					'city' => $geoip_data->$ip->Town
				));
			}
			$to_db = array(
				'ip' => $ip,
				'country' => $country,
				'region_id' => $region_id,
				'city_id' => $city_id,
				'lat' => $geoip_data->$ip->Lat,
				'lon' => $geoip_data->$ip->Lon
			);
			$to_db['id'] = parent::save($to_db);
			$to_db['region'] = $geoip_data->$ip->Region;
			$to_db['city'] = $geoip_data->$ip->Town;
			return $to_db;
		}
	}
	
	public function get_data_short($ip) {
		$all_data = $this->get_data($ip);
		if ($all_data != false) {
			$all_data['geo_ip_id'] = $all_data['id'];
			unset($all_data['id']);
			unset($all_data['ip']);
			unset($all_data['region_id']);
			unset($all_data['city_id']);
		}
		return $all_data;
	}
	
}