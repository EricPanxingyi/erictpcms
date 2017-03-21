<?php
namespace Shell\Controller;

use Think\Controller;

class CronController extends Controller {
    public function dumpMySQL() {
        $webCache = D("Basic")->readCache();
        if ( !$webCache['dumpmysql'] ) die('系统没有开启数据库备份');
        $shell = "mysqldump -u".C("DB_USER")." -p".C("DB_PWD")." ".C("DB_NAME")." > /tmp/cms".date("Ymd").".sql";
        exec($shell);
    }
}