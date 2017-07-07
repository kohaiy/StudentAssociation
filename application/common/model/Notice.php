<?php
namespace app\common\model;

use app\index\model\Letter;
use app\index\model\User;
use think\Model;
use think\Validate;

class Notice extends Model
{
    protected $table = 'sa_notice';
    protected $pk    = 'nid';

    public $error;
    public $result;

    public function getNoticeListByAid($aid)
    {
        try {
            $this->result = $this->where('aid', $aid)->order('nid desc')->select();
        } catch (Exception $e) {
            $this->error = $e->getData();
            return false;
        }
        return true;
    }

    public function addNotice($user, $data)
    {
        $validate = new Validate([
            'title|标题'   => 'require|max:25',
            'content|内容' => 'require|max:100',
        ]);
        if (!$validate->check($data)) {
            $this->error = $validate->getError();
            return false;
        }
        try {
            $this->save([
                'aid'         => $user['aid'],
                'uid'         => $user['uid'],
                'title'       => $data['title'],
                'content'     => $data['content'],
                'create_time' => date('Y-m-d H:i:s', time()),
            ]);
            $userM = new User;
            $users = $userM->where('aid', $user['aid'])->select();
            for ($i = 0; $i < sizeof($users); $i++) {
                $letterM = new Letter;
                $letterM->addLetter($data['title'], $data['content'], $users[$i]['uid'], $user['uid']);
            }
        } catch (Exception $e) {
            $this->error = $e->getData();
            return false;
        }
        return true;
    }
}
