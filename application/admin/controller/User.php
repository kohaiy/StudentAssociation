<?php
namespace app\admin\controller;
use think\Session;
use app\admin\model\Admin as AdminM;

class User extends BaseController{

	public function _initialize(){}

	public function login(){
		$request = request();
		if ($request->isPost()) {
			$username = $request->post('username');
			$password = $request->post('password');
			$admin = new AdminM;
			if(!$admin->login($username,$password)){
				$this->error($admin->error);
			}else{
				session('admin',$admin->result);
				$this->success('登录成功！','admin/index/index');
			}	
		}
		return $this->fetch();
	}

	public function logout(){
		Session::clear();
		$this->success('注销成功！','login');
	}
}