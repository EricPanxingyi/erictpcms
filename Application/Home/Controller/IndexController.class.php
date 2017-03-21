<?php
namespace Home\Controller;
use Think\Controller;
use Think\Exception;

class IndexController extends CommonController {
    public function index($type = '') {
        //首页大图
        $indexBigPic = D("PositionContent")->getSelectedPositionContents(array('status' => 1, 'position_id' => 3), 1);
        $indexBigPicCat = D("News")->getNewsById($indexBigPic[0]['news_id']);
        $indexBigPic[0]['catid'] = $indexBigPicCat['catid'];
        //首页小图
        $indexSmallPic = D("PositionContent")->getSelectedPositionContents(array('status' => 1, 'position_id' => 2), 3);
        foreach ( $indexSmallPic as $k => $v ) {
            $cat = D("News")->getNewsById($v['news_id']);
            $indexSmallPic[$k]['catid'] = $cat['catid'];
        }
        //右侧广告位
        $indexAdPic = $this->getAdPic();
        //首页新闻
//        $page = $_REQUEST['pageNum'] ? $_REQUEST['pageNum'] : 1;
//        $pageSize = 3;
//        $indexNews = D("News")->getAllNews(array('status' => 1), $page, $pageSize);
        //排行榜新闻
        $rankNews = $this->getRank();

        $this->assign("result", array(
            "indexBigPic" => $indexBigPic,
            "indexSmallPic" => $indexSmallPic,
            "indexAdPic" => $indexAdPic,
//            "indexNews" => $indexNews,
            "rankNews" => $rankNews
        ));

        if ( $type == 'buildHtml' ) {
            $this->buildHtml('index', HTML_PATH, 'Index/index');
        } else {
            $this->display();
        }
    }

    public function getAjaxMore() {
        $page = intval($_POST['pageNum']);
        $pageSize = 3;
        $newsCount = D('News')->getNewsCount();
        $totalPage = ceil($newsCount / $pageSize);
        $startPage = ($page - 1) * $pageSize;
        $news = D("News")->getAllAjaxNews(array('status' => 1), $startPage, $pageSize);
        $data['total'] = $newsCount;
        $data['pageSize'] = $pageSize;
        $data['totalPage'] = $totalPage;
        foreach ( $news as $k => $v ) {
            $data['list'][] = array(
                'news_id' => $v['news_id'],
                'title' => $v['title'],
                'catid' => $v['catid'],
                'thumb' => isPicEmpty($v['thumb']),
                'description' => msubstr($v['description'], 0, 66, "utf-8", true),
                'keywords' => $v['keywords'],
                'create_time' => date("Y-m-d H:i:s", $v['create_time']),
                'count' => $v['count']
            );
        }
        echo json_encode($data);
    }
    
    public function build_html() {
        $this->index("buildHtml");
        return show(1, "首页生成成功");
    }

    public function getCount() {
        if ( !$_POST ) return show(0, "没有任何内容");
        $newsIds = array_unique($_POST);
        try {
            $newslists = D("News")->getNewsByIds($newsIds);
        } catch ( Exception $e ) {
            return show(0, $e->getMessage());
        }
        if ( !$newslists ) return show(0, "没有任何内容");
        $data = array();
        foreach ( $newslists as $k => $v ) {
            $data[$v['news_id']] = $v['count'];
        }
        return show(1, "success", $data);
    }
}