<?php
namespace Common\Model;

use Think\Model;

class NewsContentModel extends Model {
    private $_db;
    public function __construct() {
        parent::__construct();
        $this->_db = M('news_content');
    }

    /**
     * 添加文章内容
     * @param array $data
     * @return string
     */
    public function insert($data = array()) {
        if ( !$data || !isset($data) ) return false;
        $data['create_time'] = time();
        $data['update_time'] = time();
        if ( $data['content'] && isset($data['content']) ) {
            $data['content'] = htmlspecialchars($data['content']);
        }
        return $this->_db->add($data);
    }

    /**
     * 获取指定id的新闻内容
     * @param int $news_id
     * @return array
     */
    public function getNewsContentById($news_id) {
        if ( !$news_id || !is_numeric($news_id) ) return false;
        $cond['news_id'] = $news_id;
        return $this->_db->where($cond)->find();
    }

    /**
     * 更新指定文章内容
     * @param int $news_id
     * @param array $data
     * @return bool
     */
    public function updateNewsContentById($news_id, $data) {
        if ( !$data || !is_array($data) ) throw_exception('更新数据不合法');
        if ( !$news_id || !is_numeric($news_id) ) throw_exception('文章id不合法');
        $cond['news_id'] = $news_id;
        $data['update_time'] = time();
        if ( $data['content'] ) {
            $data['content'] = htmlspecialchars($data['content']);
        }
        return $this->_db->where($cond)->save($data);
    }
}