<?php
namespace Home\Controller;
use Think\Controller;

class CommonController extends Controller {
    public function __construct() {
        parent::__construct();
        header("Content-type:text/html;charset=utf-8");
    }
    
    public function getRank() {
        $cond['status'] = 1;
        $rankContents = D("News")->getNewsRank($cond, 10);
        return $rankContents;
    }

    public function getAdPic() {
        $indexAdPic = D("PositionContent")->getSelectedPositionContents(array('status' => 1, 'position_id' => 1), 2);
        return $indexAdPic;
    }
    
    public function error() {
        $this->display("Common/error");
    }
}