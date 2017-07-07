<?php
namespace app\index\controller;

use app\index\model\Board as BoardM;
use app\index\model\Tags as TagsM;

class Index extends BaseController
{

    public function index()
    {
        return $this->fetch();
    }

    public function getBoardList()
    {
        $this->checkUserStatus();
        if ($this->user['aid'] === null) {
            $data['code']   = 1;
            $data['result'] = '您还未加入任何同乡会！';
        } else {
            $boardM         = new BoardM;
            $data['result'] = $boardM->order('sort asc')->where('aid', $this->user['aid'])->select();
            $data['code']   = 0;
        }
        return json($data);
    }

    public function getTags()
    {
        $this->checkUserStatus();
        $tagsM          = new TagsM;
        $data['result'] = $tagsM->order('count desc')->select();
        $data['code']   = 0;
        return json($data);
    }

    public function checkUserLoginStatus()
    {
        $this->user = request()->session('user');
        if ($this->user === null) {
            $data['code']   = 1;
            $data['result'] = '用户还未登录！';
        } else {
            $data['code']   = 0;
            $data['result'] = '用户已经登录！';
        }
        return json($data);
    }

}
