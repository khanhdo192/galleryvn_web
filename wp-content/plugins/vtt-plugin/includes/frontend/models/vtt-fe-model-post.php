<?php
/**
 * @Author	HaiNM - VTT - BreadnTea
 * @Mail	nguyenminhhai@breadntea.vn
 */

if (!defined('ABSPATH')) {
	exit;
}

class VTT_FeModelPost {

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

	public function getFilter(array $_postId=[], int $_limit=0, int $_offset=0) {
		if(count($_postId) < 1){
			return array();
		}
		$query = $this->query;
		$query->setJoin('SELECT tbl1.ID, tbl1.post_title, tbl2.default_price, tbl2.quantity, tbl2.author_name
			FROM gvn_posts AS tbl1
			LEFT JOIN gvn_vtt_products AS tbl2 
			ON tbl1.ID = tbl2.post_id');
		$query->setWhere('tbl1.post_type', 'product');
		$query->setWhere('tbl1.post_status', 'publish');
		$query->setWhere('tbl2.is_valid', 1);
		$query->setIn('tbl1.ID', $_postId);
		$query->setOrder('tbl1.post_date DESC');
		$query->setLimit($_limit);
		$query->setOffset($_offset);
		return $query->joinTable();
	}
	
	public function countFilter(array $_postId=[]) {
		if(count($_postId) < 1){
			return 0;
		}
		$query = $this->query;
		$query->setJoin('SELECT COUNT(tbl1.ID)
			FROM gvn_posts AS tbl1
			LEFT JOIN gvn_vtt_products AS tbl2 
			ON tbl1.ID = tbl2.post_id');
		$query->setWhere('tbl1.post_type', 'product');
		$query->setWhere('tbl1.post_status', 'publish');
		$query->setWhere('tbl2.is_valid', 1);
		$query->setIn('tbl1.ID', $_postId);
		return $query->joinTableCount();
	}

	public function getSearch(string $_query='', int $_limit=0, int $_offset=0) {
		if(empty($_query)){
			return array();
		}
		$query = $this->query;
		$query->setJoin('SELECT tbl1.ID, tbl1.post_title, tbl2.default_price, tbl2.quantity, tbl2.author_name
			FROM gvn_posts AS tbl1
			LEFT JOIN gvn_vtt_products AS tbl2 
			ON tbl1.ID = tbl2.post_id');
		$query->setWhere('tbl1.post_type', 'product');
		$query->setWhere('tbl1.post_status', 'publish');
		$query->setWhere('tbl2.is_valid', 1);
		$query->setLike('tbl1.post_title', $_query);
		$query->setOrder('tbl1.post_date DESC');
		$query->setLimit($_limit);
		$query->setOffset($_offset);
		return $query->joinTable();
	}
	
	public function countSearch(string $_query='') {
		if(empty($_query)){
			return 0;
		}
		$query = $this->query;
		$query->setJoin('SELECT COUNT(tbl1.ID)
			FROM gvn_posts AS tbl1
			LEFT JOIN gvn_vtt_products AS tbl2 
			ON tbl1.ID = tbl2.post_id');
		$query->setWhere('tbl1.post_type', 'product');
		$query->setWhere('tbl1.post_status', 'publish');
		$query->setWhere('tbl2.is_valid', 1);
		$query->setLike('tbl1.post_title', $_query);
		return $query->joinTableCount();
	}

	private function connection(){
		$this->query->setName($this->table);
		$this->query->hasTable();
	}
}