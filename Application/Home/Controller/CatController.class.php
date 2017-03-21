<?php
namespace Home\Controller;
use Think\Controller;

class CatController extends CommonController {
    public function index() {
        $catId = intval($_GET['id']);
        if ( !$catId ) {;
            return $this->error();
        }
        $menu = D("Menu")->getHomeMenuById($catId);
        if ( !$menu || $menu['status'] != 1 ) {
            return $this->error();
        }
        //右侧广告位
        $indexAdPic = $this->getAdPic();
        //排行榜新闻
        $rankNews = $this->getRank();
        //分页获取新闻内容
        $cond = array(
            "status" => 1,
            "catid" => $catId
        );
        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = $_REQUEST['pageSize'] ? $_REQUEST['pageSize'] : 10;
        $news = D("News")->getAllNews($cond, $page, $pageSize);
        $newsCount = D("News")->getNewsCount($cond);
        $res = New \Think\Page($newsCount, $pageSize);
        $pageShow = $res->show();

        $this->assign("result", array(
            "indexAdPic" => $indexAdPic,
            "rankNews" => $rankNews,
            "news" => $news,
            "pageShow" =>$pageShow
        ));
        $this->display();
    }
}