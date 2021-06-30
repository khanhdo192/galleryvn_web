<?php
/**
 * @Author	HaiNM - VTT - BreadnTea
 * @Mail	nguyenminhhai@breadntea.vn
 */

if (!defined('ABSPATH')) {
	exit;
}

class VTT_BeModelProductFilter {

	public static $_instance = null;

	private $table = 'vtt_product_filters';
	
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

	public function getAllByPostId($_id = 0) {
		$query = $this->query;
		$query->setName($this->table);
		$query->setSelect('filter_id, filter_value');
		$query->setWhere('post_id',$_id);
		return $query->getList('ARRAY_A');
	}

	public function creates(array $data = []) {
		$query = $this->query;
		$query->setName($this->table);
		return $query->createMulti($data);
	}

	public function update($id, array $data = []) {
		$query = $this->query;
		$query->setName($this->table);
		return $query->theUpdate($data, array('id' => $id));
	}

	public function delete(array $where = []) {
		$query = $this->query;
		$query->setName($this->table);
		return $query->theDelete($where);
	}

	private function connection(){
		$this->query->setName($this->table);
		$this->query->hasTable();
	}
}