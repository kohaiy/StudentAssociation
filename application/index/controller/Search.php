<?php
namespace app\index\controller;
use app\index\model\Post as PostM;
use app\index\model\User as UserM;

class Search extends BaseController{

    public function index(){
        $key = request()->param('key');
        $postM = new PostM;
        if ($postM->searchPost($key)) {
            $list = $postM->result;
            for ($i=0; $i < sizeof($list); $i++) { 
              $list[$i]['user'] = UserM::get($list[$i]['uid']);
            }
        }else{
            $list = null;
        }

        $this->assign('skey',$key);
        $this->assign('list',$list);
        return $this->fetch();
    }
}