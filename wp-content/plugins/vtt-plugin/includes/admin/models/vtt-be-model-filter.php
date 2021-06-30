<?php
/**
 * @Author	HaiNM - VTT - BreadnTea
 * @Mail	nguyenminhhai@breadntea.vn
 */

if (!defined('ABSPATH')) {
	exit;
}

class VTT_BeModelFilter {

	public static $_instance = null;

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
	
	public function getFilters($_limit=0, $_offset=0) {
		$query = $this->query;
		$query->setName($this->table);
		$query->setSelect('id, name, type, count, created_at');
		$query->setWhere('parent_id', 0);
		$query->setWhere('is_valid', 1);
		$query->setOrder('created_at DESC');
		$query->setLimit($_limit);
		$query->setOffset($_offset);
		return $query->getList();
	}

	public function countFilter() {
		$query = $this->query;
		$query->setName($this->table);
		$query->setSelect('COUNT(id)');
		$query->setWhere('parent_id', 0);
		$query->setWhere('is_valid', 1);
		return $query->getCount();
	}
	
	public function detailFilter($_id=0) {
		$query = $this->query;
		$query->setName($this->table);
		$query->setSelect('id, name, type, count, parent_id');
		$query->setWhere('id',$_id);
		$query->setWhere('is_valid', 1);
		$query->setOrWhere('parent_id',$_id);
		$result = $query->getList('ARRAY_A');
		$result = $this->buildFilter($result,0);
		return $result;
	}

	public function getFilterProduct() {
		$query = $this->query;
		$query->setName($this->table);
		$query->setSelect('id, name, type, count, parent_id');
		$query->setWhere('type', 'product');
		$query->setWhere('is_valid', 1);
		$result = $query->getList('ARRAY_A');
		$result = $this->buildFilter($result,0);
		return $result;
	}
	
	private function buildFilter(array $elements, $parentId = 0) {
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
	
	public function create(array $data = []) {
		$query = $this->query;
		$query->setName($this->table);
		return $query->theCreate($data);
	}
	
	public function update($id, array $data = []) {
		$query = $this->query;
		$query->setName($this->table);
		return $query->theUpdate($data, array('id' => $id));
	}
	
	public function creates(array $data = []) {
		$query = $this->query;
		$query->setName($this->table);
		return $query->createMulti($data);
	}
	
	private function connection(){
		$this->query->setName($this->table);
		$this->query->hasTable();
	}
}