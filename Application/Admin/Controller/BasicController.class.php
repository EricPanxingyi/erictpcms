<?php
namespace Admin\Controller;
use Think\Controller;

class BasicController extends CommonController {
    public function index() {
        $webCache = D("Basic")->readCache();
        $this->assign("webCache", $webCache);
        $this->assign("type", 1);
        $this->display();
    }
    
    public function add() {
        if ( $_POST ) {
            if ( !$_POST['title'] || !isset($_POST['title']) ) return show(0, "站点标题不能为空");
            if ( !$_POST['keywords'] || !isset($_POST['keywords']) ) return show(0, "站点关键词不能为空");
            if ( !$_POST['description'] || !isset($_POST['description']) ) return show(0, "站点描述不能为空");

            D("Basic")->saveCache($_POST);
            return show(1, "配置成功");
        } else {
            return show(0, "没有数据输入");
        }
    }

    public function cache() {
        $this->assign("type", 2);
        $this->display();
    }
}