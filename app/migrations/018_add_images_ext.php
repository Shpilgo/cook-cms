<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_images_ext extends CI_Migration {

	public function up() {
		$fields = array(
			'ext' => array(
				'type' => 'VARCHAR',
				'constraint' => 5,
				'default' => 'jpg'
			)
		);
		
		$this->dbforge->add_column('images', $fields);
	}

	public function down() {
		$this->dbforge->drop_column('images', 'ext');
	}
}