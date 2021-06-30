<?php
/**
 * @Author	HaiNM - VTT - BreadnTea
 * @Mail	nguyenminhhai@breadntea.vn
 */

if (!defined('ABSPATH')) {
	exit;
}

class VTT_CjModelContact {

	public static $_instance = null;

	private $table = 'vtt_contacts';
	
	private $query = null;
	
	// Private methods cannot be called
	private function __construct() {
		$this->query = VTT_Query::instance();
		$this->connection();
	}
	
	// Private methods cannot be called
	private function __clone() {}

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function getAll($_limit=0) {
		$query = $this->query;
		$query->setName($this->table);
		$query->setSelect('*');
		$query->setWhere('send_at IS NULL');
		$query->setOrder('created_at ASC');
		$query->setLimit($_limit);
		return $query->getList('ARRAY_A');
	}
	
	public function update($id, array $data = []) {
		$query = $this->query;
		$query->setName($this->table);
		return $query->theUpdate($data, array('id' => $id));
	}
	
	private function connection(){
		$this->query->setName($this->table);
		$this->query->hasTable();
	}
}