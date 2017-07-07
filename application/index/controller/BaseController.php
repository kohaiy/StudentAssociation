<?php
namespace app\index\controller;

use app\common\model\Manager as ManagerM;
use app\index\model\User as UserM;
use think\Controller;
use think\Session;

class BaseController extends Controller
{

    protected $user;

    protected function checkUserStatus()
    {
        $this->user = request()->session('user');
        if ($this->user === null) {
            return $this->error('您还没有登录呢！', 'user/login');
        } else {
            $this->user = UserM::get($this->user['uid']);
            Session::set('user', $this->user);
        }
    }

    protected function checkManagerRole()
    {
        $this->checkUserStatus();
        $managerM = new ManagerM;
        if ($managerM->where('uid', $this->user['uid'])->find() === null) {
            return $this->error('您没有权限访问该页面！|只用管理员才能访问！');
        }
    }
}
