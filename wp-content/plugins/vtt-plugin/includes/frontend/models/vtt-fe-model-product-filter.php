<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

/**
 * Post types Class.
 */
class VTT_FeModelProductFilter {

	private static $_instance = null;

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
	
	public function detail($_id=0) {
		$query = $this->query;
		$query->setJoin('SELECT tbl1.post_id, tbl1.filter_id, tbl2.id, tbl2.name, tbl2.parent_id
			FROM gvn_vtt_product_filters AS tbl1
			LEFT JOIN gvn_vtt_filters AS tbl2 
			ON tbl1.filter_id = tbl2.id');
		$query->setWhere('tbl1.post_id',$_id);
		$query->setWhere('tbl2.is_valid', 1);
		return $query->joinTable('ARRAY_A');
	}
	
	public function getPostIdInFilterId(array $_filterId=[]) {
		$query = $this->query;
		$this->query->setName($this->table);
		$query->setSelect('DISTINCT(post_id)');
		$query->setIn('filter_id', $_filterId);
		$query->setGroupBy('post_id');
		$query->setHaving('COUNT(DISTINCT id) =', count($_filterId));
		return $query->getList('ARRAY_A');
	}
	
	private function connection(){
		$this->query->setName($this->table);
		$this->query->hasTable();
	}
	
}