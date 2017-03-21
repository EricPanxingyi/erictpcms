<?php
namespace Common\Model;

use Think\Model;

class BasicModel extends Model {
    public function __construct(){
    }

    /**
     * 保存静态缓存
     * @param array $data
     * @return bool
     */
    public function saveCache($data) {
        if ( !$data || !is_array($data) ) return false;
        return F("basic_web_config", $data);
    }

    /**
     * 读取静态缓存
     * @return array
     */
    public function readCache() {
        return F("basic_web_config");
    }
}