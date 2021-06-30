<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

/**
 * Post types Class.
 */
class VTT_FeModelFilter {

	private static $_instance = null;

	private $table = 'vtt_filters';

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
	
	public function getAll() {
		$query = VTT_Query::instance();
		$query->setName($this->table);
		$query->setSelect('id, name, type, count, parent_id');
		$query->setWhere('type', 'product');
		$query->setWhere('is_valid', 1);
		$result = $query->getList('ARRAY_A');
		$result = $this->buildFilter($result,0);
		return $result;
	}
	
	public function getFilterParentId() {
		$query = VTT_Query::instance();
		$query->setName($this->table);
		$query->setSelect('id, name, parent_id');
		$query->setWhere('parent_id', 'IS NOT NULL');
		$query->setWhere('type', 'product');
		$query->setWhere('is_valid', 1);
		$result = $query->getList('ARRAY_A');
		return $result;
	}
	
	public function buildFilter(array $elements, $parentId = 0) {
		$branch = array();
		foreach ($elements as $element) {
			if ($element['parent_id'] == $parentId) {
				$children = self::buildFilter($elements, $element['id']);
				if ($children) {
					$element['children'] = $children;
				}
				$branch[] = $element;
			}
		}

		return $branch;
	}
	
	private function connection(){
		$this->query->setName($this->table);
		$this->query->hasTable();
	}
}