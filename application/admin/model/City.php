<?php
namespace app\admin\model;

use app\admin\model\Province as ProvinceM;
use think\Model;

class City extends Model
{
    protected $table = 'sa_city';
    protected $pk    = 'cid';

    public $error;
    public $result;

    public function getCityListByPid($pid = 0)
    {
        $pid = intval($pid);
        if ($pid < 1) {
            $this->error = '所属省份' . $pid . '不存在！';
            return false;
        }
        $this->result = $this->where('pid', $pid)->order('cname asc')->select();
        return $this->result;
    }

    public function add($pid, $name = '')
    {
        $pid = intval($pid);
        if ($pid < 0 || ProvinceM::get($pid) === null) {
            $this->error = '所属省份' . $pid . '不存在！';
            return false;
        }
        $name = trim($name);
        if (strlen($name) < 2 || strlen($name) > 50) {
            $this->error = '城市名称为2-15字符！';
            return false;
        }
        if ($this->where(['cname' => $name, 'pid' => $pid])->find() !== null) {
            $this->error = '该城市已经存在了！';
            return false;
        }
        try {
            $this->save(['cname' => $name, 'pid' => $pid]);
        } catch (Exception $e) {
            $this->error = $e->getData();
            return false;
        }

        return true;
    }
}
