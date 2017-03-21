<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

class MenuController extends CommonController {
    public function index() {
        $data = array();
        if ( isset($_REQUEST['type']) && in_array($_REQUEST['type'], array(0,1)) ) {
            $data['type'] = $_REQUEST['type'];
            $this->assign('type', $data['type']);
        } else {
            $this->assign('type', -1);
        }
        //分页
        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = $_REQUEST['pageSize'] ? $_REQUEST['pageSize'] : 10;
        $menus = D('Menu')->getAllMenus($data, $page, $pageSize);
        $menusCount = D('Menu')->getMenusCount($data);
        $res = new \Think\Page($menusCount, $pageSize);
        $pageShow = $res->show();
        $this->assign('menus', $menus);
        $this->assign('pageShow', $pageShow);
        $this->display();
    }

    public function add() {
        if ( $_POST ) {
            if ( !isset($_POST['name']) || !$_POST['name'] ) return show(0, '菜单名不能为空');
            if ( !isset($_POST['m']) || !$_POST['m'] ) return show(0, '模块名不能为空');
            if ( !isset($_POST['c']) || !$_POST['c'] ) return show(0, '控制器名不能为空');
            if ( !isset($_POST['f']) || !$_POST['f'] ) return show(0, '方法名不能为空');
            if ( $_POST['menu_id'] ) {
                return $this->save($_POST);
            } else {
                $res = D('Menu')->insert($_POST);
            }
            if ( $res !== false ) {
                return show(1, '添加成功');
            }  else {
                return show(0, '添加失败');
            }
        } else {
            $this->display();
        }
    }

    public function edit() {
        $menu_id = $_REQUEST['id'];
        $menu = D("Menu")->getMenuById($menu_id);
        $this->assign('menu', $menu);
        $this->display();
    }

    public function save($data) {
        $menu_id = $data['menu_id'];
        unset($data['menu_id']);
        try {
            $res = D("Menu")->updateMenuById($menu_id, $data);
            if ( $res === false ) {
                return show(0, "更新失败");
            } else {
                return show(1, "更新成功");
            }
        } catch ( Exception $e ) {
            return show(0, $e->getMessage());
        }
    }

    public function setStatus() {
        try {
            if ( $_POST ) {
                $menu_id = $_POST['id'];
                $status = $_POST['status'];
                $res = D("Menu")->updateMenuStatus($menu_id, $status);
                if ($res === false) {
                    return show(0, "操作失败");
                } else {
                    return show(1, "操作成功");
                }
            } else {
                return show(0, "没有获取操作数据");
            }
        } catch ( Exception $e ) {
            return show(0, $e->getMessage());
        }
    }

    public function listorder() {
        $listorder = $_POST['listorder'];
        $jump_url = $_SERVER['HTTP_REFERER'];
        $error = array();
        if ( $listorder ) {
            try {
                foreach ( $listorder as $menu_id => $value ) {
                    $res = D("Menu")->updateMenuListorder($menu_id, $value);
                    if ($res === false) $error[] = $menu_id;
                }
            } catch ( Exception $e ) {
                return show(0, $e->getMessage(), array('jump_url' => $jump_url));
            }
            if ( $error ) {
                return show(0, '排序失败-id:' . implode(',', $error), array('jump_url' => $jump_url));
            } else {
                return show(1, '排序成功', array('jump_url' => $jump_url));
            }
        } else {
            return show(0, '更新排序失败', array('jump_url' => $jump_url));
        }
    }
}