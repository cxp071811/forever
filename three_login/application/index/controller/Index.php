<?php 
namespace app\index\controller;


use think\Controller;
use think\Request;
use think\Db;



class Index extends Controller
{
	
	public function index()
	{
		return view('login');
	}
	public function login()
	{
		// 调用类
		$request = Request::instance();

		// 调用post()
		$data = $request->post();

		$data_user = $data['username'];

		// 查询数据 find()一维数组，select 二维数组  朱宣伟 宣宣老师，17600327365 253163415
		$user = Db::table('user')->where('username',$data_user)->find();

		if (empty($user)) {
			// 判断
			$this ->error('客官，请注册，别闹');
		}else{
			if ($user['is_statue'] == 0) {
				$this -> error('用户已锁定');
			}

			if ($data['password'] == $user['password']) {
				Db::table('user')->where('username',$data_user)->setField('count', 0);
				$this -> success('登录成功');
			}else{
				if ($user['count'] < 3) {
					Db::table('user')->where('username',$data_user)->setInc('count');
					$this ->error('登录失败');
				}else{
					Db::table('user')->where('username',$data_user)->setField('is_statue', 0);
					$this ->error('用户已锁定');
				}
				$this ->error('登录失败');
			}

		}

	}
}

 ?>