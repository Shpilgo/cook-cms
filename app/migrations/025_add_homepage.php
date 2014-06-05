<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_homepage extends CI_Migration {

	public function up() {
		$this->db->query("INSERT INTO `pages` (`title`, `slug`, `order`, `body`, `parent_id`, `template`) VALUES ('home', '', 0, '<p>home</p>', 0, 'homepage');");
	}

	public function down() {
		$this->db->query("DELETE FROM `pages` WHERE `slug` = ''");
	}
}