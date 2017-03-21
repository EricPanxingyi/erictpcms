<?php
namespace Common\Model;

use Think\Model;

class MenuModel extends Model {
    private $_db = '';
    public function __construct() {
        parent::__construct();
        $this->_db = M('menu');
    }

    /**
     * 添加数据
     * @param array $data
     * @return int
     */
    public function insert($data = array()) {
        if ( !$data || !is_array($data) ) return false;
        return $this->_db->add($data);
    }

    /**
     * 分页获取菜单信息
     * @param array $con
     * @param int $page
     * @param int $pagesize
     * @return array
     */
    public function getAllMenus($con = array(), $page, $pagesize) {
        $con['status'] = array('neq', -1);
        $offset = ($page - 1) * $pagesize;
        return $this->_db->where($con)->order('listorder DESC,menu_id DESC')->limit($offset,$pagesize)->select();
    }

    /**
     * 获取没有删除菜单数
     * @param array $con
     * @return int
     */
    public function getMenusCount($con = array()) {
        $con['status'] = array('neq', -1);
        return $this->_db->where($con)->count();
    }

    /**
     * 获取指定菜单信息
     * @param int $menu_id
     * @return array
     */
    public function getMenuById($menu_id) {
        if ( !$menu_id || !is_numeric($menu_id) ) return false;
        $con['menu_id'] = $menu_id;
        return $this->_db->where($con)->find();
    }

    /**
     * 更新制定菜单信息
     * @param array $data
     * @param int $menu_id
     * @return bool
     */
    public function updateMenuById($menu_id, $data) {
        if ( !$data || !is_array($data) ) throw_exception('更新数据不合法');
        if ( !$menu_id || !is_numeric($menu_id) ) throw_exception('菜单id不合法');
        $con['menu_id'] = $menu_id;
        return $this->_db->where($con)->save($data);
    }

    /**
     * 更新菜单状态
     * @param int $menu_id
     * @param int $status
     * @return bool
     */
    public function updateMenuStatus($menu_id, $status) {
        if ( !$menu_id || !is_numeric($menu_id) ) throw_exception('菜单id不合法');
        if ( !is_numeric($status) ) throw_exception('更新的状态不合法');
        $con['menu_id'] = $menu_id;
        $data['status'] = $status;
        return $this->_db->where($con)->save($data);
    }
    
    /**
     * 更新菜单排序
     * @param int $menu_id
     * @param int $value
     * @return bool
     */
    public function updateMenuListorder($menu_id, $value) {
        if ( !$menu_id || !is_numeric($menu_id) ) throw_exception('菜单id不合法');
        if ( !is_numeric($value) ) throw_exception('排序值不合法');
        $con['menu_id'] = $menu_id;
        $data['listorder'] = intval($value);
        return $this->_db->where($con)->save($data);
    }

    /**
     * 获取后台菜单
     * @return array
     */
    public function getMenusNav() {
        $con = array(
            'status' => array('neq', -1),
            'type' => 1,
        );
        return $this->_db->where($con)->order("listorder DESC")->select();
    }

    /**
     * 获取前台栏目
     * @return array
     */
    public function getHomeNav() {
        $con = array(
            'status' => array('neq', -1),
            'type' => 0,
        );
        return $this->_db->where($con)->select();
    }

    /**
     * 获取指定id前台栏目信息
     * @param int $catId
     * @return array
     */
    public function getHomeMenuById($catId) {
        if ( !$catId || !is_numeric($catId) ) return false;
        $cond['type'] = 0;
        $cond['menu_id'] = $catId;
        return $this->_db->where($cond)->find();
    }
}