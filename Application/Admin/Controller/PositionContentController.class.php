<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

class PositionContentController extends CommonController {
    public function index() {
        $data['status'] = array('neq', -1);
        $positions = D("Position")->getPositionNav();
        if ( $_GET['position_id'] ) {
            $data['position_id'] = intval($_GET['position_id']);
            $this->assign("posId", $data['position_id']);
        } else {
            $this->assign("posId", -1);
        }
        if ( $_GET['title'] ) {
            $data['title'] = $_GET['title'];
            $this->assign("title", $data['title']);
        } else {
            $this->assign("title", "文章标题");
        }
        
        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = $_REQUEST['pageSize'] ? $_REQUEST['pageSize'] : 10;
        $positionContents = D("PositionContent")->getAllPositionContents($data, $page, $pageSize);
        $positionCount = D("PositionContent")->getPositionContentsCount($data);
        $res = new \Think\Page($positionCount, $pageSize);
        $pageRes = $res->show();
        
        $this->assign("positionContents", $positionContents);
        $this->assign("pageRes", $pageRes);
        $this->assign("positions", $positions);
        $this->display();
    }

    public function add() {
        if ( $_POST ) {
            if ( !isset($_POST['title']) || !$_POST['title'] ) return show(0, "标题不能为空");
            if ( !isset($_POST['position_id']) || !$_POST['position_id'] ) return show(0, "推荐位不能为空");
            if ( !isset($_POST['url']) && !isset($_POST['news_id']) ) return show(0, "链接和新闻id不能同时为空");
            if ( !isset($_POST['thumb']) || !$_POST['thumb'] ) {
                if ( $_POST['news_id'] ) {
                    $res = D("News")->getNewsById($_POST['news_id']);
                    if ( $res && $res['thumb'] ) {
                        $_POST['thumb'] = $res['thumb'];
                    } else {
                        return show(0, "缩图不能为空");
                    }
                } else {
                    return show(0, "缩图不能为空");
                }
            }
            if ( $_POST['id'] ) {
                $this->save($_POST);
            }
            $result = D("PositionContent")->insert($_POST);
            if ( $result ) {
                return show(1, "新增成功");
            } else {
                return show(0, "新增失败");
            }
        } else {
            $positions = D("Position")->getPositionNav();
            $this->assign("positions", $positions);
            $this->display();
        }
    }

    public function edit() {
        $positions = D("Position")->getPositionNav();
        $id = $_REQUEST['id'];
        $positionContent = D("PositionContent")->getPositionContentById($id);
        $this->assign("positionContent", $positionContent);
        $this->assign("positions", $positions);
        $this->display();
    }

    public function save($data) {
        $id = $data['id'];
        unset($data['id']);
        try {
            $res = D("PositionContent")->updatePositionContent($id, $data);
            if ( $res ) {
                return show(1, "更新成功");
            } else {
                return show(0, "更新失败");
            }
        } catch ( Exception $e ) {
            return show(0, $e->getMessage());
        }
    }

    public function setStatus() {
        try {
            if ( $_POST ) {
                $id = $_POST['id'];
                $status = $_POST['status'];
                $res = D("PositionContent")->updatePositionContentStatus($id, $status);
                if ($res) {
                    return show(1, "操作成功");
                } else {
                    return show(0, "操作失败");
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
        $error = array();
        $jump_url = $_SERVER['HTTP_REFERER'];
        try {
            foreach ( $listorder as $id => $value ) {
                $res = D("PositionContent")->updatePositionContentListorder($id, $value);
                if ( $res === false ) $error[] = $id;
            }
            if ( $error ) {
                return show(0, "排序失败-id:".implode(",", $error), array("jump_url" => $jump_url));
            } else {
                return show(1, "排序成功", array("jump_url" => $jump_url));
            }
        } catch ( Exception $e ) {
            return show(0, $e->getMessage(), array("jump_url" => $jump_url));
        }
    }
}