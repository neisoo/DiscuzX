<?php

/**
 *      [zzb7taobao!] (C)2009-2019 zZb7.taobao.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_mobile_setting.php 31700 2012-09-24 03:46:59Z ZZb7.taobao.com $
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_qidou_assign_item extends discuz_table {

    public function __construct() {
        $this->_table = 'qidou_assign_item';
        $this->_pk = 'id';

        parent::__construct();
    }

    /**
     * 检测表
     */
    public function checktable($table) {
        return mysql_num_rows(mysql_query("SHOW TABLES LIKE '" . $table . "'"));
    }

    public function fetch($uid) {
        return DB::fetch_first('SELECT * FROM %t WHERE uid=%s', array($this->_table, $uid));
    }

    public function insert($data, $return_insert_id = false, $replace = false, $silent = false) {
        if (!is_array($data)) {
            return;
        }
        return parent::insert($data, $return_insert_id, $replace, $silent);
    }
    public function update( $data,$condition ){
        return DB::update($this->_table, $data,$condition,true);
    }
    public function fetch_all($skeyarr) {
        if (!empty($skeyarr)) {
            return array();
        }
        $return = array();
        $query = DB::query('SELECT * FROM %t WHERE ' . DB::field($this->_pk, $skeyarr), array($this->_table));
        while ($svalue = DB::fetch($query)) {
            $return[$svalue['skey']] = $svalue['svalue'];
        }
        return $return;
    }

    public function fetch_list() {
        $date = date('Y-m-d');
        return DB::fetch_all("SELECT * FROM %t WHERE totaltian>0  and signdate = '".$date."' order by signtime asc limit 0,99", array($this->_table));
    }

    public function fetch_list1() {
        return DB::fetch_all('SELECT * FROM %t WHERE totaltian>0  order by totaltian desc limit 0,99', array($this->_table));
    }
    
    public function record($start, $limit) {
        $sql = 'SELECT * FROM ' . DB::table($this->_table) . '  order by id desc limit ' . $start . ',' . $limit;
        return DB::fetch_all($sql);
    }
    public function tongji($days = false) {
        if($days){
            $date = date('Y-m-d');
          
            return  DB::fetch_first("SELECT COUNT(*) as num FROM %t WHERE  signdate = ' ".$date."'", array($this->_table));
            
        }else{
            $date = date("Y-m-d",strtotime("-1 day"));
            return DB::fetch_first("SELECT COUNT(*) as num FROM %t WHERE  date LIKE  %s or bu_date LIKE  %s", array($this->_table,'%'.$date.'%','%'.$date.'%'));
        }
        
    }

}
