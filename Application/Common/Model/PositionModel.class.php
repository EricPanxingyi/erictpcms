<?php
namespace Common\Model;

use Think\Model;

class PositionModel extends Model {
    private $_db = '';
    public function __construct() {
        parent::__construct();
        $this->_db = M('position');
    }

    /**
     * 新增推荐位
     * @param array $data
     * @return int
     */
    public function insert($data) {
        if ( !$data || !is_array($data) ) return false;
        $data['create_time'] = time();
        $data['update_time'] = time();
        return $this->_db->add($data);
    }

    /**
     * 分页获取推荐位
     * @param array $cond
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public function getAllPositions($cond, $page, $pageSize) {
        $offset = ($page - 1) * $pageSize;
        $cond['status'] = array('neq', -1);
        return $this->_db->where($cond)->order('id DESC')->limit($offset,$pageSize)->select();
    }

    /**
     * 获取指定id的推荐位
     * @param int $posId
     * @return array
     */
    public function getPositionById($posId) {
        if ( !$posId || !is_numeric($posId) ) return false;
        $cond['id'] = $posId;
        return $this->_db->where($cond)->find();
    }

    /**
     * 获取推荐位总数
     * @param array $cond
     * @return int
     */
    public function getPositionsCount($cond) {
        return $this->_db->where($cond)->count();
    }

    /**
     * 更新推荐位信息
     * @param int $posId
     * @param array $data
     * @return bool
     */
    public function updatePosition($posId, $data) {
        if ( !$data || !is_array($data) ) throw_exception('更新数据不合法');
        if ( !$posId || !is_numeric($posId) ) throw_exception('推荐位id不合法');
        $cond['id'] = $posId;
        $data['update_time'] = time();
        return $this->_db->where($cond)->save($data);
    }

    /**
     * 更新推荐位状态
     * @param int $posId
     * @param int $status
     * @return bool
     */
    public function updatePositionStatus($posId, $status) {
        if ( !$posId || !is_numeric($posId) ) throw_exception('推荐位id不合法');
        if ( !is_numeric($status) ) throw_exception('状态参数不合法');
        $cond['id'] = $posId;
        $data['status'] = $status;
        return $this->_db->where($cond)->save($data);
    }

    /**
     * 获取推荐位导航
     * @return array
     */
    public function getPositionNav() {
        $cond['status'] = array('neq', -1);
        return $this->_db->where($cond)->select();
    }
}