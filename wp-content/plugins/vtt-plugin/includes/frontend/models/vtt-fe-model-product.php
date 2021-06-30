<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

/**
 * Post types Class.
 */
class VTT_FeModelProduct {

	private static $_instance = null;

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

	public function getExtraPostIds(array $_ids=[]) {
		$query = $this->query;
		$this->query->setName($this->table);
		$query->setSelect('post_id, default_price, quantity, author_name');
		$query->setWhere('is_valid', 1);
		$query->setIn('post_id', $_ids);
		return $query->getList('OBJECT_K');
	}
	
	public function detail($_id=0) {
		$query = $this->query;
		$query->setName($this->table);
		$query->setSelect('*');
		$query->setWhere('is_valid', 1);
		$query->setWhere('post_id',$_id);
		return $query->getDetail();
	}
	
	
	private function connection(){
		$this->query->setName($this->table);
		$this->query->hasTable();
	}
}