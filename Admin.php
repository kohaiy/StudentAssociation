<?php
namespace app\admin\controller;
use app\admin\model\Admin as AdminM;

class Admin extends BaseController{

	public function web_info(){
		$this->assign('server',$_SERVER);
		return $this->fetch();
	}

	public function user_center(){
		$request = request();
		if ($request->isPost()) {
			$id = $request->post('id/d');
			if ($id !== $this->user['id']) {
				return $this->error('发生未知错误！','user/login');
			}
			$oldPassword = $request->post('oldPassword');
			$newPassword = $request->post('newPassword');
			$admin = new AdminM;
			if ($admin->setPassword($id,$oldPassword,$newPassword)) {
				return $this->success('修改密码成功！','user_center');
			}else{
				return $this->error($admin->error);
			}
		}else{
			return $this->fetch();
		}
	}
}