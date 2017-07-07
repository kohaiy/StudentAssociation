<?php
namespace app\common\model;

use app\admin\model\User;
use think\Model;

class Manager extends Model
{
    protected $table = 'sa_manager';
    protected $pk    = 'id';
    protected $type  = [
        'id'   => 'integer',
        'aid'  => 'integer',
        'uid'  => 'integer',
        'role' => 'integer',
    ];

    public $error;
    public $result;

    public function addManager($aid, $uid, $role = 1)
    {
        try {
            $this->save([
                'aid'  => $aid,
                'uid'  => $uid,
                'role' => $role,
            ]);
            $userM = new User;
            $userM->where('uid', $uid)->update(['aid' => $aid]);
        } catch (Exception $e) {
            $this->error = $e->getData();
            return false;
        }
        return true;
    }
}
