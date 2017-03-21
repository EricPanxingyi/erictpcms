<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

class PositionController extends CommonController {
    public function index() {
        $data['status'] = array('neq', -1);
        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = $_REQUEST['pageSize'] ? $_REQUEST['pageSize'] : 10;
        $positions = D('Position')->getAllPositions($data, $page, $pageSize);
        $posCount = D('Position')->getPositionsCount($data);
        $res = new \Think\Page($posCount, $pageSize);
        $pageShow = $res->show();
        $this->assign('positions', $positions);
        $this->assign('pageShow', $pageShow);
        $this->display();
    }

    public function add() {
        if ( $_POST ) {
            if ( !$_POST['name'] || !isset($_POST['name']) ) return show(0, "推荐位名称不能为空");
            if ( $_POST['id'] ) {
                $this->save($_POST);
            }
            $res = D('Position')->insert($_POST);
            if ( !$res ) {
                return show(0, '新增失败');
            } else {
                return show(1, '新增成功');
            }
        } else {
            $this->display();
        }
    }

    public function edit() {
        $posId = $_REQUEST['id'];
        $position = D('Position')->getPositionById($posId);
        $this->assign("position", $position);
        $this->display();
    }

    public function save($data) {
        $posId = $data['id'];
        unset($data['id']);
        try {
            $res = D('Position')->updatePosition($posId, $data);
            if ( $res === false ) {
                return show(0, '更新失败');
            } else {
                return show(1, '更新成功');
            }
        } catch ( Exception $e ) {
            return show(0, $e->getMessage());
        }
    }

    public function setStatus() {
        try {
            if ( $_POST ) {
                $posId = $_POST['id'];
                $status = $_POST['status'];
                $res = D('Position')->updatePositionStatus($posId, $status);
                if ($res === false) {
                    return show(0, '操作失败');
                } else {
                    return show(1, '操作成功');
                }
            } else {
                return show(0, "没有获取到数据");
            }
        } catch (Exception $e) {
            return show(0, $e->getMessage());
        }
    }
}