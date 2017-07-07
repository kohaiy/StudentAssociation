<?php
namespace app\index\model;

use think\Model;

class ApplySa extends Model
{
    protected $table = 'sa_applysa';
    protected $pk    = 'id';

    public $error;
    public $result;

    /**
     * 创建一个新的同乡会创建申请
     * @param  [type] $user   [description]
     * @param  [type] $school [description]
     * @param  string $name   [description]
     * @param  string $reason [description]
     * @return [type]         [description]
     */
    public function createApply($user = null, $school = null, $name = '', $reason = '')
    {
        if ($user === null || $school === null) {
            $this->error = '未选择学校！';
            return false;
        }
        $name   = trim($name);
        $reason = trim($reason);
        if (strlen($name) < 6 || strlen($name) > 255) {
            $this->error = '同乡会名称请控制在2-50字符之间！';
            return false;
        }
        if (strlen($reason) < 6 || strlen($reason) > 255) {
            $this->error = '申请理由请控制在2-50字符之间！';
            return false;
        }
        if (School::get($school['sid']) === null) {
            $this->error = '学校不存在！';
            return false;
        }
        try {
            $this->save([
                'uid'         => $user['uid'],
                'sid'         => $school['sid'],
                'sname'       => $name,
                'reason'      => $reason,
                'status'      => 0,
                'create_time' => date('Y-m-d H:i:s', time()),
            ]);
        } catch (Exception $e) {
            $this->error = $e->getData();
            return false;
        }
        return true;
    }

    /**
     * 拒绝申请
     * @param  integer $aid 申请编号
     * @param  integer $uid 用户编号
     * @param  string  $msg 拒绝原因
     * @return bool         是否操作成功
     */
    public function refuseApply($aid = 0, $uid = 0, $msg = '')
    {
        $aid = intval($aid);
        // 所拒绝的申请编号为0时，通过用户编号拒绝所有申请
        if ($aid === 0) {
            $uid = intval($uid);
            if ($uid === 0 || User::get($uid) === null) {
                $this->error = '用户编号不存在！';
                return false;
            }
            try {
                $this->where(['uid' => $uid, 'status' => 1])->update(['status' => 2, 'msg' => $msg, 'reply_time' => date('Y-m-d H:i:s', time())]);
            } catch (Exception $e) {
                $this->error = $e->getData();
                return false;
            }
            return true;
        } else {
            if ($this->get($aid) === null) {
                $this->error = '申请编号不存在！';
                return false;
            }
            try {
                $this->where('id', $aid)->update(['status' => 2, 'msg' => $msg, 'reply_time' => date('Y-m-d H:i:s', time())]);
            } catch (Exception $e) {
                $this->error = $e->getData();
                return false;
            }
            return true;
        }
    }
}
