<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

class ContentController extends CommonController {
    public function index() {
        $cond['status'] = array('neq', -1);
        $menus = D("Menu")->getHomeNav();
        $positions = D("Position")->getPositionNav();
        if ( $_GET['catid'] ) {
            $cond['catid'] = intval($_GET['catid']);
            $this->assign('catid', $cond['catid']);
        } else {
            $this->assign('catid', -1);
        }
        if ( $_GET['title'] ) {
            $cond['title'] = $_GET['title'];
            $this->assign('title', $cond['title']);
        } else {
            $this->assign('title', '文章标题');
        }
        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = $_REQUEST['pageSize'] ? $_REQUEST['pageSize'] : 10;
        $news = D('News')->getAllNews($cond, $page, $pageSize);
        $newsCount = D('News')->getNewsCount($cond);
        $res = new \Think\Page($newsCount, $pageSize);
        $pageShow = $res->show();

        $this->assign("positions", $positions);
        $this->assign('menus', $menus);
        $this->assign('news', $news);
        $this->assign('pageShow', $pageShow);
        $this->display();
    }
    
    public function add() {
        if ( $_POST ) {
            if ( !isset($_POST['title']) || !$_POST['title'] ) return show(0, '文章标题不能为空');
            if ( !isset($_POST['small_title']) || !$_POST['small_title'] ) return show(0, '文章短标题不能为空');
            if ( !isset($_POST['catid']) || !$_POST['catid'] ) return show(0, '文章栏目不能为空');
            if ( !isset($_POST['content']) || !$_POST['content'] ) return show(0, '文章内容不能为空');
            if ( !isset($_POST['description']) || !$_POST['description'] ) return show(0, '文章描述不能为空');
            if ( !isset($_POST['keywords']) || !$_POST['keywords'] ) return show(0, '文章关键词不能为空');

            if ( $_POST['news_id'] ) {
                return $this->save($_POST);
            }
            $news_id = D("News")->insert($_POST);
            if ( $news_id ) {
                $data = array(
                    "news_id" => $news_id,
                    "content" => $_POST['content'],
                );
                $content_id = D("NewsContent")->insert($data);
                if ( $content_id ) {
                    return show(1, "新增文章成功");
                } else {
                    return show(1, "新增文章成功，但添加文章内容失败");
                }
            } else {
                return show(0, "新增文章失败");
            }
        } else {
            $menus = D("Menu")->getHomeNav();
            $title_color = C("TITLE_FONT_COLOR");
            $from = C("COPY_FROM");
            $this->assign('menus', $menus);
            $this->assign('title_color', $title_color);
            $this->assign('from', $from);
            $this->display();
        }
    }

    public function edit() {
        $news_id = $_REQUEST['id'];
        if ( !$news_id ) redirect("/admin.php?c=content");
        $news = D("News")->getNewsById($news_id);
        if ( !$news ) redirect("/admin.php?c=content");
        $newsContent = D("NewsContent")->getNewsContentById($news_id);
        if ( $newsContent ) {
            $news['content'] = $newsContent['content'];
        }
        $menus = D("Menu")->getHomeNav();
        $title_color = C("TITLE_FONT_COLOR");
        $from = C("COPY_FROM");
        $this->assign('menus', $menus);
        $this->assign('title_color', $title_color);
        $this->assign('from', $from);
        $this->assign('news', $news);
        $this->display();
    }

    public function save($data) {
        $news_id = $data['news_id'];
        unset($data['news_id']);
        try {
            $res = D("News")->updateNewsById($news_id, $data);
            $newsContent['content'] = $data['content'];
            $result = D("NewsContent")->updateNewsContentById($news_id, $newsContent);
            if ( $res === false || $result === false ) {
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
                $news_id = $_POST['id'];
                $status = $_POST['status'];
                $res = D("News")->updateNewsStatus($news_id, $status);
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
        $error = array();
        $jump_url = $_SERVER['HTTP_REFERER'];
        try {
            foreach ($listorder as $news_id => $listval) {
                $res = D("News")->updateNewsListorder($news_id, $listval);
                if ( $res === false ) $error[] = $news_id;
            }
        } catch ( Exception $e ) {
            return show(0, $e->getMessage(), array('jump_url' => $jump_url));
        }
        if ( $error ) {
            return show(0, '排序失败-id:' . implode(',', $error), array('jump_url' => $jump_url));
        } else {
            return show(1, '排序成功', array('jump_url' => $jump_url));
        }
    }

    public function push() {
        $posId = $_POST['position_id'];
        $push = $_POST['push'];
        $error = array();
        if ( !$posId ) return show(0, "没有选择推荐位");
        if ( !$push || !is_array($push) ) return show(0, "没有推送的文章");
        try {
            $news = D("News")->getNewsByIds($push);
            foreach ($news as $new) {
                $data = array(
                    "position_id" => $posId,
                    "title" => $new['title'],
                    "thumb" => $new['thumb'],
                    "news_id" => $new['news_id'],
                    "status" => 1,
                    "create_time" => $new['create_time'],
                    "update_time" => $new['update_time']
                );
                $res = D("PositionContent")->insert($data);
                if ( $res === false ) $error[] = $new['news_id'];
            }
            if ( $error ) {
                return show(0, "推送失败-id:".implode(",", $error));
            } else {
                return show(1, "推送成功");
            }
        } catch ( Exception $e ) {
            return show(0, $e->getMessage());
        }
    }
}