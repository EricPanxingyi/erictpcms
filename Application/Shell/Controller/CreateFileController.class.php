<?php
namespace Shell\Controller;
use Think\Controller;

class CreateFileController extends Controller {
    public function crontab_build_html() {
        if ( APP_CRONTAB != 1 ) die('the file must exec crontab');
        $webCache = D("Basic")->readCache();
        if ( !$webCache['cacheindex'] ) die('系统没有开启自动缓存');
        $cron = new \Home\Controller\IndexController();
        $cron->index("buildHtml");
    }
}