<?php
namespace Home\Controller;
use Think\Controller;

class DetailController extends CommonController {
    public function index() {
        $news_id = intval($_GET['id']);
        if ( !$news_id ) {
            return $this->error();
        }
        $news = D("News")->getNewsById($news_id);
        if ( !$news || $news['status'] != 1 ) {
            return $this->error();
        }

        $count = intval($news['count'] + 1);
        D("News")->updateCount($news_id, $count);

        $newsContent = D("NewsContent")->getNewsContentById($news_id);
        $news['content'] = htmlspecialchars_decode($newsContent['content']);
        //右侧广告位
        $indexAdPic = $this->getAdPic();
        //排行榜新闻
        $rankNews = $this->getRank();

        $this->assign("result", array(
            "indexAdPic" => $indexAdPic,
            "rankNews" => $rankNews,
            "news" => $news
        ));
        $this->display();
    }
}