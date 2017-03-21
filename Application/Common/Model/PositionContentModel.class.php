<?php
namespace Common\Model;

use Think\Model;

class PositionContentModel extends Model {
    private $_db;
    public function __construct() {
        parent::__construct();
        $this->_db = M("position_content");
    }

    /**
     * 新增推荐位内容
     * @param array $data
     * @return int
     */
    public function insert($data) {
        if ( !$data || !is_array($data) ) return false;
        if ( !isset($data['create_time']) || !$data['create_time'] ) $data['create_time'] = time();
        if ( !isset($data['update_time']) || !$data['update_time'] ) $data['update_time'] = time();
        return $this->_db->add($data);
    }

    /**
     * 分页获取所有推荐位的内容
     * @param array $cond
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public function getAllPositionContents($cond = array(), $page, $pageSize) {
        $offset = ($page - 1) * $pageSize;
        if ( $cond['title'] ) {
            $title = $cond['title'];
            $cond['title'] = array('like', "%".$title."%");
        }
        return $this->_db->where($cond)->order('listorder DESC, id DESC')->limit($offset, $pageSize)->select();
    }

    /**
     * 根据指定条件获取所需推荐位内容
     * @param array $cond
     * @param int $limit
     * @return array
     */
    public function getSelectedPositionContents($cond, $limit) {
        if ( !$cond || !is_array($cond) ) return false;
        if ( !$limit || !is_numeric($limit) ) return false;
        return $this->_db->where($cond)->order('listorder DESC, id DESC')->limit($limit)->select();
    }

    /**
     * 获取推荐位条数
     * @param array $cond
     * @return int
     */
    public function getPositionContentsCount($cond = array()) {
        if ( $cond['title'] ) {
            $title = $cond['title'];
            $cond['title'] = array('like', "%".$title."%");
        }
        return $this->_db->where($cond)->count();
    }

    /**
     * 获取指定id的推荐位内容
     * @param int $id
     * @return array
     */
    public function getPositionContentById($id) {
        if ( !$id || !is_numeric($id) ) return false;
        $cond['id'] = $id;
        return $this->_db->where($cond)->find();
    }

    /**
     * 更新指定id推荐位内容
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updatePositionContent($id, $data) {
        if ( !$id || !is_numeric($id) ) throw_exception('文章id不合法');
        if ( !$data || !is_array($data) ) throw_exception('更新数据不合法');
        $cond['id'] = $id;
        $data['update_time'] = time();
        return $this->_db->where($cond)->save($data);
    }

    /**
     * 更改指定id推荐位内容状态
     * @param int $id
     * @param int $status
     * @return bool
     */
    public function updatePositionContentStatus($id, $status) {
        if ( !$id || !is_numeric($id) ) throw_exception('文章id不合法');
        if ( !is_numeric($status) ) throw_exception('状态参数值不合法');
        $cond['id'] = $id;
        $data['status'] = $status;
        return $this->_db->where($cond)->save($data);
    }

    /**
     * 更新推荐位内容排序
     * @param int $id
     * @param int $value
     * @return bool
     */
    public function updatePositionContentListorder($id, $value) {
        if ( !$id || !is_numeric($id) ) throw_exception('文章id不合法');
        if ( !is_numeric($value) ) throw_exception('排序值不合法');
        $cond['id'] = $id;
        $data['listorder'] = $value;
        return $this->_db->where($cond)->save($data);
    }
}