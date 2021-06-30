<?php
/**
 * @Author	HaiNM - VTT - BreadnTea
 * @Mail	nguyenminhhai@breadntea.vn
 */

if (!defined('ABSPATH')) {
	exit;
}

class VTT_BeModelPost {

	public static $_instance = null;

	private $table = 'posts';
	
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

	public function postNotProduct($_array = array()) {
		$query = $this->query;
		$query->setName($this->table);
		$query->setSelect('ID, post_title');
		$query->setWhere('post_type','product');
		$query->setWhere('post_status','publish');
		$query->setNotIn('ID',$_array);
		$query->setOrder('post_date ASC');
		return $query->getList();
	}

	public function detailName($_id=0) {
		$query = $this->query;
		$query->setName($this->table);
		$query->setSelect('post_title');
		$query->setWhere('id',$_id);
		return $query->getDetail();
	}

	private function connection(){
		$this->query->setName($this->table);
		$this->query->hasTable();
	}
}