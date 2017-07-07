<?php
namespace app\common\model;

use app\index\model\Letter;
use app\index\model\User;
use think\Model;

class Association extends Model
{
    protected $table = 'sa_association';
    protected $pk    = 'aid';

    public $error;
    public $result;

    public function createAssociation($user, $name)
    {
        if ($user == null || $user['school'] == null) {
            $this->error = '用户不存在！';
            return false;
        }
        try {
            $this->save([
                'sid'         => $user['school'],
                'aname'       => $name,
                'create_time' => date('Y-m-d H:i:s', time()),
                'status'      => 1,
            ]);
            $managerM = new Manager;
            $result   = $managerM->addManager($this->aid, $user['uid'], 0);
            $letterM  = new Letter;
            $letterM->addLetter('创建同乡会成功！', '恭喜你，创建同乡会[' . $name . ']成功！', $user['uid']);
        } catch (Exception $e) {
            $this->error = $e->getData();
            return false;
        }
        return true;
    }

    public function joinAs($user, $aid)
    {
        if ($user == null || $user['school'] == null) {
            $this->error = '用户不存在！';
            return false;
        }
        $as = $this->get($aid);
        if ($as === null) {
            $this->error = '系统错误！';
            return false;
        }
        try {
            $userM = new User;
            $userM->where('uid', $user['uid'])->update(['aid' => $aid]);
            $letterM = new Letter;
            $letterM->addLetter('加入同乡会成功！', '恭喜你，成功加入同乡会[' . $as->aname . ']！' . $as->welcome_msg, $user['uid']);
        } catch (Exception $e) {
            $this->error = $e->getData();
            return false;
        }
        return true;
    }

    public function updateAsInfo($user, $data)
    {
        try {
            $this->where('aid', $user['aid'])->update($data);
        } catch (Exception $e) {
            $this->error = $e->getData();
            return false;
        }
        return true;
    }
}
