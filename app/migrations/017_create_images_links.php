<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_images_links extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'object_id' => array(
				'type' => 'INT',
				'constraint' => 11
			),
			'object_type' => array(
				'type' => 'VARCHAR',
				'constraint' => 64
			),
			'image_id' => array(
				'type' => 'INT',
				'constraint' => 11
			)
		));
		
		$this->dbforge->create_table('images_links');
	}

	public function down()
	{
		$this->dbforge->drop_table('images_links');
	}
}