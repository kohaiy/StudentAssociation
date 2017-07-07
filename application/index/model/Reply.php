<?php
namespace app\index\model;

use think\Model;

class Reply extends Model
{
    protected $table = 'sa_reply';
    protected $pk    = 'id';

    public $error;
    public $result;

    public function addReply($pid, $user, $reply)
    {
        $post = Post::get($pid);
        if ($post === null) {
            $this->error = '帖子不存在！';
            return false;
        }
        if (strlen($reply) < 2) {
            $this->error = '回复内容过短！';
            return false;
        }
        try {
            $this->save([
                'pid'        => $pid,
                'uid'        => $user['uid'],
                'content'    => $reply,
                'reply_time' => date('Y-m-d H:i:s', time()),
            ]);
            $letterM = new Letter;
            $letterM->addLetter('帖子有新回复！', '有人回复了你的帖子，赶紧去<a href="' . url('?id=' . $pid) . '">看看</a>！', $post['uid']);
        } catch (Exception $e) {
            $this->error = $e->getData();
            return false;
        }
        return true;

    }
}
