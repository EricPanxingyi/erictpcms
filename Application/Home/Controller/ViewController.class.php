<?php
namespace Home\Controller;
use Think\Controller;

class ViewController extends CommonController {
    public function index() {
        if ( getLoginName() ) {
            $news_id = intval($_REQUEST['id']);
            $news = D("News")->getNewsById($news_id);
            $newsContent = D("NewsContent")->getNewsContentById($news_id);
            $news['content'] = htmlspecialchars_decode($newsContent['content']);
            $this->assign("news", $news);
            $this->display();
        } else {
            return $this->error();
        }
    }
}