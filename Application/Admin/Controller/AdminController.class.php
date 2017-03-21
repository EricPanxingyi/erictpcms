<?php
namespace Admin\Controller;

use Think\Exception;

class AdminController extends CommonController {
    public function index() {
        $admin = getLoginName();
        if ( $admin == 'admin' ) {
            $users = D("Admin")->getAllAdmins();
            $this->assign("users", $users);
            $this->display();
        } else {
            $this->display("Index/index");
        }
    }
    
    public function add() {
        if ( $_POST ) {
            if( !isset($_POST['username'] ) || !$_POST['username']) return show(0, '用户名不能为空');
            if( !isset($_POST['password'] ) || !$_POST['password']) return show(0, '密码不能为空');
            $_POST['password'] = getMd5Password($_POST['password']);
            $admin = D("Admin")->getAdminByUsername($_POST['username']);
            if ( $admin && $admin['status'] != -1 ) return show(0, "该用户已经存在");
            $res = D("Admin")->insert($_POST);
            if ( $res ) {
                return show(1, "添加成功");
            } else {
                return show(0, "添加失败");
            }
        } else {
            $this->display();
        }
    }

    public function setStatus() {
        try {
            if ( $_POST ) {
                $adminId = $_POST['id'];
                $status = $_POST['status'];
                if ( !$adminId ) {
                    return show(0, 'ID不存在');
                }
                $res = D('Admin')->updateAdminStatus($adminId, $status);
                if($res === false){
                    return show(0, '操作失败');
                }
                return show(1, '操作成功');
            }
            return show(0, '没有接收到数据');
        } catch ( Exception $e ) {
            return show(0, $e->getMessage());
        }
    }

    public function personal() {
        $user = $this->getLoginUser();
        $info = D("Admin")->getAdminById($user['admin_id']);
        $this->assign("info", $info);
        $this->display();
    }

    public function save() {
        $user = $this->getLoginUser();
        if(!$user){
            return show(0,'用户不存在');
        }
        $data['realname'] = $_POST['realname'];
        $data['email'] = $_POST['email'];
        $adminId = $_POST['admin_id'];
        unset($_POST['admin_id']);
        try {
            $id = D("Admin")->updateInfoByAdminId($adminId, $data);
            if ( $id === false ) {
                return show(0, '配置失败');
            }
            return show(1, '配置成功');
        } catch ( Exception $e ) {
            return show(0, $e->getMessage());
        }
    }
}