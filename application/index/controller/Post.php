<?php
namespace app\index\controller;

use app\index\model\Board as BoardM;
use app\index\model\Post as PostM;
use app\index\model\Reply as ReplyM;
use app\index\model\User as UserM;

class Post extends BaseController
{

    public function index()
    {
        if (request()->isPost()) {
            $this->checkUserStatus();
            $pid    = request()->post('pid');
            $reply  = request()->post('reply');
            $replyM = new ReplyM;
            if ($replyM->addReply($pid, $this->user, $reply)) {
                return $this->redirect('index?id=' . $pid);
            } else {
                return $this->error($replyM->error);
            }
        }
        $pid = request()->param('id');
        if (!$pid) {
            return $this->redirect('index/index');
        }
        $post = PostM::get($pid);
        if ($post === null) {
            return $this->error('帖子不存在！');
        }
        $post['user']  = UserM::get($post->uid);
        $post['board'] = BoardM::get($post->id);
        $this->assign('post', $post);
        return $this->fetch();
    }

    /**
     * 发布帖子
     * @return [type] [description]
     */
    public function send()
    {
        $this->checkUserStatus();
        if (request()->isPost()) {
            $bid     = request()->post('bid');
            $title   = request()->post('title');
            $content = request()->post('content');
            $tags    = request()->post('tags');
            $postM   = new PostM;
            if ($postM->addPost($bid, $this->user['uid'], $title, $content, $tags)) {
                return $this->success('发表帖子成功！', 'post/index?id=' . $postM['pid']);
            } else {
                return $this->error($postM->error);
            }
        } else {
            $id = request()->get('bid');
            if (!$id) {
                return $this->redirect('square/index');
            }
            $boardM = new BoardM;
            $board  = $boardM->getBoardById($id);
            if (!$board) {
                return $this->error($boardM->error, 'index/index');
            }
            if ($board->aid === null) {
                $sa = null;
            } else {
                $sa = $board->aid;
            }

            $this->assign('sa', $sa);
            $this->assign('board', $board);
            return $this->fetch();
        }
    }

    /**
     * 编辑帖子
     * @return [type] [description]
     */
    public function edit()
    {
        $this->checkUserStatus();
        if (request()->isPost()) {
            $pid     = request()->post('pid');
            $title   = request()->post('title');
            $content = request()->post('content');
            $tags    = request()->post('tags');
            $postM   = new PostM;
            if ($postM->updatePost($pid, $this->user, $title, $content, $tags)) {
                return $this->success('更新帖子成功！', 'post/index?id=' . $pid);
            } else {
                return $this->error($postM->error);
            }
        } else {
            $pid = request()->param('id');
            if ($pid === null) {
                return $this->error('您所访问的网址有问题！');
            }
            $post = PostM::get($pid);
            if ($post === null) {
                return $this->error('您所访问的帖子不存在！');
            }
            if ($this->user['uid'] != $post['uid']) {
                return $this->error('您没有权限修改该帖子！');
            }
            $board = BoardM::get($post['id']);
            if ($board->aid === null) {
                $sa = null;
            } else {
                $sa = $board->aid;
            }
            $this->assign('post', $post);
            $this->assign('sa', $sa);
            $this->assign('board', $board);
            return $this->fetch();
        }
    }

    /**
     * 通过用户编号获取用户的所有帖子
     * @return [type] [description]
     */
    public function getPostListByUid()
    {
        $this->checkUserStatus();
        $postM = new PostM;
        $data  = $postM->where('uid', $this->user['uid'])->order('pid desc')->select();
        return json($data);
    }

    /**
     * 通过帖子编号删除帖子
     * @return [type] [description]
     */
    public function deletePostByPid()
    {
        $this->checkUserStatus();
        $postM = new PostM;
        if ($postM->deletePostByPid(request()->post('pid'))) {
            $data['code']   = 0;
            $data['result'] = '删除帖子成功！';
        } else {
            $data['code']   = 1;
            $data['result'] = $postM->error;
        }
        return json($data);
    }

    public function getReplyByPid()
    {
        $replyM = new ReplyM;
        try {
            $data['code']   = 0;
            $data['result'] = $replyM->where('pid', request()->post('pid'))->select();
        } catch (Exception $e) {
            $data['code']   = 1;
            $data['result'] = $e->getData();
        }
        return json($data);
    }
}
