<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

/**
 * Post types Class.
 */
class VTT_FeModelProductImage {

	private static $_instance = null;

	private $table = 'vtt_product_images';

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
		$query->setName($this->table);
		$query->setSelect('*');
		$query->setWhere('post_id',$_id);
		return $query->getList('ARRAY_A');
	}
	
	private function connection(){
		$this->query->setName($this->table);
		$this->query->hasTable();
	}
}