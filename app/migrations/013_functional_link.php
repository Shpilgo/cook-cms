<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Functional_link extends CI_Migration {

	public function up() {
		$fields = array(
			'link' => array(
				'type' => 'VARCHAR',
				'constraint' => 100
			)
		);
		
		$this->dbforge->add_column('functional', $fields);
	}

	public function down() {
		$this->dbforge->drop_column('functional', 'link');
	}
}