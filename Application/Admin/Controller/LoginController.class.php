<?php
namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller {
    public function index() {
        if ( session('adminUser') ) {
            redirect('/admin.php');
        }
        $this->display();
    }

    /**
     * 登录判断
     * @return string
     */
    public function check() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ( !trim( $username ) ) return show(0, '用户名不能为空');
        if ( !trim( $password ) ) return show(0, '密码不能为空');
        
        $ret = D('Admin')->getAdminByUsername($username);
        if ( !$ret || $ret['status'] != 1 ) return show(0, '用户名不存在');
        if ( $ret['password'] != getMd5Password($password) ) return show(0, '密码错误');
        
        $loginIP = $_SERVER['REMOTE_ADDR'];
        D("Admin")->updateLoginInfo($ret['admin_id'], $loginIP);
        session('adminUser', $ret);
        return show(1, '登录成功');
    }

    /*
     * 登出
     */
    public function loginout() {
        session('adminUser', null);
        redirect('/admin.php?c=login');
    }
}