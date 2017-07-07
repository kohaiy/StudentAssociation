<?php
namespace app\index\controller;

use app\common\model\Association as AssociationM;
use app\common\model\Manager as ManagerM;
use app\index\model\ApplySa as ApplySaM;
use app\index\model\Board as BoardM;
use app\index\model\School as SchoolM;
use app\index\model\User as UserM;
use think\Cookie;
use think\Session;

class User extends BaseController
{
public function getpost(){
    return json(request()->post());
}
    public function __construct()
    {
        parent::__construct();
        $this->assign('role', 3);
        $this->user = request()->session('user');
        if ($this->user !== null) {
            $managerM = new ManagerM;
            $manager  = $managerM->where('uid', $this->user['uid'])->find();
            if ($manager === null) {
                $this->assign('role', 2);
            } else {
                $this->assign('role', $manager['role']);
            }
        }
    }
#页面请求

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {
        $this->checkUserStatus();
        if (request()->isPost()) {
            $action = request()->post('action');
            if ($action == 'setPassword') {
                $oldPassword = request()->post('oldPassword');
                $newPassword = request()->post('newPassword');
                $userM       = new UserM;
                if ($userM->setPassword($this->user, $oldPassword, $newPassword)) {
                    return $this->success('修改成功！', 'index');
                } else {
                    return $this->error($userM->error);
                }
            } else if ($action == 'update') {
                $data = request()->post();
                unset($data['action']);
                dump($data);
                $userM = new UserM;
                if ($userM->updataUserInfo($this->user, $data)) {
                    return $this->redirect('index');
                } else {
                    return $this->error($userM->error);
                }
            } else if ($action == 'school') {
                $schoolId = request()->post('school');
                $userM    = new UserM;
                if ($userM->updataUserSchool($this->user, $schoolId)) {
                    return $this->redirect('index');
                } else {
                    return $this->error($userM->error);
                }
            } else {
                return $this->error('非法操作！');
            }
        }
        return $this->fetch();
    }

    /**
     * 同乡会
     * @return [type] [description]
     */
    public function association()
    {
        $this->checkUserStatus();
        if (request()->isPost()) {
            if (request()->post('action') == 'create') {
                $title    = request()->post('title');
                $reason   = request()->post('reason');
                $applysaM = new ApplySaM;
                if ($applysaM->createApply($this->user, $this->user['school'], $title, $reason)) {
                    return $this->success('申请成功！', 'association');
                } else {
                    return $this->error($applysaM->error);
                }
            } else if (request()->post('action') == 'join') {
                $aid = request()->post('as');
                $asM = new AssociationM;
                if ($asM->joinAs($this->user, $aid)) {
                    return $this->success('加入同乡会成功！', 'association');
                } else {
                    return $this->error($asM->error);
                }
            } else if (request()->post('action') == 'quit') {
                $userM = new UserM;
                if ($userM->quitAs($this->user)) {
                    return $this->success('退出同乡会成功！');
                } else {
                    return $this->error($userM->error);
                }
            } else {
                return $this->error('非法操作！');
            }
        } else {
            if ($this->user['aid'] === null) {
                $applysaM  = new ApplySaM;
                $applyList = $applysaM->order('id desc')->where(['uid' => $this->user['uid']])->select();
                $count     = 0;
                foreach ($applyList as $key => $value) {
                    $applyList[$key]['school'] = SchoolM::get($value['sid']);
                    if ($value['status'] != 2) {
                        $count++;
                    }
                }
                $this->assign('count', $count);
                $this->assign('applyList', $applyList);
            } else {
                $as       = AssociationM::get($this->user['aid']);
                $managerM = new ManagerM;
                $managers = $managerM->where('aid', $this->user['aid'])->select();
                foreach ($managers as $key => $value) {
                    $managers[$key]['user'] = UserM::get($value['uid']);
                }
                $userM = new UserM;
                $users = $userM->where('aid', $this->user['aid'])->select();
                $this->assign('as', $as);
                $this->assign('managers', $managers);
                $this->assign('users', $users);
            }
            return $this->fetch();
        }
    }

    public function post()
    {
        $this->checkUserStatus();
        return $this->fetch();
    }

    public function as_manager()
    {
        $this->checkManagerRole();
        return $this->fetch();
    }

#结束页面请求

#注册、登录、登出

    /**
     * 登录
     * @return [type] [description]
     */
    public function login()
    {
        if (request()->isPost()) {
            $username = request()->post('username');
            $password = request()->post('password');
            $user     = new UserM;
            if (!$user->login($username, $password)) {
                return $this->error($user->error);
            } else {
                Session::set('user', $user->result);
                return $this->success('登录成功！', 'index/index/index');
            }
        }
        return $this->fetch();
    }

    /**
     * 注册
     * @return [type] [description]
     */
    public function register()
    {
        if (request()->isPost()) {
            $username = request()->post('username');
            $password = request()->post('password');
            $user     = new UserM;
            if (!$user->register($username, $password)) {
                return $this->error($user->error, 'register');
            } else {
                return $this->success('恭喜你，注册成功！', 'login');
            }
        }
        return $this->fetch();
    }

