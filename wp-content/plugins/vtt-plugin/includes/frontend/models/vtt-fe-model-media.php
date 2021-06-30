<?php
/**
 * @Author	HaiNM - VTT - BreadnTea
 * @Mail	nguyenminhhai@breadntea.vn
 */

if (!defined('ABSPATH')) {
	exit;
}

class VTT_FeModelMedia {

	public static $_instance = null;

	private $table = 'vtt_media';
	
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
	
	public function getSlide($_limit=0) {
		$query = $this->query;
		$query->setName($this->table);
		$query->setSelect('name, link, url');
		$query->setWhere('type', 'slide');
		$query->setOrder('created_at DESC');
		$query->setLimit($_limit);
		return $query->getList();
	}
	
	public function create(array $data = []) {
		$query = $this->query;
		$query->setName($this->table);
		return $query->theCreate($data);
	}
	
	private function connection(){
		$this->query->setName($this->table);
		$this->query->hasTable();
	}
}