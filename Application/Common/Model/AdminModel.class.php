<?php
namespace Common\Model;
use Think\Model;

class AdminModel extends Model {
    private $_db = '';
    public function __construct() {
        parent::__construct();
        $this->_db = M('admin');
    }

    /**
     * 获取指定用户名的信息
     * @param $username
     * @return array
     */
    public function getAdminByUsername($username) {
        $cond['username'] = $username;
        return $this->_db->where($cond)->find();
    }

    /**
     * 新增用户
     * @param array $data
     * @return int
     */
    public function insert($data) {
        if ( !$data || !is_array($data) ) return false;
        return $this->_db->add($data);
    }

    /**
     * 获取所有用户
     * @return array
     */
    public function getAllAdmins() {
        $cond['status'] = array('neq', -1);
        return $this->_db->where($cond)->select();
    }

    /**
     * 获取指定用户信息
     * @param int $adminId
     * @return array
     */
    public function getAdminById($adminId) {
        if ( !$adminId || !is_numeric($adminId) ) return false;
        $cond['admin_id'] = $adminId;
        return $this->_db->where($cond)->find();
    }

    /**
     * 更新用户状态
     * @param int $adminId
     * @param int $status
     * @return bool
     */
    public function updateAdminStatus($adminId, $status) {
        if ( !$adminId || !is_numeric($adminId) ) throw_exception("用户id不合法");
        if ( !$status ) throw_exception("状态参数不合法");
        $cond['admin_id'] = $adminId;
        $data['status'] = $status;
        return $this->_db->where($cond)->save($data);
    }

    /**
     * 更新登录信息
     * @param int $adminId
     * @param int $ip
     * @return bool
     */
    public function updateLoginInfo($adminId, $ip) {
        if ( !$adminId || !is_numeric($adminId) ) throw_exception("用户id不合法");
        if ( !$ip ) throw_exception("ip不合法");
        $cond['admin_id'] = $adminId;
        $data['lastloginip'] = $ip;
        $data['lastlogintime'] = time();
        return $this->_db->where($cond)->save($data);
    }

    /**
     * 更新用户信息
     * @param int $adminId
     * @param array $data
     * @return bool
     */
    public function updateInfoByAdminId($adminId, $data) {
        if ( !$adminId || !is_numeric($adminId) ) throw_exception("用户id不合法");
        if ( !$data || !is_array($data) ) throw_exception("保存数据不合法");
        $cond['admin_id'] = $adminId;
        return $this->_db->where($cond)->save($data);
    }

    /**
     * 获取今日登录用户数
     * @return int
     */
    public function getLastLoginUsers(){
        $time = mktime(0,0,0,date("m"),date("d"),date("Y"));
        $cond = array(
            'status' => 1,
            'lastlogintime' => array("gt",$time),
        );
        return $this->_db->where($cond)->count();
    }
}