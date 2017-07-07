<?php
namespace app\index\controller;

use app\index\model\Board as BoardM;
use app\index\model\Post as PostM;
use app\index\model\User as UserM;

class Board extends BaseController
{

    public function index()
    {
        $id = request()->param('id');
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
        $postM = new PostM;
        $list  = $postM->getPostListByBoardId($id);
        for ($i = 0; $i < sizeof($list); $i++) {
            $list[$i]['user'] = UserM::get($list[$i]['uid']);
        }
        $this->assign('sa', $sa);
        $this->assign('board', $board);
        $this->assign('list', $list);
        return $this->fetch();
    }
}
