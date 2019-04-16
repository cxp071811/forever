<?php
/**
 * Created by PhpStorm.
 * User: jarod
 * Date: 2018/8/22
 * Time: 0:36
 */

namespace Home\Controller;

use Think\Controller;

Class GoodsController extends Controller {

    //展示商品内容的的方法
    public function showlist() {

        $goods = D('goods');
        $goods_list = $goods->order('goods_id desc')->select();

        $this->assign('goods_list', $goods_list);
        $this->display();
    }

    //展示已添加到购物车的商品的方法，把已添加的商品暂时存放在一组二维数组数组当中array（‘商品名字’ => array（商品信息））
    public function shop_cart() {

        session_start();  //开启session
        $GET_name = I('get.goods_name');
        $GET_id = I('get.goods_id');

        $shop_cart = I('session.shop_cart');  //读取session并放在数组$shop_cart
        //判断session数组中是否存在过该添加购物车的商品
        if (array_key_exists($GET_name, $shop_cart) && $GET_name != "") {
            //该商品已经添加过购物车，进行shop_cart数组中的该商品数量加1的操作
            $shop_cart[$GET_name]['goods_num'] ++;
        } else if ($GET_name != ""){
            //该商品为新商品，进行数据库查询该商品具体信息，并存入shop_cart数组
            $goods = D('goods');
            $result = $goods->where(array('goods_id' => array('eq', $GET_id)))->select();

            $arr0 = array($GET_name => array('goods_id' => $GET_id, 'goods_num' => 1, 'goods_name' => $GET_name, 'goods_price' => $result[0]['goods_price']));

            foreach ($arr0 as $key => $value) {
                $shop_cart[$key] = $value;
            }
        }


        session('shop_cart', $shop_cart);  //赋值给session
        //var_dump($shop_cart);
        $this->assign('shop_cart', $shop_cart);
        $this->display();
    }

    //清空当前购物车的方法
    public function clean_cart() {
        session('shop_cart', null);
        redirect(U('showlist'), 2, '已成功清空购物车，正在跳转到商城首页。。。。。');
    }

    //结算方法
    public function finish() {
        //通过session['user_name']判断是否登录。如果已登录则把数据写入数据库,并提示成功跳转到商品展示页
        //如果未登录 ，提示进行登录，并且跳转至登录页面
        session_start();  //开启session
        $buy = D('buy');
        $shop_cart = session('shop_cart');  //从session中读取购物车二维数组
        $user_name = session('user_name');    //从session中读取用户的信息

        if (isset($user_name)) {
            //已经登录,从session中取出数据来写入数据库
            foreach ($shop_cart as $v => $val) {

                $data['buy_goods_id'] = $val['goods_id'];
                $data['buy_goods_name'] = $val['goods_name'];
                $data['buy_goods_num'] = $val['goods_num'];
                $data['buy_goods_price'] = $val['goods_price'];
                $data['user_name'] = $user_name;

                $rs = $buy->add($data);
            }
            if ($rs) {
                $this->success('结算成功！！！现在返回首页', U('showlist'), 2);  //成功写入数据则提示并2秒后跳转
                $this->clean_cart();
            }
            else {
                $this->error('结算失败，正在返回购物车！！！', U('shop_cart'), 3); //失败写入数据则提示并3秒后跳转
            }
        }else {
            //未登录则重定向到登录页面
            redirect(U('Index/login'), 2, '请登录后再进行结算，界面正跳转到登录界面。。。');
        }
    }

}
