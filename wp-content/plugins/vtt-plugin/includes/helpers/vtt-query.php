<?php
/**
 * VTT Query Class
 *
 * @Author	HaiNM
 * @Website	http://hainm.com/
 */
if (!defined('ABSPATH')) {
	exit;
}

class VTT_Query {
	
	public static $_instance = null;
	
	private $_wpdb = '';

	private $_table = '';

	private $_select = '';
	
	private $_join = '';

	private $_whereName = array();

	private $_whereValue = array();

	private $_orWhereName = array();

	private $_orWhereValue = array();

	private $_inName = '';

	private $_inValue = array();

	private $_notInName = '';

	private $_notInValue = array();

	private $_likeName = array();

	private $_likeValue = array();
	
	private $_likeType = '';

	private $_groupBy = '';
	
	private $_havingName = array();
	
	private $_havingValue = array();
	
	private $_order = '';

	private $_limit = 0;

	private $_offset = 0;
	
	// Private methods cannot be called
	private function __construct() {
		global $wpdb;
		$this->_wpdb =& $wpdb;
	}
	
	// Private methods cannot be called
	private function __clone() {}

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function setName($param) {
		$table = $this->_wpdb->prefix . $param;
		$this->_table = $table;
	}

	public function setJoin($param) {
		$this->_join = $param;
	}
	
	public function setSelect($param) {
		$this->_select = $param;
	}
	
	public function setWhere($param_1='', $param_2='') {
		$this->_whereName[] = $param_1;
		$this->_whereValue[] = $param_2;
	}

	public function setOrWhere($param_1='', $param_2='') {
		$this->_orWhereName[] = $param_1;
		$this->_orWhereValue[] = $param_2;
	}

	public function setIn($param_1='', $param_2=[]) {
		$this->_inName = $param_1;
		$this->_inValue = $param_2;
	}

	public function setNotIn($param_1='', $param_2=[]) {
		$this->_notInName = $param_1;
		$this->_notInValue = $param_2;
	}

	public function setLike($param_1=[], $param_2=[], $param_3='') {
		$this->_likeName[] = $param_1;
		$this->_likeValue[] = $param_2;
		$this->_likeType = $param_3;
	}
	
	public function setGroupBy($param) {
		$this->_groupBy = $param;
	}

	public function setHaving($param_1='', $param_2='') {
		$this->_havingName[] = $param_1;
		$this->_havingValue[] = $param_2;
	}
	
	public function setOrder($param) {
		$this->_order = $param;
	}

	public function setLimit($param) {
		$this->_limit = $param;
	}

	public function setOffset($param) {
		$this->_offset = $param;
	}
	
	/*
	 * get detail: get results ARRAY_A || ARRAY_N || OBJECT || OBJECT_K 
	 */
	public function getList($type='OBJECT') {
		$select = $this->_select;
		$limit = $this->_limit;
		$offset = $this->_offset;

		$query = "";
		$query .= "SELECT {$select} FROM {$this->_table}";
		$query .= $this->where_query();
		$query .= $this->or_where_query();
		
		$inName = $this->_inName;
		if(!empty($inName)){
			$query .= $this->where_query_in_not($query, $inName, $this->_inValue, 'IN');
		}

		$notInName = $this->_notInName;
		if(!empty($notInName)){
			$query .= $this->where_query_in_not($query, $notInName, $this->_notInValue, 'NOT IN');
		}
		
		$likeName = $this->_likeName;
		if(!empty($likeName)){
			$query .= $this->where_query_like($query);
		}

		$groupBy = $this->_groupBy;
		if(!empty($groupBy)){
			$query .= " GROUP BY {$groupBy}";
		}

		$havingName = $this->_havingName;
		if(!empty($havingName)){
			$query .= $this->having_query();
		}
		
		$order = $this->_order;
		if(!empty($order)){
			$query .= " ORDER BY {$order}";
		}
		
		if($limit == 0){
			$query .= "";
		}else{
			if($offset>0){
				$query .= " LIMIT {$limit} OFFSET {$offset}";
			}else{
				$query .= " LIMIT {$limit}";
			}
		}
		
		$result = $this->_wpdb->get_results($query, $type);
		$this->reset_set();
		return $result;
	}
	
