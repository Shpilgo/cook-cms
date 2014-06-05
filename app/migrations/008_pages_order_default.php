<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Pages_order_default extends CI_Migration {

	public function up() {
		$this->db->query("ALTER TABLE  `pages` CHANGE  `order`  `order` INT( 11 ) NULL DEFAULT  '0'");
	}

	public function down() {
		$this->db->query("ALTER TABLE  `pages` CHANGE  `order`  `order` INT( 11 ) NOT NULL");
	}
}