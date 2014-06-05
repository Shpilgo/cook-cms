<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_role_id_to_users extends CI_Migration {

	public function up() {
		$fields = array(
			'role_id' => array(
				'type' => 'INT',
				'constraint' => 11
			)
		);
		
		$this->dbforge->add_column('users', $fields);
	}

	public function down() {
		$this->dbforge->drop_column('users', 'role_id');
	}
}