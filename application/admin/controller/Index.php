<?php
namespace app\admin\controller;

use app\admin\model\Admin as AdminM;
use app\admin\model\ApplySa as ApplySaM;
use app\admin\model\Board as BoardM;
use app\admin\model\School as SchoolM;
use app\admin\model\User as UserM;

class Index extends BaseController
{

    public function index()
    {
        if (request()->isPost() && request()->post('action') !== null) {
            switch (request()->post('action')) {
                case 'setPassword':
                    return $this->user_center();
                    break;
                case 'addBoard':
                    return $this->board_manager();
                    break;
                case 'addManager':
                    return $this->addManager();
                    break;
                case 'applysa':
                    return $this->applysa();
                    break;
                default:
                    return $this->fetch();
            }
        } else if (request()->isGet() && request()->param('a') !== null) {
            switch (request()->param('a')) {
                case 'board_manager':
                    $boardM = new BoardM;
                    $list   = $boardM->select();
                    $this->assign('list', $list);
                    break;
                case 'manager':
                    $adminM = new AdminM;
                    $list   = $adminM->getManagerList();
                    $this->assign('list', $list);
                    break;
                case 'apply_manager':
                    $applysaM = new ApplySaM;
                    $list     = $applysaM->order('status asc,id desc')->select();
                    foreach ($list as $key => $value) {
                        $list[$key]['school'] = SchoolM::get($value['sid']);
                        $list[$key]['user'] = UserM::get($value['uid']);
                    }
                    $this->assign('list', $list);
                    break;

                default:
                    return $this->fetch();
            }
            return $this->fetch();
        } else {
            return $this->fetch();
        }
    }

    private function user_center()
    {
        $request = request();
        if ($request->isPost()) {
            $id          = $this->admin['id'];
            $oldPassword = $request->post('oldPassword');
            $newPassword = $request->post('newPassword');
            $admin       = new AdminM;
            if ($admin->setPassword($id, $oldPassword, $newPassword)) {
                return $this->success('修改密码成功！', 'index?a=user_center');
            } else {
                return $this->error($admin->error);
            }
        } else {
            return $this->fetch();
        }
    }

    private function board_manager()
    {
        if (request()->isPost()) {
            $name  = request()->post('name/s');
            $board = new BoardM;
            if ($board->addBoard($name)) {
                return $this->success('添加成功！', 'index?a=board_manager');
            } else {
                return $this->error($board->error);
            }
        } else {
            $board = new BoardM;
            $list  = $board->select();
            $this->assign('list', $list);
            return $this->fetch();
        }
    }

    private function addManager()
    {
        $username = request()->post('username/s');
        $adminM   = new AdminM;
        if (!$adminM->addManager($username)) {
            return $this->error($adminM->error);
        } else {
            return $this->success('添加管理员成功！', 'index?a=manager');
        }
    }

    private function applysa()
    {
        $aid    = request()->post('aid/d');
        $msg    = request()->post('msg');
        $status = 0;
        if (request()->post('reject') !== null) {
            // 拒绝
            $status = 2;
        } else if (request()->post('accept') !== null) {
            // 接受
            $status = 1;
        }
        $applysaM = new ApplySaM;
        if (!$applysaM->setApply($aid, 0, $status, $msg)) {
            return $this->error($applysaM->error);
        } else {
            return $this->redirect('index?a=apply_manager');
        }
    }
}