    /**
     * 登出操作
     * @return [type] [description]
     */
    public function logout()
    {
        Session::clear();
        $this->success('注销成功！', 'index/index/index');
    }

#结束注册、登录、登出

#JSON请求

    public function updateAsInfo()
    {
        $this->checkManagerRole();
        $asM = new AssociationM;
        if ($asM->updateAsInfo($this->user, request()->post())) {
            $data['code']   = 0;
            $data['result'] = '更新同乡会信息成功！';
        } else {
            $data['code']   = 1;
            $data['result'] = $asM->error;
        }
        return json($data);
    }

    /**
     * 获取同乡会列表
     * @return [type] [description]
     */
    public function getAsListBySid()
    {
        $this->checkUserStatus();
        if ($this->user['school'] === null) {
            $data['code']   = 1;
            $data['result'] = '您还没有添加您的学校！';
        } else {
            $asM            = new AssociationM;
            $data['result'] = $asM->where('sid', $this->user['school']['sid'])->select();
            $data['code']   = 0;
        }
        return json($data);
    }

    public function addBoard()
    {
        $this->checkUserStatus();
        $aid    = $this->user['aid'];
        $name   = request()->post('name');
        $boardM = new BoardM;
        if ($boardM->addBoard($aid, $name)) {
            $data['code']   = 0;
            $data['result'] = '添加成功！';
        } else {
            $data['code']   = 1;
            $data['result'] = $boardM->error;
        }
        return json($data);
    }

    public function updateBoard()
    {
        $this->checkManagerRole();
        $bid    = request()->post('bid');
        $bname  = request()->post('name');
        $boardM = new BoardM;
        if ($boardM->updateBoard($bid, $bname)) {
            $data['code']   = 0;
            $data['result'] = '修改成功！';
        } else {
            $data['code']   = 1;
            $data['result'] = $boardM->error;
        }
        return json($data);
    }

    public function deleteBoard()
    {
        $this->checkManagerRole();
        $bid    = request()->post('bid');
        $boardM = new BoardM;
        if ($boardM->deleteBoard($bid)) {
            $data['code']   = 0;
            $data['result'] = '删除成功！';
        } else {
            $data['code']   = 1;
            $data['result'] = $boardM->error;
        }
        return json($data);
    }

    public function getBoardList()
    {
        $this->checkUserStatus();
        if ($this->user['aid'] === null) {
            $data['code']   = 1;
            $data['result'] = '该用户没有加入任何同乡会！';
            return json($data);
        }
        $boardM         = new BoardM;
        $data['result'] = $boardM->where('aid', $this->user['aid'])->order('sort asc')->select();
        $data['code']   = 0;
        return json($data);

    }

    /**
     * 通过用户id获取用户信息
     * @return [type] [description]
     */
    public function getUserByUid()
    {
        $uid = request()->post('uid');
        if ($uid !== null) {
            $result = UserM::get($uid);
            if ($result !== null) {
                $data['code']   = 0;
                $data['result'] = $result;
                return json($data);
            }
        }
        $data['code']   = 1;
        $data['result'] = '用户编号不存在！';
        return json($data);
    }

    /**
     * 通过同乡会id获取同乡会管理员列表
     * @return [type] [description]
     */
    public function getAsManagerByAid()
    {
        $aid = request()->post('aid');
        if ($aid === null) {
            $aid = $this->user['aid'];
        }
        if ($aid !== null) {
            $managerM = new ManagerM;
            $result   = $managerM->where('aid', $aid)->select();
            if ($result !== null) {
                $data['code']   = 0;
                $data['result'] = $result;
                return json($data);
            }
        }
        $data['code']   = 1;
        $data['result'] = '同乡会编号不存在！';
        return json($data);
    }

    /**
     * 通过同乡会id获取同乡会信息
     * @return [type] [description]
     */
    public function getAsByAid()
    {
        $aid = request()->post('aid');
        if ($aid !== null) {
            $result = AssociationM::get($aid);
            if ($result !== null) {
                $data['code']   = 0;
                $data['result'] = $result;
                return json($data);
            }
        }
        $data['code']   = 1;
        $data['result'] = '同乡会编号不存在！';
        return json($data);
    }

    /**
     * 获取当前登录的用户
     * @return [type] [description]
     */
    public function getCurrentUser()
    {
        $this->checkUserStatus();
        $user = $this->user;
        unset($user['password']);
        return json($user);
    }

    /**
     * 检验用户名是否存在
     * @return [type] [description]
     */
    public function checkusername()
    {
        $request  = request();
        $username = $request->request('username');
        $result   = [];
        $user     = new UserM;
        if ($user->checkUsername($username)) {
            $result['code']   = 1;
            $result['result'] = '用户名已经存在！';
        } else {
            $result['code']   = 0;
            $result['result'] = '用户名可以注册！';
        }
        return json($result);
    }

    /**
     * 设置cookie
     * @return [type] [description]
     */
    public function localconfig()
    {
        $key   = request()->param('key');
        $value = request()->param('value');
        if ($key === null || $value === null) {
            return json(['code' => 1, 'result' => 'error']);
        }
        Cookie::set($key, $value);
        return json(['code' => 0, 'result' => 'success']);
    }

#结束JSON请求

}
