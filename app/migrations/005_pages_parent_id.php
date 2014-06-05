<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Pages_parent_id extends CI_Migration {

	public function up() {
		$fields = array(
			'parent_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'default' => 0
			)
		);
		
		$this->dbforge->add_column('pages', $fields);
	}

	public function down() {
		$this->dbforge->drop_column('pages', 'parent_id');
	}
}