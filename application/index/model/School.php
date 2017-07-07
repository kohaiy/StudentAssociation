<?php
namespace app\index\model;

use think\Model;

class School extends Model
{

    protected $table = 'sa_school';
    protected $pk    = 'sid';

    public $error;
    public $result;

    public function getSchoolListByCid($cid = 0)
    {
        $cid = intval($cid);
        if ($cid < 1) {
            $this->error = '所属城市' . $cid . '不存在！';
            return false;
        }
        $this->result = $this->where('cid', $cid)->order('sname asc')->select();
        return $this->result;
    }
}
