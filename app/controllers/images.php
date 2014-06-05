<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Images extends Frontend_Controller {

	function __construct () {
		parent::__construct();
		$this->load->model('image_m');
		$this->load->model('image_links_m');
		$this->load->library('image_lib');
	}
	
	public function thumbs($image_size, $image_name) {
		$image_size_config = $this->config->item('image_size_'.$image_size);
		if ($image_size_config) {
			$image_params = $this->image_m->get_by_name(substr($image_name, 0, strrpos($image_name, '.')));
			$thumbs_dir = 'images/thumbs';
			if (!file_exists($thumbs_dir)) {
				umask(0000);
				mkdir($thumbs_dir);
			}
			$new_image_dir = $thumbs_dir.'/'.$image_size;
			if (!file_exists($new_image_dir)) {
				umask(0000);
				mkdir($new_image_dir);
			}
			$config['image_library'] = 'gd2';
			$config['source_image'] = 'uploads/images/'.$image_name;
			$config['create_thumb'] = false;
			$config['maintain_ratio'] = true;
			$config['new_image'] = $new_image_dir.'/'.$image_name;
			$config['quality'] = '100%';
			$config['width'] = $image_size_config[0];
			$config['height'] = $image_size_config[1];
			$dim = (intval($image_params->width) / intval($image_params->height)) - ($config['width'] / $config['height']);
			$config['master_dim'] = ($dim > 0) ? 'height' : 'width';
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			$this->image_lib->clear();
			$config['source_image'] = $config['new_image'];
			$thumb_params = getimagesize($config['source_image']);
			$config['maintain_ratio'] = false;
			if ($image_size == 'preview') {
				$config['y_axis'] = 0;
				$config['x_axis'] = 0;
			} else {
				$config['y_axis'] = ($thumb_params[1] - $config['height']) / 2;
				$config['x_axis'] = ($thumb_params[0] - $config['width']) / 2;
			}
			$this->image_lib->initialize($config);
			$this->image_lib->crop();
			header('Content-type:image/'.$image_params->ext);
			readfile($config['new_image']);
		}
	}
	
}