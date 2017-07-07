<?php
namespace app\admin\model;

use think\Model;
use app\common\model\Association as AssociationM;

class ApplySa extends Model
{
    protected $table = 'sa_applysa';
    protected $pk    = 'id';

    public $error;
    public $result;

    /**
     * 设置申请
     * @param  integer $aid 申请编号
     * @param  integer $uid 用户编号
     * @param  string  $msg 原因
     * @return bool         是否操作成功
     */
    public function setApply($aid = 0, $uid = 0, $status = 2, $msg = '')
    {
        $aid = intval($aid);
        // 所设置的申请编号为0时，通过用户编号设置所有申请
        if ($aid === 0) {
            $uid = intval($uid);
            if ($uid === 0 || User::get($uid) === null) {
                $this->error = '用户编号不存在！';
                return false;
            }
            try {
                $this->where(['uid' => $uid, 'status' => 0])->update(['status' => $status, 'msg' => $msg, 'reply_time' => date('Y-m-d H:i:s', time())]);
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
                $this->where('id', $aid)->update(['status' => $status, 'msg' => $msg, 'reply_time' => date('Y-m-d H:i:s', time())]);
                if ($status===1) {
                    $as = new AssociationM;
                    $applysa = $this->get($aid);
                    $as->createAssociation(User::get($applysa['uid']),$applysa['sname']);
                }
            } catch (Exception $e) {
                $this->error = $e->getData();
                return false;
            }
            return true;
        }
    }
}
