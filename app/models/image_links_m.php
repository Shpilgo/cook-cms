<?php
class Image_links_m extends MY_Model {
	protected $_table_name = 'images_links';
	
	public function get_type($object_id, $object_type) {
		$this->db->select($this->_table_name.'.*, images.*');
		$this->db->join('images', 'images.id = '.$this->_table_name.'.image_id');
		$this->db->where($this->_table_name.'.object_id', $object_id);
		$this->db->where($this->_table_name.'.object_type', $object_type);
		return parent::get();
	}
	
	public function save($images_ids, $object_id, $object_type) {
		if (count($images_ids)) {
			foreach ($images_ids as $image_id) {
				parent::save(array(
					'object_id' => $object_id,
					'object_type' => $object_type,
					'image_id' => $image_id
				));
			}
		}
	}
	
	public function remove_link($object_id, $object_type, $image_id) {
		$this->db->where('object_id', $object_id);
		$this->db->where('object_type', $object_type);
		$this->db->where('image_id', $image_id);
		$this->db->delete($this->_table_name);
	}
	
	public function delete($object_id, $object_type) {
		$this->db->where('object_id', $object_id);
		$this->db->where('object_type', $object_type);
		$this->db->delete($this->_table_name);
	}
}