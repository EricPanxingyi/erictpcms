<?php
namespace Admin\Controller;
use Think\Controller;

class IndexController extends CommonController {
    public function index() {
        $newsMax = D('News')->maxCount();
        $newsCount = D('News')->getNewsCount(array('status' => 1));
        $positionCount = D('Position')->getPositionsCount(array('status' => 1));
        $adminCount = D('Admin')->getLastLoginUsers();
        
        $this->assign('newsMax',$newsMax);
        $this->assign('newsCount',$newsCount);
        $this->assign('positionCount',$positionCount);
        $this->assign('adminCount',$adminCount);
        $this->display();
    }
}
