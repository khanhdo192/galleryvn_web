<?php
/**
 * @Author	HaiNM - VTT - BreadnTea
 * @Mail	nguyenminhhai@breadntea.vn
 */

if (!defined('ABSPATH')) {
	exit;
}

class VTT_CjModelProductPurchase {

	public static $_instance = null;

	private $table = 'vtt_product_purchases';
	
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
	
	public function getAllOrder($_limit=0) {
		$query = $this->query;
		$query->setName($this->table);
		$query->setSelect('*');
		$query->setWhere('type', 'order');
		$query->setWhere('send_at IS NULL');
		$query->setOrder('created_at ASC');
		$query->setLimit($_limit);
		return $query->getList('ARRAY_A');
	}

	public function getAllBuy($_limit=0) {
		$query = $this->query;
		$query->setJoin('SELECT tbl1.*, tbl2.post_title
			FROM gvn_vtt_product_purchases AS tbl1
			LEFT JOIN gvn_posts AS tbl2 
			ON tbl1.post_id = tbl2.ID');
		$query->setWhere('tbl1.type', 'buy');
		$query->setWhere('tbl1.send_at IS NULL');
		$query->setOrder('tbl1.created_at ASC');
		$query->setLimit($_limit);
		return $query->joinTable('ARRAY_A');
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