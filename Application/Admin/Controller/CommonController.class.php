<?php
namespace Admin\Controller;
use Think\Controller;

class CommonController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->_init();
    }

    /**
     * 初始化
     */
    private function _init() {
        $login = $this->isLogin();
        if ( !$login ) {
            redirect('/admin.php?c=login');
        }
        $navs = D("Menu")->getMenusNav();
        $username = getLoginName();
        foreach ( $navs as $k => $v ) {
            if ( $username != 'admin' ) {
                switch ( $v['c'] ) {
                    case 'admin':
                        unset($navs[$k]);
                        break;
                    case 'menu':
                        unset($navs[$k]);
                        break;
                    case 'position':
                        unset($navs[$k]);
                        break;
                }
            }
        }
        $index = 'Index';
        $this->assign("result", array(
            "navs" => $navs,
            "index" => $index
        ));
        $this->display("Common/nav_menu");
    }

    /**
     * 判断是否登录
     * @return bool
     */
    public function isLogin() {
        $user = session('adminUser');
        if ( $user && is_array($user) && $user['username']) return true;
        return false;
    }

    /**
     * 获取用户信息
     * @return array
     */
    public function getLoginUser() {
        return session("adminUser");
    }
}