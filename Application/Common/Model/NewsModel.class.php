<?php
namespace Common\Model;

use Think\Model;

class NewsModel extends Model {
    private $_db;
    public function __construct() {
        parent::__construct();
        $this->_db = M("news");
    }

    /**
     * 添加新闻
     * @param array $data
     * @return string
     */
    public function insert($data = array()) {
        if ( !$data || !isset($data) ) return false;
        $data['username'] = getLoginName();
        $data['create_time'] = time();
        $data['update_time'] = time();
        return $this->_db->add($data);
    }

    /**
     * 分页获取新闻
     * @param array $cond
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public function getAllNews($cond = array(), $page, $pageSize) {
        if ( $cond['title'] ) {
            $title = $cond['title'];
            $cond['title'] = array('like', "%".$title."%");
        }
        $offset = ($page - 1) * $pageSize;
        return $this->_db->where($cond)->order('listorder DESC, create_time DESC ,news_id DESC')->limit($offset, $pageSize)->select();
    }

    /**
     * ajax加载更多内容
     * @param array $cond
     * @param int $offset
     * @param int $pageSize
     * @return array
     */
    public function getAllAjaxNews($cond = array(), $offset, $pageSize) {
        return $this->_db->where($cond)->order('listorder DESC, create_time DESC ,news_id DESC')->limit($offset, $pageSize)->select();
    }

    /**
     * 获取新闻条数
     * @param array $cond
     * @return int
     */
    public function getNewsCount($cond = array()) {
        if ( $cond['title'] ) {
            $title = $cond['title'];
            $cond['title'] = array('like', "%".$title."%");
        }
        return $this->_db->where($cond)->count();
    }

    /**
     * 获取指定id的新闻
     * @param int $news_id
     * @return array
     */
    public function getNewsById($news_id) {
        if ( !$news_id || !is_numeric($news_id) ) return false;
        $cond['news_id'] = $news_id;
        return $this->_db->where($cond)->find();
    }

    /**
     * 获取推送多条id的新闻
     * @param array $data
     * @return array
     */
    public function getNewsByIds($data) {
        if ( !$data || !is_array($data) ) throw_exception("推送数据不合法");
        $cond['news_id'] = array('in', implode(",", $data));
        return $this->_db->where($cond)->select();
    }

    /**
     * 更新指定id的文章
     * @param int $news_id
     * @param array $data
     * @return bool
     */
    public function updateNewsById($news_id, $data) {
        if ( !$data || !is_array($data) ) throw_exception('更新数据不合法');
        if ( !$news_id || !is_numeric($news_id) ) throw_exception('文章id不合法');
        $cond['news_id'] = $news_id;
        $data['update_time'] = time();
        return $this->_db->where($cond)->save($data);
    }

    /**
     * 更新文章状态
     * @param int $news_id
     * @param int $status
     * @return bool
     */
    public function updateNewsStatus($news_id, $status) {
        if ( !$news_id || !is_numeric($news_id) ) throw_exception('菜单id不合法');
        if ( !is_numeric($status) ) throw_exception('更新的状态不合法');
        $con['news_id'] = $news_id;
        $data['status'] = $status;
        return $this->_db->where($con)->save($data);
    }
    
    /**
     * 更新文章排序
     * @param int $news_id
     * @param int $value
     * @return bool
     */
    public function updateNewsListorder($news_id, $value) {
        if ( !$news_id || !is_numeric($news_id) ) throw_exception('文章id不合法');
        if ( !is_numeric($value) ) throw_exception('排序值不合法');
        $cond['news_id'] = $news_id;
        $data['listorder'] = $value;
        return $this->_db->where($cond)->save($data);
    }

    /**
     * 获取指定条数的文章
     * @param array $cond
     * @param int $limit
     * @return array
     */
    public function getListNews($cond) {
        if ( !$cond || !is_array($cond) ) return false;
        return $this->_db->where($cond)->order('create_time DESC, news_id DESC')->select();
    }

    /**
     * 获取排行榜文章内容
     * @param array $cond
     * @param int $limit
     * @return array
     */
    public function getNewsRank($cond, $limit = 10) {
        if ( !$cond || !is_array($cond) ) return false;
        if ( !$limit || !is_numeric($limit) ) return false;
        return $this->_db->where($cond)->order('count DESC, news_id DESC')->limit($limit)->select();
    }

    /**
     * 更新文章阅读数
     * @param int $news_id
     * @param int $count
     * @return bool
     */
    public function updateCount($news_id, $count) {
        if( !$news_id || !is_numeric($news_id)) throw_exception('文章id不合法');
        if( !is_numeric($count))throw_exception('count不合法');
        $cond['news_id'] = $news_id;
        $data['count'] = $count;
        return $this->_db->where($cond)->save($data);
    }

    /**
     * 获取最大阅读数
     * @return array
     */
    public function maxCount(){
        $cond['status'] = 1;
        return $this->_db->where($cond)->order('count DESC')->limit(1)->find();
    }
}