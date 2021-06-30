<?php
/**
 * @Author	HaiNM - VTT - BreadnTea
 * @Mail	nguyenminhhai@breadntea.vn
 */

if (!defined('ABSPATH')) {
	exit;
}

class VTT_BeModelProduct {

	public static $_instance = null;

	private $table = 'vtt_products';
	
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
	
	public function getProducts($_limit=0, $_offset=0) {
		$query = $this->query;
		$query->setJoin('SELECT tbl1.id, tbl1.post_id, tbl1.created_at, tbl2.post_title
			FROM gvn_vtt_products AS tbl1
			LEFT JOIN gvn_posts AS tbl2 
			ON tbl1.post_id = tbl2.ID');
		$query->setWhere('tbl1.is_valid',1);
		$query->setWhere('tbl2.post_status','publish');
		$query->setOrder('created_at DESC');
		$query->setLimit($_limit);
		$query->setOffset($_offset);
		return $query->joinTable();
	}

	public function countProduct() {
		$query = $this->query;
		$query->setName($this->table);
		$query->setSelect('COUNT(id)');
		return $query->getCount();
	}
	
	public function detailProduct($_id=0) {
		$query = $this->query;
		$query->setJoin('SELECT tbl1.*, tbl2.post_title
			FROM gvn_vtt_products AS tbl1
			LEFT JOIN gvn_posts AS tbl2 
			ON tbl1.post_id = tbl2.ID');
		$query->setWhere('tbl1.is_valid',1);
		$query->setWhere('tbl1.id', $_id);
		$query->setWhere('tbl2.post_status','publish');
		return $query->joinTableDetail();
	}
	
	public function arrayProductIds() {
		$query = $this->query;
		$query->setName($this->table);
		$query->setSelect('post_id');
		$query->setWhere('is_valid',1);
		return $query->getList('ARRAY_A');
	}

	public function checkProduct(string $_where='', $_value) {
		$query = $this->query;
		$query->setName($this->table);
		$query->setSelect('COUNT(Id)');
		$query->setWhere($_where, $_value);
		return $query->getCount();
	}

	public function create(array $data = []) {
		$query = $this->query;
		$query->setName($this->table);
		return $query->theCreate($data);
	}

	public function update(array $where = [], array $data = []) {
		$query = $this->query;
		$query->setName($this->table);
		return $query->theUpdate($data, $where);
	}

	private function connection(){
		$this->query->setName($this->table);
		$this->query->hasTable();
	}
}