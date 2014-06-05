<?php
class Image_m extends MY_Model {
	protected $_table_name = 'images';
	
	public function get_by_name($file_name) {
		$this->db->where($this->_table_name.'.file_name', $file_name);
		return parent::get(null, true);
	}
	
	public function upload($array_name = 'images') {
		$file_ids = array();
		if(!empty($_FILES)) {
			ini_set ("upload_max_filesize", "40M");
			ini_set ("post_max_size", "40M");
			ini_set ("max_execution_time", "60");
			foreach ($_FILES[$array_name]['tmp_name'] as $key => $tmp_name) {
				$type = $_FILES[$array_name]['type'][$key];
				$error = $_FILES[$array_name]['error'][$key];
				$name = $_FILES[$array_name]['name'][$key];
				$size = $_FILES[$array_name]['size'][$key];
				$type_exp = explode('/', $type);
				$ext = $type_exp[1];
				$available_ext = array('jpeg', 'png', 'gif');
				if (in_array($ext, $available_ext) && $error == 0) {
					$params = getimagesize($tmp_name);
					$file_id = uniqid();
					$upload_dir = 'uploads';
					if (!file_exists($upload_dir)) {
						umask(0000);
						mkdir($upload_dir);
						// @chmod($upload_dir, 777);
					}
					$images_dir = $upload_dir.'/images';
					if (!file_exists($images_dir)) {
						umask(0000);
						mkdir($images_dir);
						// @chmod($images_dir, 777);
					}
					if (move_uploaded_file($tmp_name, $images_dir.'/'.$file_id.'.'.$ext)) {
						$name = substr($name, 0, strrpos($name, '.'));
						$name = (strlen($name) > 64) ? substr($name, 0, 64) : $name;
						$image = array(
							'name' => $name,
							'file_name' => $file_id,
							'file_size' => $size,
							'width' => $params[0],
							'height' => $params[1],
							'ext' => $ext
						);
						$file_ids[] = parent::save($image);
					}
				}
			}
		}
		return $file_ids;
	}
}