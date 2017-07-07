<?php
namespace app\index\controller;

use app\common\model\Notice as NoticeM;
use app\index\model\User as UserM;

class Notice extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->checkUserStatus();
        if ($this->user['aid'] === null) {
            return $this->error('您还没有加入任何同乡会！');
        }
    }

    public function index()
    {
        return $this->fetch();
    }

    public function detail()
    {
        if (request()->param('id') === null) {
            return $this->redirect('index');
        }
        $notice = NoticeM::get(request()->param('id'));
        $this->assign('notice', $notice);
        return $this->fetch();
    }

    public function manager()
    {
        $this->checkManagerRole();
        return $this->fetch();
    }

    public function add()
    {
        if (request()->isPost()) {
            $data    = request()->post();
            $noticeM = new NoticeM;
            if ($noticeM->addNotice($this->user, $data)) {
                return $this->success('添加成功！', 'manager');
            } else {
                return $this->error($noticeM->error);
            }
        } else {
            return $this->fetch();
        }
    }

    public function getNoticeList()
    {
        $this->checkUserStatus();
        if ($this->user['aid'] === null) {
            $data['code']   = 1;
            $data['result'] = '用户还没有加入任何同乡会！';
        } else {
            $noticeM = new NoticeM;
            if ($noticeM->getNoticeListByAid($this->user['aid'])) {
                $data['code']   = 0;
                $data['result'] = $noticeM->result;
            } else {
                $data['code']   = 1;
                $data['result'] = $noticeM->error;
            }
        }
        return json($data);
    }

    public function deleteNotice()
    {
        $nid     = request()->post('nid');
        $noticeM = new NoticeM;
        if ($noticeM->destroy($nid)) {
            $data['code']   = 0;
            $data['result'] = '删除成功！';
        } else {
            $data['code']   = 1;
            $data['result'] = '删除失败！';
        }
        return json($data);
    }

    public function getUserById()
    {
        return json(UserM::get(request()->post('uid')));
    }
}