	/*
	 * get detail: get var
	 */
	public function getCount() {
		$select = $this->_select;
		
		$query = "";
		$query .= "SELECT {$select} FROM {$this->_table}";
		$query .= $this->where_query();

		$inName = $this->_inName;
		if(!empty($inName)){
			$query .= $this->where_query_in_not($query, $inName, $this->_inValue, 'IN');
		}

		$notInName = $this->_notInName;
		if(!empty($notInName)){
			$query .= $this->where_query_in_not($query, $notInName, $this->_notInValue, 'NOT IN');
		}

		$likeName = $this->_likeName;
		if(!empty($likeName)){
			$query .= $this->where_query_like($query);
		}

		$groupBy = $this->_groupBy;
		if(!empty($groupBy)){
			$query .= " GROUP BY {$groupBy}";
		}

		$havingName = $this->_havingName;
		if(!empty($havingName)){
			$query .= $this->having_query();
		}
		
		$result = $this->_wpdb->get_var($query);
		$this->reset_set();
		return $result;
	}
	/*
	 * get detail: get row
	 */
	public function getDetail() {
		$tbl_select = $this->_select;
		
		$query = "";
		$query .= "SELECT {$tbl_select} FROM {$this->_table}";
		$query .= $this->where_query();
		$query .= $this->or_where_query();
		$query .= " LIMIT 1";
		
		$result = $this->_wpdb->get_row($query);
		$this->reset_set();
		return $result;
	}
	/*
	 * customize: get results ARRAY_A || ARRAY_N || OBJECT || OBJECT_K 
	 */
	public function joinTable($type='OBJECT') {		
		$limit = $this->_limit;
		$offset = $this->_offset;

		$query = "";
		$query .= $this->_join;
		$query .= $this->where_query();
		$query .= $this->or_where_query();
		
		$inName = $this->_inName;
		if(!empty($inName)){
			$query .= $this->where_query_in_not($query, $inName, $this->_inValue, 'IN');
		}

		$notInName = $this->_notInName;
		if(!empty($notInName)){
			$query .= $this->where_query_in_not($query, $notInName, $this->_notInValue, 'NOT IN');
		}
		
		$likeName = $this->_likeName;
		if(!empty($likeName)){
			$query .= $this->where_query_like($query);
		}
		
		$groupBy = $this->_groupBy;
		if(!empty($groupBy)){
			$query .= " GROUP BY {$groupBy}";
		}

		$havingName = $this->_havingName;
		if(!empty($havingName)){
			$query .= $this->having_query();
		}
		
		$order = $this->_order;
		if(!empty($order)){
			$query .= " ORDER BY {$order}";
		}
		
		if($limit == 0){
			$query .= "";
		}else{
			if($offset>0){
				$query .= " LIMIT {$limit} OFFSET {$offset}";
			}else{
				$query .= " LIMIT {$limit}";
			}
		}
		
		$result = $this->_wpdb->get_results($query, $type);
		$this->reset_set();
		
		return $result;
	}
	/*
	 * get detail: get var
	 */
	public function joinTableCount() {		
		$query = "";
		$query .= $this->_join;
		$query .= $this->where_query();

		$inName = $this->_inName;
		if(!empty($inName)){
			$query .= $this->where_query_in_not($query, $inName, $this->_inValue, 'IN');
		}

		$notInName = $this->_notInName;
		if(!empty($notInName)){
			$query .= $this->where_query_in_not($query, $notInName, $this->_notInValue, 'NOT IN');
		}

		$likeName = $this->_likeName;
		if(!empty($likeName)){
			$query .= $this->where_query_like($query);
		}
		
		$havingName = $this->_havingName;
		if(!empty($havingName)){
			$query .= $this->having_query();
		}
		
		$result = $this->_wpdb->get_var($query);
		$this->reset_set();
		return $result;
	}
	
	public function joinTableDetail() {
		
		$query = "";
		$query .= $this->_join;
		$query .= $this->where_query();
		$query .= $this->or_where_query();
		$query .= " LIMIT 1";
		
		$result = $this->_wpdb->get_row($query);
		$this->reset_set();
		return $result;
	}
	/*
	 * create
	 */
	public function theCreate(array $_data=[]) {
		if(empty(count($_data))){
			return false;
		}

		$this->_wpdb->insert($this->_table, $_data);
		$result = $this->_wpdb->insert_id;
		$this->reset_set();
		return $result;
	}
	/*
	 * create Multi
	 */
	public function createMulti(array $_data=[]) {
		if(empty(count($_data))){
			return false;
		}
		
		foreach( $_data as $value ){
			$this->_wpdb->insert($this->_table, $value);
		}
		$this->reset_set();
		return true;
	}
	/*
	 * update Multi
	 */
	public function updateMulti(array $_data=[], array $_where=[]) {
		if(empty(count($_data)) && empty(count($_where))){
			return false;
		}
		
		foreach( $_data as $key => $value ){
			$this->_wpdb->update($this->_table, $value, $_where[$key]);
		}
		
		$this->reset_set();
		return true;
	}

