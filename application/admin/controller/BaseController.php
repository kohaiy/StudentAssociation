<?php
namespace app\admin\controller;
use think\Controller;

class BaseController extends Controller{

	protected $admin;

	public function _initialize(){
		$this->admin = session('admin');
		if ($this->admin===null || $this->admin['role']>1) {
			return $this->error('您还没有登录呢！', 'User/login');
		}
		if (request()->controller() === 'Admin' && $this->admin['role'] !== 0) {
			return $this->error('您没有权限访问该模块！', 'User/login');
		}
	}
}