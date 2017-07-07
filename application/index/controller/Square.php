<?php
namespace app\index\controller;
use app\index\model\Board as BoardM;
use app\index\model\Post as PostM;
use app\index\model\User as UserM;
use app\index\model\Tags as TagsM;

class Square extends BaseController{

	public function index(){
		$board = new BoardM;
		$list = $board->order('sort asc,id desc')->where('aid','null')->select();
		$this->assign('list',$list);
		return $this->fetch();
	}

	/**
	 * 广场加载前五条帖子记录
	 * @return [type] [description]
	 */
	public function getPostListByBoardId(){
		$bid = request()->param('bid');
		$postM = new PostM;
		$list = $postM->getPostListByBoardId($bid,'desc',0,5);
		for ($i=0; $i < sizeof($list); $i++) { 
			$list[$i]['user'] = UserM::get($list[$i]['uid']);
		}
		return json($list);
	}

	public function getTags(){
		$tagsM = new TagsM;
		$list = $tagsM->getTags(0,100);
		return json($list);
	}
}