<?php
/*
 * 出处：大-叔-来
 * 官网: Www.dashulai.com
 * 备用网址: www.dashulai.Com (请收藏备用!)
 * 本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 * 技术支持/更新维护：QQ 986692927
 * 
 */
if (!defined('IN_DISCUZ')) {
    exit('Aecsse Denied');
}
class table_zhikai_smslog extends discuz_table{
    public function __construct() {
        $this->_table = 'zhikai_smslog';
        $this->_pk = 'id';
        parent::__construct();
    }

    public function get_zhikai_smslog_count($where = null){
        $sql = "SELECT count(*) as count FROM %t WHERE 1";
        $condition[] = $this->_table;
        if($where['id']){     
            $sql .=" AND id=%d ";
            $condition[] = $where['id'];
        }
		if($where['uid']){
            $sql .=" AND uid=%d ";
            $condition[] = $where['uid'];
        }
		if($where['mobile']){
            $sql .=" AND mobile=%d ";
            $condition[] = $where['mobile'];
        }
		if($where['send_state']){//发送状态
            $sql .=" AND send_state=%d ";
            $condition[] = $where['send_state'];
        }
		if($where['send_type']){
            $sql .=" AND send_type=%d ";
            $condition[] = $where['send_type'];
        }
		if($where['smscode']){
            $sql .=" AND smscode=%d ";
            $condition[] = $where['smscode'];
        }
		if($where['verify_state']){//完成状态 
            $sql .=" AND verify_state=%d ";
            $condition[] = $where['verify_state'];
        }
		if($where['send_date']){//发送时间
            $sql .=" AND send_date=%d ";
            $condition[] = $where['send_date'];
        }
		if($where['send_date1']){
            $sql .=" AND send_date>%d ";
            $condition[] = $where['send_date1'];
        }
		if($where['send_date2']){
            $sql .=" AND send_date<%d ";
            $condition[] = $where['send_date2'];
        }
        $count = DB::fetch_first($sql,$condition);
        return $count['count'];
    }

	public function get_zhikai_smslog_list($start,$size,$where = null){
		$sql = "SELECT * FROM %t WHERE 1";
		$condition[] = $this->_table;
        if($where['id']){     
            $sql .=" AND id=%d ";
            $condition[] = $where['id'];
        }
		if($where['uid']){
            $sql .=" AND uid=%d ";
            $condition[] = $where['uid'];
        }
		if($where['mobile']){
            $sql .=" AND mobile=%d ";
            $condition[] = $where['mobile'];
        }
		if($where['send_state']){//发送状态
            $sql .=" AND send_state=%d ";
            $condition[] = $where['send_state'];
        }
		if($where['send_type']){
            $sql .=" AND send_type=%d ";
            $condition[] = $where['send_type'];
        }
		if($where['smscode']){
            $sql .=" AND smscode=%d ";
            $condition[] = $where['smscode'];
        }
		if($where['verify_state']){//完成状态 
            $sql .=" AND verify_state=%d ";
            $condition[] = $where['verify_state'];
        }
		if($where['send_date']){//发送时间
            $sql .=" AND send_date=%d ";
            $condition[] = $where['send_date'];
        }
		if($where['send_date1']){
            $sql .=" AND send_date>%d ";
            $condition[] = $where['send_date1'];
        }
		if($where['send_date2']){
            $sql .=" AND send_date<%d ";
            $condition[] = $where['send_date2'];
        }
		$sql .= " ORDER BY id DESC LIMIT %d,%d ";
		$condition[] = $start;
		$condition[] = $size;
		return DB::fetch_all($sql,$condition);
	}

    public function insert($data){
        return DB::insert($this->_table,$data,true);
    }
	
    public function update($data,$condition){
        return DB::update($this->_table,$data,$condition,true);
    }
	
    public function delete($condition){
        return DB::delete($this->_table, $condition);
    }
	
	public function get_zhikai_smslog_first($where){
		$sql = "SELECT * FROM %t WHERE 1";
		$condition[] = $this->_table;
        if($where['id']){     
            $sql .=" AND id=%d ";
            $condition[] = $where['id'];
        }
		if($where['uid']){
            $sql .=" AND uid=%d ";
            $condition[] = $where['uid'];
        }
		if($where['mobile']){
            $sql .=" AND mobile=%d ";
            $condition[] = $where['mobile'];
        }
		if($where['send_state']){//发送状态
            $sql .=" AND send_state=%d ";
            $condition[] = $where['send_state'];
        }
		if($where['send_type']){
            $sql .=" AND send_type=%d ";
            $condition[] = $where['send_type'];
        }
		if($where['smscode']){
            $sql .=" AND smscode=%d ";
            $condition[] = $where['smscode'];
        }
		if($where['verify_state']){//完成状态 
            $sql .=" AND verify_state=%d ";
            $condition[] = $where['verify_state'];
        }
		if($where['send_date']){//发送时间
            $sql .=" AND send_date=%d ";
            $condition[] = $where['send_date'];
        }
		return DB::fetch_first($sql,$condition);
	}
}
//From:www_dashulai.com
?>