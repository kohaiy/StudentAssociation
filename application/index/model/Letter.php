<?php
namespace app\index\model;

use think\Model;

class Letter extends Model
{
    protected $table = 'sa_letter';
    protected $pk    = 'id';

    public $error;
    public $result;

    public function addLetter($title, $content, $accepter, $sender = null)
    {
        try {
            $this->save([
                'title'       => $title,
                'content'     => $content,
                'accepter'    => $accepter,
                'sender'      => $sender,
                'create_time' => date('Y-m-d H:i:s', time()),
                'status'      => 1,
            ]);
        } catch (Exception $e) {
            $this->error = $e->getData();
            return false;
        }
        return true;
    }

    public function getLetterListByUid($uid)
    {
        try {
            $this->result = $this->where('accepter', $uid)->order('id desc')->select();
        } catch (Exception $e) {
            $this->error = $e->getData();
            return false;
        }
        return true;
    }
}
