<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller {

    public function index() {
        $this ->display(U('Goods/showlist'));
    }

    public function login() {
        $this->display();
    }

    public function logout() {
        session('user_name', null);
        redirect(U('Goods/showlist'), 2, '已成功退出，正在返回商城首页。。。。。');
    }

    public function check_login() {

        session_start(); //开启session
        $user = D('user');

        $user_name = I('post.user_name');
        $user_pwd = I('post.user_pwd');


        //查询数据库，并先验证用户名是否正确，若正确再进行下一步验证密码
        $result = $user->where(array('user_name' => array('eq', $user_name)))->select();



        if ($result) {
            if ($result[0]['user_pwd'] == $user_pwd) {
                session('user_name', $user_name);  //把用户名添加到session中
                redirect(U('Goods/shop_cart'), 1, '正在登录中。。。。');
            } else {
                redirect(U('login'), 2, '密码错误!请重新登录。');
            }
        } else {
            redirect(U('login'), 2, '不存在该用户，请重新登录。');
        }
    }

}