	/*
	 * update
	 */
	public function theUpdate(array $_data=[], array $_where=[]) {
		if(empty(count($_data)) && empty(count($_where))){
			return false;
		}

		$this->_wpdb->update($this->_table, $_data, $_where);
		$this->reset_set();
		return true;
		
	}
	/*
	 * delete
	 */
	public function theDelete(array $_data = [])
	{
		if(empty($_data) || count($_data) < 1){
			return false;
		}

		$this->_wpdb->delete($this->_table, $_data);
		$this->reset_set();
		return true;
	}
	/*
	 * has Table
	 */
	public function hasTable() {
		if ($this->_wpdb->get_var('SHOW TABLES LIKE "'.($this->_table).'";') != $this->_table) {
			echo 'Database error';
			wp_die();
		}
	}
	/*
	 * Build query where
	 */
	private function where_query(){
		$cols = $this->_whereName;
		$value = $this->_whereValue;

		if(count($cols) < 1){
			return "";
		}

		$query = "";
		foreach ($cols as $key => $col) {

			if (!$this->has_operator($col)){
				$col = "{$col} =";
			}
			
			if ($key == 0) {
				$query .= " WHERE {$col}";
				
				if($value[0] !== ""){
					$query .= " '{$value[0]}'";
				}
				
				continue;
			}else{
				$query .= " AND {$col}";
				
				if($value[$key] !== ""){
					$query .= " '{$value[$key]}'";
				}
			}
		}
		
		return $query;
	}
	/*
	 * Build having query
	 */
	private function having_query(){
		$tbl = $this->_havingName;
		$val = $this->_havingValue;

		if(count($tbl) < 1){
			return "";
		}

		$query = "";
		foreach ($tbl as $i => $v) {
			if ($i == 0) {
				$query .= " HAVING {$v} '{$val[0]}'";
				continue;
			}else{
				$query .= " AND {$v} '{$val[$i]}'";
			}
		}

		return $query;
	}
	/*
	 * Build query where
	 */
	private function or_where_query(){
		$tbl = $this->_orWhereName;
		$val = $this->_orWhereValue;

		if(count($tbl) < 1){
			return "";
		}

		$query = "";
		foreach ($tbl as $i => $v) {

			if (!$this->has_operator($v)){
				$v = "{$v} =";
			}
			
			$query .= " OR {$v} '{$val[$i]}'";
		}

		return $query;
	}
	/*
	 * Build query not where
	 */
	private function where_query_in_not(string $_sql='', string $_tbl='', array $_val=[], string $_write=''){
		if(empty($_sql) && empty($_tbl) && empty($_write)){
			return "";
		}

		$count = count($_val);
		if($count < 1){
			return "";
		}

		$query = "";
		$_val = implode("','", $_val);
		$check_where = strpos($_sql, 'WHERE');

		if($check_where === false){
			$query .= " WHERE {$_tbl} {$_write} ('{$_val}')";
		}else{
			$query .= " AND {$_tbl} {$_write} ('{$_val}')";
		}

		return $query;
	}

	/*
	 * Build query where like
	 */
	private function where_query_like(string $_sql=''){
		$tbl = $this->_likeName;
		$val = $this->_likeValue;
		$type = $this->_likeType;
		$query = "";

		if(count($tbl) < 1){
			return $query;
		}

		$check_where = strpos($_sql, 'WHERE');

		if($check_where === false){
			foreach ($tbl as $i => $v) {
				if ($i == 0) {
					$query .= " WHERE {$v} LIKE '%{$val[0]}%'";
					continue;
				}else{
					$query .= " {$type} {$v} LIKE '%{$val[$i]}%'";
				}
			}
			return $query;
		}

		if(count($tbl) == 1){
			$query .= " AND ({$tbl[0]} LIKE '%{$val[0]}%')";
			return $query;
		}

		foreach ($tbl as $i => $v) {
			if ($i == 0) {
				$query .= " AND ({$v} LIKE '%{$val[0]}%'";
				continue;
			}else{
				$query .= " {$type} {$v} LIKE '%{$val[$i]}%')";
			}
		}
		
		return $query;
	}

	/*
	 * Has operator
	 */
	private function has_operator($str)
	{
		return (bool) preg_match('/(<|>|!|=|\sIS NULL|\sIS NOT NULL|\sEXISTS|\sBETWEEN|\sLIKE|\sIN\s*\(|\s)/i', trim($str));
	}
	/*
	 * Reset query
	 */
	private function reset_set(){
		$this->_table = '';
		$this->_select = '';
		$this->_whereName = array();
		$this->_whereValue = array();
		$this->_inName = '';
		$this->_inValue = array();
		$this->_notInName = '';
		$this->_notInValue = array();
		$this->_likeName = array();
		$this->_likeValue = array();
		$this->_likeType = '';
		$this->_groupBy = '';
		$this->_havingName = array();
		$this->_havingValue = array();
		$this->_order = '';
		$this->_limit = 0;
		$this->_offset = 0;
	}
}